<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Journal;
use App\Models\StudentMentor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\Monitoring;
use App\Models\StudentReport;

class JournalController extends Controller
{
    public function index($appLetterId){
        $journals = Journal::where('application_letter_id', $appLetterId)
                            ->where('student_id', Auth::user()->information->id)
                            ->orderBy('date', 'DESC')->get();

        $attedances = Attendance::where('student_id', Auth::user()->information->id)
                            ->orderBy('date', 'DESC')
                            ->get();

        $attendance = Attendance::where('date', date('Y-m-d', strtotime(now())))
                                ->where('student_id', Auth::user()->information->id)
                                ->get()
                                ->first();

        $monitorings = Monitoring::with('teacher')->where('application_letter_id', $appLetterId)->get();

        $reports = StudentReport::with('student')->get();

        return view('journal.index',[
            'title' => 'Jurnal Kegiatan Siswa Magang',
            'menu' => 'application-letter',
            'journals' => $journals,
            'app_letter_id' => $appLetterId,
            'attedances' => $attedances,
            'attendance' => $attendance,
            'monitorings' => $monitorings,
            'reports' => $reports,
        ]);
    }

    public function create($appLetterId){
        return view('journal.create', [
            'title' => 'Tambah Jurnal Kegiatan Siswa Magang',
            'menu' => 'application-letter',
            'app_letter_id' => $appLetterId
        ]);
    }

    public function store(Request $request, $appLetterId){
        Journal::create([
            'date' => date('Y-m-d', strtotime($request->date)),
            'activity' => $request->activity,
            'application_letter_id' => $appLetterId,
            'student_id' => Auth::user()->information->id
        ]);

        return redirect(route('app-letter.journal.index', ['id' => $appLetterId]))->with('journal-success', 'Sukses Menambahkan Jurnal Kegiatan');
    }

    public function edit($appLetterId, $journal_id){
        $journal = Journal::findOrFail($journal_id);
        return view('journal.create', [
            'title' => 'Edit Jurnal Kegiatan Siswa Magang',
            'menu' => 'application-letter',
            'app_letter_id' => $appLetterId,
            'journal' => $journal
        ]);
    }

    public function update(Request $request, $appLetterId, $journal_id){
        $journal = Journal::findOrFail($journal_id);
        $journal->date = date('Y-m-d', strtotime($request->date));
        $journal->activity = $request->activity;
        $journal->save();

        return redirect(route('app-letter.journal.index', ['id' => $appLetterId]))->with('journal-success', 'Sukses Mengubah Jurnal Kegiatan');
    }

    public function delete($appLetterId, $journal_id){
        Journal::findOrFail($journal_id)->delete();
        return redirect(route('app-letter.journal.index', ['id' => $appLetterId]))->with('journal-success', 'Sukses Menghapus Jurnal Kegiatan');
    }

    public function print($appLetterId){
        if(Auth::user()->role == "STUDENT"){
            $journals = Journal::where('application_letter_id', $appLetterId)
                                ->where('student_id', Auth::user()->information->id)
                                ->orderBy('date', 'DESC')->get();

            $studentMentor = StudentMentor::with('mentor')->where('student_id', Auth::user()->information->id)->get()->first();

            $data = [
                'data' => $journals,
                'title' => "Jurnal Kegiatan " . Auth::user()->information->name,
                'mentor' => $studentMentor->mentor->teacher->name
            ];
        }else{
            $journals = Journal::where('application_letter_id', $appLetterId)
                                ->orderBy('date', 'DESC')->get();

            $data = [
                'data' => $journals,
                'title' => "Jurnal Kegiatan Siswa Magang"
            ];
        }
        
        
        $pdf = Pdf::loadView('report.journals', $data);
        if(Auth::user()->role == "STUDENT"){
            return $pdf->download('Jurnal Kegiatan Magang '. Auth::user()->information->name .'.pdf');
        }else{
            return $pdf->stream('Jurnal Kegiatan Magang.pdf');
        }
    }

    public function printAll(){
        $journals = Journal::with('student', 'application_letter')->orderBy('date', 'DESC')->get();

        $data = [
            'data' => $journals,
            'title' => "Jurnal Magang Siswa"
        ];
        
        $pdf = Pdf::loadView('report.journal-all', $data);
        return $pdf->stream('Jurnal Magang Siswa.pdf');
    }
}
