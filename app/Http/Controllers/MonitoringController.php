<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\Journal;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\StudentMentor;
use App\Models\StudentReport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ApplicationLetter;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function index($app_letter_id = 0){
        $monitorings = Monitoring::where('application_letter_id', $app_letter_id)->get();
        
        // Absensi
        $applicationLetterNumber = ApplicationLetter::findOrFail($app_letter_id)->letter_number;
        $applicationLetters = ApplicationLetter::with('student')->where('letter_number', $applicationLetterNumber)->get();
        $attendances = [];
        foreach($applicationLetters as $data){
            array_push($attendances, ...Attendance::with('student')->where('student_id', $data->student->id)->get());
        }

        if(Auth::user()->role == "TEACHER"){
            $mentor = Mentor::where('teacher_id', Auth::user()->information->id)->get()->first();
            $studentMentors = StudentMentor::where('mentor_id', $mentor->id)->get();

            $studentMentorsId = [];
            foreach($studentMentors as $studentMentor){
                array_push($studentMentorsId, $studentMentor->student->id);
            }

            $attendances = collect($attendances)->filter(function($attendance) use ($studentMentorsId){
                return in_array($attendance->student_id, $studentMentorsId);
            });

            $journals = Journal::with('student')->where('application_letter_id', $app_letter_id)->orderBy('date', 'DESC')->get();

            $reports = StudentReport::with('student')->get();
            return view('monitoring.index',[
                'title' => "Monitoring Magang",
                'menu' => "home",
                'journals' => $journals,
                'monitorings' => $monitorings,
                'app_letter_id' => $app_letter_id,
                'attendances' => $attendances,
                'reports' => $reports
            ]);
        }else{
            $journals = Journal::where('application_letter_id', $app_letter_id)->orderBy('date', 'DESC')->get();

            return view('monitoring.admin-index',[
                'title' => "Monitoring Magang",
                'menu' => "monitoring",
                'journals' => $journals,
                'monitorings' => $monitorings
            ]);
        }
    }

    public function index_admin(){
        $monitorings = Monitoring::with('teacher', 'application_letter')->orderBy('date', 'DESC')->get();

        $attendances = Attendance::with('student', 'application_letter')->orderBy('date', 'DESC')->get();
        $attendances = Attendance::select('students.name as student', 'agencies.name as agency', 'attendances.*')
                                    ->join('students', 'students.id' , '=', 'attendances.student_id')
                                    ->join('application_letters', 'application_letters.student_id' , '=', 'students.id')
                                    ->join('agencies', 'agencies.id' , '=', 'application_letters.agency_id')
                                    ->get();

        $journals = Journal::with('student', 'application_letter')->orderBy('date', 'DESC')->get();

        return view('monitoring.admin-index', [
            'menu' => 'monitoring',
            'title' => 'Monitoring Magang',
            'monitorings' => $monitorings,
            'attendances' => $attendances,
            'journals' => $journals
        ]);
    }

    public function create($app_letter_id){
        return view('monitoring.create',[
            'title' => "Tambah Monitoring Magang",
            'menu' => "home",
            'app_letter_id' => $app_letter_id
        ]);
    }

    public function store(Request $request, $app_letter_id){
        Monitoring::create([
            'date' => date('Y-m-d', strtotime($request->monitoring_date)),
            'description' => $request->monitoring,
            'application_letter_id' => $app_letter_id,
            'teacher_id' => Auth::user()->information->id
        ]);

        return redirect(route('app-letter.monitoring.index', ['id' => $app_letter_id]))->with('success', 'Berhasil Menambahkan Data Monitoring');
    }

    public function edit($app_letter_id, $monitoring_id){
        return view('monitoring.create',[
            'title' => "Tambah Monitoring Magang",
            'menu' => "home",
            'app_letter_id' => $app_letter_id,
            'monitoring' => Monitoring::findOrFail($monitoring_id)
        ]);
    }

    public function update(Request $request, $app_letter_id, $monitoring_id){
        $monitoring = Monitoring::findOrFail($monitoring_id);
        $monitoring->date = date('Y-m-d', strtotime($request->monitoring_date));
        $monitoring->description = $request->monitoring;
        $monitoring->save();

        return redirect(route('app-letter.monitoring.index', ['id' => $app_letter_id]))->with('success', 'Berhasil Mengubah Data Monitoring');
    }

    public function delete($app_letter_id, $monitoring_id){
        Monitoring::findOrFail($monitoring_id)->delete();
        return redirect(route('app-letter.monitoring.index', ['id' => $app_letter_id]))->with('success', 'Berhasil Menghapus Data Monitoring');
    }

    public function print($app_letter_id){
        $monitorings = Monitoring::where('application_letter_id', $app_letter_id)->get();
        $data = [
            'data' => $monitorings,
            'title' => "Monitoring Siswa Magang"
        ];

        $pdf = Pdf::loadView('report.monitoring', $data);
        return $pdf->stream('Monitoring Kegiatan Magang.pdf');
    }

    public function printAll(){
        $monitorings = Monitoring::with('teacher', 'application_letter')->orderBy('date', 'DESC')->get();
        $data = [
            'data' => $monitorings,
            'title' => "Monitoring Magang Siswa"
        ];
        
        $pdf = Pdf::loadView('report.monitoring-all', $data);
        return $pdf->stream('Monitoring Magang Siswa.pdf');
    }
}
