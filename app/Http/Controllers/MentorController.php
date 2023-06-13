<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Mentor;
use App\Models\Region;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MentorController extends Controller
{
    protected $menu = 'mentor';

    public function index(){
        $mentors = Mentor::with('teacher', 'region')->get();

        return view('mentor.index',[
            'title' => "Manajemen Guru Pembimbing",
            'mentor' => $mentors,
            'menu' => $this->menu
        ]);
    }

    public function allMentor(){
        return json_encode(Mentor::with('teacher', 'region')->get());
    }

    public function show($id){
        return json_encode(Mentor::findOrFail($id));
    }

    public function create(){
        $teacher = Teacher::all();
        $region = Region::all();

        return view('mentor.create',[
            'title' => "Tambah Guru Pembimbing",
            'teacher' => $teacher,
            'region' => $region,
            'menu' => $this->menu
        ]);
    }

    public function store(Request $request){
        try{
            Mentor::create([
                'teacher_id' => $request->teacher_id,
                'region_id' => $request->region_id
            ]);
        }catch(Exception $e){
            return redirect(Route('mentor-create'))->with('error', 'Gagal Menambah Guru Pembimbing, silahkan coba lagi!');
        }
        return redirect(Route('mentor'))->with('success', 'Sukses Menambah Guru Pembimbing!');
    }

    public function update(Request $request, $id){
        try{
            $mentor = Mentor::findOrFail($id);
            $mentor->teacher_id = $request->teacher_id;
            $mentor->region_id = $request->region_id;
            
            $mentor->save();
        }catch(Exception $e){
            dd($e);
            return redirect(Route('mentor'))->with('error', 'Gagal mengubah Guru Pembimbing, silahkan coba lagi!');
        }
        return redirect(Route('mentor'))->with('success', 'Sukses Mengubah Guru Pembimbing!');
    }

    public function delete($id){
        try{
            $mentor = Mentor::findOrFail($id);
            $mentor->delete();
        }catch(Exception $e){
            return redirect(Route('mentor'))->with('error', 'Gagal Menghapus Guru Pembimbing, silahkan coba lagi!');
        }
        return redirect(Route('mentor'))->with('success', 'Sukses Menghapus Guru Pembimbing!');
    }

    public function print(){
        $mentors = Mentor::with('teacher', 'region')->get();

        $data = [
            'data' => $mentors,
            'title' => "Daftar Guru Pembimbing"
        ];

        $pdf = Pdf::loadView('report.mentor', $data);
    
        return $pdf->stream('Daftar Guru Pembimbing.pdf');
    }
}
