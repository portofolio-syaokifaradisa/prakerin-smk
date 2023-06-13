<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentStoreRequest;
use Exception;
use App\Models\User;
use App\Models\Student;
use App\Models\GradeClass;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    protected $menu = 'student';

    public function index(){
        $students = DB::table('students')
                        ->join('grade_classes', 'students.grade_class_id', '=', 'grade_classes.id')
                        ->join('departments', 'grade_classes.department_id', '=', 'departments.id')
                        ->join('users', 'students.user_id', '=', 'users.id')
                        ->select('students.name as name', 'departments.name as department', 'grade', 'nisn', 'email', 'students.created_at as date', 'students.id as id')
                        ->where('students.deleted_at', '=', NULL)
                        ->get();

        return view('account.student.index',[
            'title' => "Manajemen Akun Siswa",
            'student' => $students,
            'menu' => $this->menu
        ]);
    }

    public function allStudent(){
        $students = Student::orderBy('name')->get();
        return json_encode($students);
    }

    public function show($id){
        return json_encode(Student::with('user')->findOrFail($id));
    }

    public function create(){
        return view('account.student.create',[
            'title' => 'Tambah Akun Siswa',
            'class' => GradeClass::orderBy('grade')->get(),
            'menu' => $this->menu,
            'method' => 'create'
        ]);
    }

    public function store(StudentStoreRequest $request){
        $request_validated = $request->validated();

        try{
            $user = User::create([
                'email' => $request_validated['email'],
                'password' => Hash::make($request_validated['password']),
                'role' => 'STUDENT'
            ]);

            Student::create([
                'name' => $request_validated['name'],
                'nisn' => $request_validated['nisn'],
                'grade_class_id' => $request->class_id,
                'user_id' => $user->id
            ]);
        }catch(Exception $e){
            return redirect(Route('student-create'))->with('error', 'Gagal Menambah Akun, silahkan coba lagi!');
        }

        return redirect(Route('student'))->with('success', 'Sukses Menambah Akun!');
    }

    public function edit($id){
        $student = Student::findOrFail($id);
        return view('account.student.create',[
            'title' => 'Tambah Akun Siswa',
            'class' => GradeClass::orderBy('grade')->get(),
            'menu' => $this->menu,
            'student' => $student,
            'method' => 'edit'
        ]);
    }

    public function update(Request $request, $id){
        try{
            $student = Student::findOrFail($id);
            $student->name = $request->name;
            $student->nisn = $request->nisn;
            $student->grade_class_id = $request->class_id;

            $user = User::findOrFail($student->user_id);
            $user->email = $request->email;

            if(isset($request->password)){
                $user->password = $request->password;
            }

            $user->save();
            $student->save();
        }catch(Exception $e){
            return redirect(Route('student'))->with('error', 'Gagal Mengubah Akun, silahkan coba lagi!');
        }

        return redirect(Route('student'))->with('success', 'Sukses Mengubah Akun!');
    }

    public function delete($id){
        try{
            $student = Student::findOrFail($id);
            $user = User::findOrFail($student->user_id);

            $user->delete();
            $student->delete();
        }catch(Exception $e){
            return redirect(Route('student'))->with('error', 'Gagal Menghapus Akun, silahkan coba lagi!');
        }

        return redirect(Route('student'))->with('success', 'Sukses Menghapus Akun!');
    }

    public function print(){
        $students = DB::table('students')
                        ->join('grade_classes', 'students.grade_class_id', '=', 'grade_classes.id')
                        ->join('departments', 'grade_classes.department_id', '=', 'departments.id')
                        ->join('users', 'students.user_id', '=', 'users.id')
                        ->select('students.name as name', 'departments.name as department', 'grade', 'nisn', 'email', 'students.created_at as date', 'students.id as id')
                        ->where('students.deleted_at', '=', NULL)
                        ->get();

        $data = [
            'data' => $students,
            'title' => "Daftar Akun Siswa"
        ];

        $pdf = Pdf::loadView('report.student', $data);
    
        return $pdf->stream('Daftar Akun Siswa.pdf');
    }
}
