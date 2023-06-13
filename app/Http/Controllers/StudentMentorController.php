<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\Student;
use App\Models\StudentMentor;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentMentorController extends Controller
{
    protected $menu = 'mentoring';

    public function index(){
        $mentor = StudentMentor::select(
                        'student_mentors.id as mentor_id',
                        'students.name as student', 
                        'students.nisn as nisn', 
                        'student_department.name as student_department', 
                        'regions.name as region', 
                        'regions.city as city', 
                        'teachers.name as teacher', 
                        'teachers.nip as nip', 
                        'teacher_department.name as teacher_department',
                        'student_grade.grade as student_grade',
                        'student_department.name as student_department',
                    )->join('students', 'students.id' , '=', 'student_mentors.student_id')
                    ->join('mentors', 'mentors.id' , '=', 'student_mentors.mentor_id')
                    ->join('regions', 'regions.id' , '=', 'mentors.region_id')
                    ->join('teachers', 'teachers.id' , '=', 'mentors.teacher_id')
                    ->join('grade_classes as student_grade', 'students.grade_class_id', '=', 'student_grade.id')
                    ->join('departments as student_department', 'student_grade.department_id', '=', 'student_department.id')
                    ->join('grade_classes as teacher_grade', 'students.grade_class_id', '=', 'teacher_grade.id')
                    ->join('departments as teacher_department', 'teacher_grade.department_id', '=', 'teacher_department.id')
                    ->get();

        return view('studentMentor.index',[
            'title' => "Pembimbing Siswa Magang",
            'mentor' => $mentor,
            'menu' => $this->menu
        ]);
    }

    public function show($id){
        return json_encode(StudentMentor::findOrFail($id));
    }

    public function create(){
        $mentor = Mentor::with('teacher', 'region')->get();
        $student = Student::orderBy('name')->get();

        return view('studentMentor.create',[
            'title' => "Penentuan Pembimbing Siswa Magang",
            'mentor' => $mentor,
            'student' => $student,
            'menu' => $this->menu
        ]);
    }

    public function store(Request $request){
        try{
            StudentMentor::create([
                'student_id' => $request->student_id,
                'mentor_id' => $request->mentor_id
            ]);
        }catch(Exception $e){
            return redirect(Route('mentoring-create'))->with('error', 'Gagal Menetapkan Pembimbing Siswa, silahkan coba lagi!');
        }

        return redirect(Route('mentoring'))->with('success', 'Sukses Menetapkan Pembimbing Siswa!');
    }

    public function update(Request $request, $id){
        try{
            $mentoring = StudentMentor::findOrFail($id);
            $mentoring->student_id = $request->student_id;
            $mentoring->mentor_id = $request->mentor_id;

            $mentoring->save();
        }catch(Exception $e){
            return redirect(Route('mentoring-create'))->with('error', 'Gagal Menetapkan Pembimbing Siswa, silahkan coba lagi!');
        }

        return redirect(Route('mentoring'))->with('success', 'Sukses Menetapkan Pembimbing Siswa!');
    }

    public function delete($id){
        try{
            $mentoring = StudentMentor::findOrFail($id);
            $mentoring->delete();
        }catch(Exception $e){
            return redirect(Route('mentoring'))->with('error', 'Gagal Menghapus Pembimbing Siswa, silahkan coba lagi!');
        }

        return redirect(Route('mentoring'))->with('success', 'Sukses Menghapus Pembimbing Siswa!');
    }

    // Untuk pembimbing
    public function print(){
        $teacher_id = Auth::user()->information->id;
        $mentor = Mentor::with('studentmentor')->where('teacher_id', $teacher_id)->get();

        $data = [];
        foreach($mentor as $mentorData){
            foreach($mentorData->StudentMentor as $mentoring){
                array_push($data, [
                    'student-name' => $mentoring->Student->name,
                    'student-nisn' => $mentoring->student->nisn,
                    'grade-class' => $mentoring->Student->grade_class->grade . ' ' .  $mentoring->Student->grade_class->Department->name,
                    'region' => $mentorData->Region->name,
                    'city' => $mentorData->Region->city,
                    'date' => $mentoring->created_at,
                    'final_score' => ($mentoring->Student->Evaluation->mean_score ?? 0) . " (" . ($mentoring->Student->Evaluation->final_score ?? 'E') . ")",
                    'evaluation' => $mentoring->Student->Evaluation
                ]);
            }
        }

        $data = [
            'data' => $data,
            'title' => "Daftar Bimbingan Siswa Magang"
        ];
        
        $pdf = FacadePdf::loadView('report.mentoring', $data);
        return $pdf->stream('Daftar Bimbingan Siswa Magang '. Auth::user()->information->name .'.pdf');
    }

    // Untuk Admin
    public function generalPrint(){
        $mentor = StudentMentor::with('student', 'mentor')->get();
        $data = [
            'data' => $mentor,
            'title' => "Daftar Bimbingan Siswa Magang"
        ];
        
        $pdf = FacadePdf::loadView('report.general-mentoring', $data);
        return $pdf->stream('Daftar Bimbingan Siswa Magang '. Auth::user()->information->name .'.pdf');
    }
}
