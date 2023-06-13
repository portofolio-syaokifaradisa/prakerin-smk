<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\StudentMentor;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ApplicationLetter;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function in($app_letter_id){
        Attendance::create([
            'date' => date('Y-m-d', strtotime(now())),
            'in' => date('H:m', strtotime(now())),
            'student_id' => Auth::user()->information->id,
            'application_letter_id' => $app_letter_id
        ]);

        return redirect(route('app-letter.journal.index', ['id' => $app_letter_id]))->with('attendance-success', 'Berhasil Absen Pagi');
    }

    public function out($app_letter_id){
        $Attendance = Attendance::where('date', date('Y-m-d', strtotime(now())))->get()->first();
        $Attendance->out = date('H:m', strtotime(now()));
        $Attendance->save();

        return redirect(route('app-letter.journal.index', ['id' => $app_letter_id]))->with('attendance-success', 'Berhasil Absen Sore');
    }

    public function sick($app_letter_id){
        Attendance::create([
            'date' => date('Y-m-d', strtotime(now())),
            'iSick' => true,
            'student_id' => Auth::user()->information->id,
            'application_letter_id' => $app_letter_id
        ]);

        return redirect(route('app-letter.journal.index', ['id' => $app_letter_id]))->with('attendance-success', 'Berhasil Izin Sakit');
    }

    public function create($app_letter_id, $type){
        return view('attendance.create',[
            'title' => 'Konfirmasi ' . ucwords($type) . ' Magang',
            'menu' => 'home',
            'type' => $type,
            'app_letter_id' => $app_letter_id,
        ]); 
    }

    public function store(Request $request, $app_letter_id, $type){
        if($type == "izin"){
            Attendance::create([
                'date' => date('Y-m-d', strtotime(now())),
                'student_id' => Auth::user()->information->id,
                'isPermit' => true,
                'description' => $request->description,
                'application_letter_id' => $app_letter_id
            ]);
        }else if($type = "alpha"){
            Attendance::create([
                'date' => date('Y-m-d', strtotime(now())),
                'student_id' => Auth::user()->information->id,
                'isAlpha' => true,
                'description' => $request->description,
                'application_letter_id' => $app_letter_id
            ]);
        }

        return redirect(route('app-letter.journal.index', ['id' => $app_letter_id]))->with('attendance-success', 'Berhasil Konfirmasi ' . ucwords($type). ' Magang');
    }

    public function print($app_letter_id){
        $Attendances = Attendance::where('student_id', Auth::user()->information->id)->get();

        $data = [
            'data' => $Attendances,
            'title' => "Absensi Magang " . Auth::user()->information->name
        ];
        
        $pdf = Pdf::loadView('report.attendance', $data);
        return $pdf->stream('Absensi Magang ' . Auth::user()->information->name . '.pdf');
    }

    public function printByAppLetter($app_letter_id){
        $applicationLetterNumber = ApplicationLetter::findOrFail($app_letter_id)->letter_number;
        $applicationLetters = ApplicationLetter::with('student')->where('letter_number', $applicationLetterNumber)->get();
        $attendances = [];

        $mentor = Mentor::where('teacher_id', Auth::user()->information->id)->get()->first();
        $studentMentors = StudentMentor::where('mentor_id', $mentor->id)->get();
        
        $studentMentorsId = [];
        foreach($studentMentors as $studentMentor){
            array_push($studentMentorsId, $studentMentor->student->id);
        }

        foreach($applicationLetters as $data){
            if(in_array($data->student->id, $studentMentorsId)){
                array_push($attendances, ...Attendance::with('student')->where('student_id', $data->student->id)->get());
            }
        }

        $data = [
            'data' => $attendances,
            'title' => "Absensi Magang Siswa"
        ];
        
        $pdf = Pdf::loadView('report.attendance_by_app_letter', $data);
        return $pdf->stream('Absensi Magang Siswa.pdf');
    }

    public function printAll(){
        $attendances = Attendance::with('student', 'application_letter')->orderBy('date', 'DESC')->get();
        $data = [
            'data' => $attendances,
            'title' => "Absensi Magang Siswa"
        ];
        
        $pdf = Pdf::loadView('report.attendance-all', $data);
        return $pdf->stream('Absensi Magang Siswa.pdf');
    }
}
