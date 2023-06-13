<?php

namespace App\Http\Controllers;

use App\Models\StudentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentReportController extends Controller
{
    public function store(Request $request){
        StudentReport::create([
            'title' => $request->title,
            'student_id' => Auth::user()->information->id
        ]);

        return redirect(route('app-letter.journal.index', ['id' => $request->letter_id]));
    }

    public function update(Request $request, $id){
        $report = StudentReport::findOrFail($id);
        $report->status = "PENDING";
        $report->title = $request->title;
        $report->save();

        return redirect(route('app-letter.journal.index', ['id' => $request->letter_id]));
    }

    public function accept($application_letter_id, $id){
        $report = StudentReport::findOrFail($id);
        $report->status = "ACCEPTED";
        $report->save();
        return redirect(route('app-letter.monitoring.index', ['id' => $application_letter_id]))->with('success', 'Berhasil Menerima Judul Laporan');
    }
    
    public function refuse($application_letter_id, $id){
        $report = StudentReport::findOrFail($id);
        $report->status = "REJECTED";
        $report->save();
        return redirect(route('app-letter.monitoring.index', ['id' => $application_letter_id]))->with('success', 'Berhasil Menolak Judul Laporan');
    }

    public function report(){
        $reports = StudentReport::with('student')->get();

        $data = [
            'data' => $reports,
            'title' => "Daftar Judul Laporan"
        ];

        $pdf = Pdf::loadView('report.student-report-title', $data);
    
        return $pdf->stream('Daftar Judul Laporan.pdf');
    }
}
