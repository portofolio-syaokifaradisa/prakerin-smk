<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\StudentMentor;
use App\Models\ApplicationLetter;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $menu = 'home';

    public function index(){
        $role = Auth::user()->role;

        if($role == 'TEACHER'){
            $teacherId = Auth::user()->information->id;
            $mentor = Mentor::where('teacher_id', $teacherId)->get();

            $mentoring = [];
            if(Count($mentor) > 0){
                $mentoring = StudentMentor::where(function($query) use ($mentor){
                    foreach($mentor as $data){
                        $query->orWhere('mentor_id', $data->id);
                    }
                })->get();
            }

            // Mengambil Data Surat Ajuan Magang
            $applicationLetter = [];
            foreach($mentoring as $studentMentor){
                $studentId = $studentMentor->student_id;

                $app_letter_temp = ApplicationLetter::with('agency')->where('student_id', $studentId)
                                ->where('status', 'COMPLETE')
                                ->get()
                                ->first();

                // Mengambil Siswa di tempat magang yang sama dengan satu nomor surat
                $students = [];

                if($app_letter_temp){
                    $app_letter_temps = ApplicationLetter::where('letter_number', $app_letter_temp->letter_number)->get();

                    $mentor = Mentor::where('teacher_id', Auth::user()->information->id)->get()->first();
                    $studentMentors = StudentMentor::where('mentor_id', $mentor->id)->get();

                    $studentMentorsId = [];
                    foreach($studentMentors as $studentMentor){
                        if($studentMentor->student->application_letter[0]->agency_id == $app_letter_temp->agency_id){
                            array_push($studentMentorsId, $studentMentor->student->id);
                        }
                    }

                    foreach($app_letter_temps as $data){
                        if(in_array($data->student->id, $studentMentorsId)){
                            array_push($students, $data->student->name);
                        }
                    }
                    
                    $agency = $app_letter_temp->agency;
                    array_push(
                        $applicationLetter, 
                        [
                            'id' => $app_letter_temp->id,
                            'agency_name' => $agency->name,
                            'agency_region' => $agency->region->name,
                            'students' => $students,
                            'agency_owner' => $agency->leader,
                            'agency_owner_nip' => $agency->nip,
                            'agency_owner_phone' => $agency->phone,
                            'agency_address' => $agency->address
                        ]
                    );
                }
            }

            return view('home.teacher-index', [
                'title' => 'Dashboard Pembimbing',
                'mentor' => $mentoring,
                'menu' => $this->menu,
                'application_letters' => $applicationLetter
            ]);
        }else if($role == "STUDENT"){
            $student_id = Auth::user()->Information->id;
            $letter = ApplicationLetter::where('student_id', $student_id)->get();

            return view('letter.application.student-index',[
                'title' => "Surat Permohonan",
                'letter' => $letter,
                'menu' => $this->menu
            ]); 
        }else if($role == "ADMIN" || $role == "SUPERADMIN"){
            $letter = ApplicationLetter::with('agency','student')->get();
            $letter = $letter->groupBy('agency_id', DB::raw('YEAR(created_at)'));

            return view('letter.application.admin-index',[
                'title' => "Pengajuan Surat Permohonan",
                'letter' => $letter,
                'menu' => $this->menu
            ]);
        }

        return view('layout.app', ['title' => "Dashboard", 'menu' => $this->menu]);
    }
}
