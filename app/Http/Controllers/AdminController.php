<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreRequest;
use App\Models\Admin;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    protected $menu = "admin";

    public function index(){
        return view('account.admin.index', [
            'title' => "Manajemen Akun Admin",
            'user' => User::where('role', 'ADMIN')->get(),
            'menu' => $this->menu
        ]);
    }

    public function show($id){
        return json_encode(Admin::with('user')->findOrFail($id));
    }

    public function create(){
        return view('account.admin.create',[
            'title' => "Tambah Akun Admin",
            'menu' => $this->menu,
            'method' => 'create'
        ]);
    }

    public function store(AdminStoreRequest $request){
        $request_validated = $request->validated();

        try{
            $user = User::create([
                'email' => $request_validated['email'],
                'password' => Hash::make($request_validated['password']),
                'role' => 'ADMIN'
            ]);

            Admin::create([
                'name' => $request_validated['name'],
                'user_id' => $user->id
            ]);
        }catch(Exception $e){
            return redirect(Route('admin-create'))->with('error', 'Gagal Menambah Akun, silahkan coba lagi!');
        }

        return redirect(Route('admin'))->with('success', 'Sukses Menambah Akun!');
    }

    public function edit($id){
        $admin = Admin::with('user')->findOrFail($id);
        return view('account.admin.create',[
            'title' => "Tambah Akun Admin",
            'menu' => $this->menu,
            'admin' => $admin,
            'method' => 'edit'
        ]);
    }

    public function update(Request $request, $id){
        try{
            $user = User::findOrFail($id);
            $user->email = $request->email;

            if(isset($request->password)){
                $user->password = $request->password;
            }

            $admin = Admin::where('user_id', $id)->first();
            $admin->name = $request->name;

            $user->save();
            $admin->save();
        }catch(Exception $e){
            return redirect(Route('admin'))->with('error', 'Gagal Mengubah Akun, silahkan coba lagi!');
        }

        return redirect(Route('admin'))->with('success', 'Sukses Mengubah Akun!');
    }

    public function delete($id){
        try{
            $user = User::findOrFail($id);
            $user->delete();

            $admin = Admin::where('user_id', $id)->first();
            $admin->delete();
        }catch(Exception $e){
            return redirect(Route('admin'))->with('error', 'Gagal Menghapus Akun, silahkan coba lagi!');
        }

        return redirect(Route('admin'))->with('success', 'Sukses Menghapus Akun!');
    }

    public function print(){
        $admin = User::where('role', 'ADMIN')->get();

        $data = [
            'data' => $admin,
            'title' => "Daftar Akun Admin"
        ];
        
        $pdf = Pdf::loadView('report.admin', $data);
        return $pdf->stream('Daftar Akun Admin.pdf');
    }
}
