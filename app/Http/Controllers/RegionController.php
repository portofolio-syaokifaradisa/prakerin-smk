<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegionStoreRequest;
use App\Models\Region;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    protected $menu = 'region';

    public function index(){
        $regions = Region::all();

        return view('region.index',[
            'title' => "Manajemen Wilayah",
            'region' => $regions,
            'menu' => $this->menu
        ]);
    }

    public function allRegion(){
        return json_encode(Region::orderBy('name')->get());
    }

    public function show($id){
        return json_encode(Region::findOrFail($id));
    }

    public function create(){
        return view('region.create',[
            'title' => "Tambah Data Wilayah",
            'menu' => $this->menu,
            'method' => 'create'
        ]);
    }

    public function store(RegionStoreRequest $request){
        $request_validated = $request->validated();

        try{
            Region::create(['name' => $request_validated['name'], 'city' => $request_validated['city']]);
        }catch(Exception $e){
            dd($e);
            return redirect(Route('region-create'))->with('error', 'gagal menambah wilayah, silahkan coba lagi!');   
        }

        return redirect(Route('region'))->with('success', 'Sukses mengubah wilayah!');   
    }

    public function edit($id){
        $region = Region::findOrFail($id);
        return view('region.create',[
            'title' => "Tambah Data Wilayah",
            'menu' => $this->menu,
            'region' => $region,
            'method' => 'edit'
        ]);
    }

    public function update(Request $request, $id){
        try{
            $region = Region::findOrFail($id);
            $region->name = $request->name;
            $region->city = $request->city;
            $region->save();
        }catch(Exception $e){
            return redirect(Route('region'))->with('error', 'Gagal mengubah wilayah, silahkan coba lagi!');
        }

        return redirect(Route('region'))->with('success', 'Sukses mengubah wilayah!');
    }

    public function delete($id){
        try{
            $region = Region::findOrFail($id);
            $region->delete();
        }catch(Exception $e){
            return redirect(Route('region'))->with('error', 'Gagal menghapus wilayah, silahkan coba lagi!');
        }

        return redirect(Route('region'))->with('success', 'Sukses menghapus wilayah!');
    }

    public function print(){
        $region = Region::all();

        $data = [
            'data' => $region,
            'title' => "Daftar Wilayah Instansi Magang"
        ];
        
        $pdf = Pdf::loadView('report.region', $data);
        return $pdf->stream('Daftar Wilayah Instansi Magang.pdf');
    }
}
