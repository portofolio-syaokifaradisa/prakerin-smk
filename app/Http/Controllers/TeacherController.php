<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\TeacherStoreRequest;
use App\Models\GradeClass;

class TeacherController extends Controller
{
    protected $menu = 'teacher';

    public function index(){
        $teachers = DB::table('teachers')
                        ->join('users', 'teachers.user_id', '=', 'users.id')
                        ->select('name', 'email', 'position', 'nip', 'teachers.created_at as date', 'teachers.id as id')
                        ->where('teachers.deleted_at', '=', NULL)
                        ->get();
                        
        return view('account.teacher.index',[
            'title' => "Manajemen Akun Guru",
            'teacher' => $teachers,
            'menu' => $this->menu
        ]);
    }

    public function allTeacher(){
        return json_encode(Teacher::OrderBy('name')->get());
    }

    public function show($id){
        return json_encode(Teacher::with('user')->findOrFail($id));
    }

    public function create(){
        return view('account.teacher.create',[
            'title' => 'Tambah Akun Guru',
            'menu' => $this->menu,
            'method' => 'create',
            'class' => GradeClass::with('department')->orderBy('grade')->get()
        ]);
    }

    public function store(TeacherStoreRequest $request){
        $request_validated = $request->validated();

        try{
            $user = User::create([
                'email' => $request_validated['email'],
                'password' => Hash::make($request_validated['password']),
                'role' => 'TEACHER'
            ]);

            Teacher::create([
                'name' => $request_validated['name'],
                'nip' => $request_validated['nip'],
                'position' => $request_validated['position'],
                'user_id' => $user->id,
                'grade_class_id' => $request_validated['class_id']
            ]);
        }catch(Exception $e){
            return redirect(Route('teacher-create'))->with('error', 'Gagal Menambah Akun, silahkan coba lagi!');
        }

        return redirect(Route('teacher'))->with('success', 'Sukses Menambah Akun!');
    }

    public function edit($id){
        return view('account.teacher.create',[
            'title' => 'Edit Akun Guru',
            'menu' => $this->menu,
            'method' => 'edit',
            'teacher' => Teacher::findOrFail($id),
            'class' => GradeClass::orderBy('grade')->get(),
        ]);
    }

    public function update(Request $request, $id){
        try{
            $teacher = Teacher::findOrFail($id);
            $teacher->name = $request->name;
            $teacher->nip = $request->nip;
            $teacher->position = $request->position;
            $teacher->grade_class_id = $request['class_id'];

            $user = User::findOrFail($teacher->user_id);
            $user->email = $request->email;

            if(isset($request->password)){
                $user->password = $request->password;
            }

            $user->save();
            $teacher->save();
        }catch(Exception $e){
            return redirect(Route('teacher'))->with('error', 'Gagal Mengubah Akun, silahkan coba lagi!');
        }

        return redirect(Route('teacher'))->with('success', 'Sukses Mengubah Akun!');
    }

    public function delete($id){
        try{
            $teacher = Teacher::findOrFail($id);
            $user = User::findOrFail($teacher->user_id);

            $user->delete();
            $teacher->delete();
        }catch(Exception $e){
            return redirect(Route('teacher'))->with('error', 'Gagal Menghapus Akun, silahkan coba lagi!');
        }

        return redirect(Route('teacher'))->with('success', 'Sukses Menghapus Akun!');
    }

    public function print(){
        $teachers = DB::table('teachers')
                        ->join('users', 'teachers.user_id', '=', 'users.id')
                        ->select('name', 'email', 'position', 'nip', 'teachers.created_at as date', 'teachers.id as id')
                        ->where('teachers.deleted_at', '=', NULL)
                        ->get();

        $data = [
            'data' => $teachers,
            'title' => "Daftar Akun Guru"
        ];

        $pdf = Pdf::loadView('report.teacher', $data);
    
        return $pdf->stream('Daftar Akun Guru.pdf');
    }
}
