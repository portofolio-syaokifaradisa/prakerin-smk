<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Student;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function create($studentId){
        return view('evaluation.create', [
            'title' => 'Penilaian Siswa',
            'menu' => 'home',
            'student' => Student::findOrFail($studentId)
        ]);
    }

    public function store(Request $request, $studentId){
        Evaluation::create([
            'student_id' => $studentId,
            'teori' => $request->teori,
            'keterampilan' => $request->keterampilan,
            'keselamatan' => $request->keselamatan,
            'disiplin' => $request->disiplin,
            'sikap' => $request->sikap
        ]);

        return redirect(route('home'))->with('eval-success', 'Berhasil Memberikan Nilai Kepada Siswa');
    }

    public function edit($studentId){
        $student = Student::with('evaluation')->findOrFail($studentId);
        return view('evaluation.create', [
            'title' => 'Penilaian Siswa',
            'menu' => 'home',
            'student' => $student
        ]);
    }

    public function update(Request $request, $studentId){
        $evaluation = Evaluation::where('student_id',$studentId)->get()->first();
        $evaluation->teori = $request->teori;
        $evaluation->keterampilan = $request->keterampilan;
        $evaluation->keselamatan = $request->keselamatan;
        $evaluation->disiplin = $request->disiplin;
        $evaluation->sikap = $request->sikap;
        $evaluation->save();

        return redirect(route('home'))->with('eval-success', 'Berhasil Mengubah Nilai Siswa');
    }
}
