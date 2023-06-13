<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentStoreRequest;
use App\Models\Department;
use App\Models\GradeClass;
use Exception;
use Illuminate\Http\Request;

class GradeClassController extends Controller
{
    protected $menu = 'class';

    public function index(){
        $classes = GradeClass::with('department')->orderBy('grade')->get();
        $departments = Department::orderBy('name')->get();

        return view('gradeClass.index',[
            'title' => "Manajemen kelas dan Jurusan",
            'classes' => $classes,
            'departments' => $departments,
            'menu' => $this->menu
        ]);
    }

    public function allClass(){
        return json_encode(GradeClass::with('department')->get());
    }

    public function allDepartment(){
        return json_encode(Department::orderBy('name')->get());
    }

    public function classShow($id){
        return json_encode(GradeClass::findOrFail($id));
    }

    public function departmentShow($id){
        return json_encode(Department::findOrFail($id));
    }

    public function classCreate(){
        $departments = Department::orderBy('name')->get();

        return view('gradeClass.class-create', [
            'title' => "Tambah Kelas",
            'departments' => $departments,
            'menu' => $this->menu,
            'method' => 'create',
        ]);
    }

    public function classEdit($id){
        $gradeClass = GradeClass::findOrFail($id);
        $departments = Department::orderBy('name')->get();

        return view('gradeClass.class-create', [
            'title' => "Tambah Kelas",
            'departments' => $departments,
            'menu' => $this->menu,
            'gradeClass' => $gradeClass,
            'method' => 'edit',
        ]);
    }

    public function departmentCreate(){
        return view('gradeClass.department-create',[
            'title' => "Tambah Jurusan",
            'method' => 'create',
            'menu' => $this->menu
        ]);
    }

    public function departmentEdit($id){
        $department = Department::findOrFail($id);
        return view('gradeClass.department-create',[
            'title' => "Tambah Jurusan",
            'department' => $department,
            'method' => 'edit',
            'menu' => $this->menu
        ]);
    }

    public function classStore(Request $request){
        try{
            GradeClass::create([
                'grade' => $request->grade,
                'department_id' => $request->department_id
            ]);
        }catch(Exception $e){
            return redirect(Route('class-create'))->with('class-error', 'Gagal Menambah kelas, Silahkan Coba Lagi!');
        }

        return redirect(Route('class'))->with('class-success', 'Sukses Menambah Data kelas');
    }

    public function departmentStore(DepartmentStoreRequest $request){
        $request_validated = $request->validated();

        try{
            Department::create(['name' => $request_validated['name']]);
        }catch(Exception $e){
            return redirect(Route('department-create'))->with('department-error', 'Gagal Menambah Jurusan, Silahkan Coba Lagi!');
        }

        return redirect(Route('class'))->with('department-success', 'Sukses Menambah Data Jurusan');
    }

    public function classUpdate(Request $request, $id){
        try{
            $class = GradeClass::findOrFail($id);
            $class->grade = $request->grade;
            $class->department_id = $request->department_id;
            $class->save();
        }catch(Exception $e){
            return redirect(Route('class'))->with('class-error', 'Gagal Mengubah Kelas, Silahkan Coba Lagi!');
        }

        return redirect(Route('class'))->with('class-success', 'Sukses Mengubah Data Kelas');
    }

    public function departmentUpdate(Request $request, $id){
        try{
            $department = Department::findOrFail($id);
            $department->name = $request->name;
            $department->save();
        }catch(Exception $e){
            return redirect(Route('class'))->with('department-error', 'Gagal Mengubah Jurusan, Silahkan Coba Lagi!');
        }

        return redirect(Route('class'))->with('department-success', 'Sukses Mengubah Data Jurusan');
    }

    public function classDelete($id){
        try{
            $class = GradeClass::findOrFail($id);
            $class->delete();
        }catch(Exception $e){
            return redirect(Route('class'))->with('class-error', 'Gagal Menghapus Kelas, Silahkan Coba Lagi!');
        }

        return redirect(Route('class'))->with('class-success', 'Sukses Menghapus Data Kelas');
    }

    public function departmentDelete($id){
        try{
            $department = Department::findOrFail($id);
            $department->delete();
        }catch(Exception $e){
            return redirect(Route('class'))->with('department-error', 'Gagal Menghapus Jurusan, Silahkan Coba Lagi!');
        }

        return redirect(Route('class'))->with('department-success', 'Sukses Menghapus Data Jurusan');
    }
}
