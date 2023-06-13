<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgencyStoreRequest;
use App\Models\Agency;
use App\Models\Region;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    protected $menu = 'agency';

    public function index(){
        $agencies = Agency::with('region')->orderBy('name')->get();
        $regions = Region::orderBy('name')->get();

        return view('agency.index', [
            'title' => 'Manajemen Instansi',
            'agency' => $agencies,
            'regions' => $regions,
            'menu' => $this->menu
        ]);
    }

    public function allAgency(){
        return json_encode(Agency::with('region')->orderBy('name')->get());
    }

    public function show($id){
        return json_encode(Agency::findorFail($id));
    }

    public function create(){
        $regions = Region::orderBy('name')->get();

        return view('agency.create',[
            'title' => "Tambah Data Industri",
            'region' => $regions,
            'menu' => $this->menu,
            'method' => 'create'
        ]);
    }

    public function store(AgencyStoreRequest $request){
        $request_validated = $request->validated();

        try{
            Agency::create([
                'name' => $request_validated['name'],
                'address' => $request_validated['address'],
                'phone' => $request_validated['phone'],
                'nip' => $request_validated['nip'] ?? '-',
                'leader' => $request_validated['leader'],
                'region_id' => $request->region_id,
                'characteristic' => $request_validated['characteristic']
            ]);
        }catch(Exception $e){
            return redirect(Route('agency'))->with('error', 'Gagal Menambah Industri, Silahkan Coba Lagi!');
        }

        return redirect(Route('agency'))->with('success', 'Sukses Menambah Data Industri');
    }

    public function edit($id){
        $regions = Region::orderBy('name')->get();
        $agency = Agency::findOrFail($id);

        return view('agency.create',[
            'title' => "Edit Data Industri",
            'region' => $regions,
            'menu' => $this->menu,
            'agency' => $agency,
            'method' => 'edit'
        ]);
    }

    public function update(Request $request, $id){
        try{
            $agency = Agency::findOrFail($id);
            $agency->name = $request->name;
            $agency->leader = $request->leader;
            $agency->address = $request->address;
            $agency->phone = $request->phone;
            $agency->region_id = $request->region_id;
            $agency->nip = $request->nip ?? '-';
            $agency->characteristic = $request->characteristic;

            $agency->save();
        }catch(Exception $e){
            return redirect(Route('agency'))->with('error', 'Gagal Mengubah Data Industri, Silahkan Coba Lagi!');
        }

        return redirect(Route('agency'))->with('success', 'Sukses Mengubah Data Industri');
    }

    public function delete($id){
        try{
            $agency = Agency::findOrFail($id);
            $agency->delete();
        }catch(Exception $e){
            return redirect(Route('agency'))->with('error', 'Gagal Menghapus Data Industri, Silahkan Coba Lagi!');
        }

        return redirect(Route('agency'))->with('success', 'Sukses Menghapus Data Industri');
    }

    public function print(){
        $agency = Agency::with('region')->get();

        $data = [
            'data' => $agency,
            'title' => "Daftar Industri Magang"
        ];
        
        $pdf = Pdf::loadView('report.agency', $data);
        return $pdf->stream('Daftar Industri Magang.pdf');
    }
}
