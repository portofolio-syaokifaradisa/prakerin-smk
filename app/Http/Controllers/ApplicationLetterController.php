<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Agency;
use App\Models\GradeClass;
use Illuminate\Http\Request;
use App\Models\StudentMentor;
use App\Models\ApplicationLetter;
use Illuminate\Support\Facades\Auth;

class ApplicationLetterController extends Controller
{
    protected $menu = 'application-letter';

    public function accept(Request $request, $data){
        $dates = explode(' - ',$request->date_range);
        
        try{
            $data = explode('.', $data);
            $letters = ApplicationLetter::whereYear('created_at', $data[1])->where('agency_id', $data[0])->get();

            foreach($letters as $letter){
                $letter->status = "PENDING";
                $letter->start_date = $dates[0];
                $letter->end_date = $dates[1];
                $letter->save();
            }
        }catch(Exception $e){
            return redirect(Route('home'))->with('error', 'Menerima Surat Ajuan Gagal, Silahkan Coba Lagi!');
        }

        return redirect(Route('home'))->with('success', 'Sukses Menerima Ajuan Surat Permohonan!');
    }

    public function finalization(Request $request, $data){
        try{
            $data = explode('.',$data);
            $letters = ApplicationLetter::whereYear('created_at', $data[1])->where('agency_id', $data[0])->get();

            foreach($letters as $letter){
                $letter->letter_number = $request->letter_number;
                $letter->status = "COMPLETE";
                $letter->save();
            }
        }catch(Exception $e){
            return redirect(Route('home'))->with('error', 'Menyelesaikan Surat Ajuan Gagal, Silahkan Coba Lagi!');
        }

        return redirect(Route('home'))->with('success', 'Sukses Menyelesaikan Ajuan Surat Permohonan!');
    }

    public function responseLetter(Request $request, $id){
        try{
            $letter = ApplicationLetter::findOrFail($id);

            $file = $request->file('file');
            $destinationPath = 'uploads/response_letter';
    
            $letterNumber = str_replace("/","_", $letter->letter_number);
            $file->move($destinationPath, $letterNumber.'.'.$file->getClientOriginalExtension());
            return redirect(Route('home'))->with('success', 'Sukses Mengupload Surat Balasan!');
        }catch(Exception $e){
            return redirect(Route('home'))->with('error', 'Gagal Upload File Surat Balasan, Silahkan Coba Lagi!');
        }
    }

    public function downloadResponseLetter($letter_number){
        $letterNumber = str_replace("/","_", $letter_number);
        $filepath = public_path('uploads/response_letter/'.$letterNumber.'.pdf');
        return Response()->download($filepath);
    }

    public function show($id){
        $letter = ApplicationLetter::findorFail($id);
        return json_encode($letter);
    }

    public function create(){
        $agencies = Agency::with('region')->OrderBy('name')->get();
        return view('letter.application.create',[
            'title' => "Pengajuan Surat Permohonan",
            'agency' => $agencies,
            'menu' => $this->menu
        ]);
    }

    public function store(Request $request){
        try{
            $agency = Agency::find($request->agency_id);
            if($agency->current_limit === $agency->limit){
                return redirect(Route('app-letter-create'))->with('error', 'Batas Kuota Siswa Sudah Tercukupi, Silahkan Pilih Tempat Lain!');
            }

            ApplicationLetter::create([
                'agency_id' => $request->agency_id,
                'student_id' => Auth::user()->Information->id,
                'status' => 'DELIVERED'
            ]);
        }catch(Exception $e){
            return redirect(Route('app-letter-create'))->with('error', 'pengajuan gagal, Silahkan Coba Lagi!');
        }

        return redirect(Route('home'))->with('success', 'Sukses Mengajukan Surat Permohonan!');
    }

    public function update(Request $request, $id){
        try{
            $letter = ApplicationLetter::findOrFail($id);
            $letter->agency_id = $request->agency_id;
            $letter->save();
        }catch(Exception $e){
            return redirect(Route('home'))->with('error', 'gagal mengubah pengajuan, silahkan coba lagi!');   
        }

        return redirect(Route('home'))->with('success', 'Sukses mengubah pengajuan!');   
    }

    public function delete($id){
        try {  
            $letter = ApplicationLetter::findOrFail($id);
            $letter->delete();
        }catch (Exception $e) {  
            return redirect(Route('home'))->with('error', 'gagal menghapus pengajuan, silahkan coba lagi!');   
        }  

        return redirect(Route('home'))->with('success', 'Sukses menghapus pengajuan!');   
    }

    public function makeColaborationLetter($agencyId){
        $agency = Agency::findOrFail($agencyId);

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('word_templates/Kerjasama.docx');

        $templateProcessor->setValues([
            'leader' => $agency->leader,
            'agency' => $agency->name,
            'address' => $agency->address,
            'phone' => $agency->phone
        ]);

        header("Content-Disposition: attachment; filename=Surat Kerjasama ". $agency->name .".docx");
        $templateProcessor->saveAs('php://output');
    }

    public function makeRequestletter($data){
        $data = explode('.',$data);
        $letters = ApplicationLetter::with('agency', 'student')->whereYear('created_at', $data[1])->where('agency_id', $data[0])->get();

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('word_templates/Permohonan.docx');

        $templateProcessor->setValues([
            'start-date' => $letters->first()->start_date,
            'end-date' => $letters->first()->end_date,
            'agency' => $letters->first()->agency->name,
            'leader-name' => $letters->first()->agency->leader,
            'leader-nip' => $letters->first()->agency->nip,
            'address' => $letters->first()->agency->address,
            'phone' => $letters->first()->agency->phone
        ]);

        $students = [];
        foreach($letters as $letter){
            $class = GradeClass::with('department')->findOrFail($letter->student->grade_class_id);
            array_push($students, [
                'name' => $letter->student->name,
                'class' => $class->grade,
                'department' => $class->department->name
            ]);
        }

        $templateProcessor->cloneRow('s-num', count($students));
        for($i = 0; $i < count($students); $i++){
            $templateProcessor->setValue('s-num#'.($i+1), ($i+1));
            $templateProcessor->setValue('s-name#'.($i+1), $students[$i]['name']);
            $templateProcessor->setValue('s-class#'.($i+1), $students[$i]['class']);
            $templateProcessor->setValue('s-department#'.($i+1), $students[$i]['department']);
        }

        $mentors = [];
        foreach($letters as $letter){
            $student_id = $letter->student->id;

            $mentoring = StudentMentor::where(['student_id' => $student_id])->get()->first();

            if(!isset($mentoring)){
                return redirect(Route('home'))->with('error', 'Gagal Mencetak Surat Permohonan, ' . $letter->student->name . " (". $letter->student->nisn .") Belum Memiliki Guru Pembimbing!");
            }

            $isMentorExists = false;
            if(count($mentors) != 0){
                foreach($mentors as $mentor){
                    if($mentor['id'] === $mentoring->mentor->teacher->id){
                        $isMentorExists = true;
                        break;
                    }
                }
            }

            if(!$isMentorExists){
                array_push($mentors, [
                    'id' => $mentoring->mentor->teacher->id,
                    'name' => $mentoring->mentor->teacher->name,
                    'nip' => $mentoring->mentor->teacher->nip,
                    'position' => $mentoring->mentor->teacher->position
                ]);
            }
        }
        
        $templateProcessor->cloneRow('m-num', count($mentors));
        for($i = 0; $i < count($mentors); $i++){
            $templateProcessor->setValue('m-num#'.($i+1), ($i+1));
            $templateProcessor->setValue('m-name#'.($i+1), $mentors[$i]['name']);
            $templateProcessor->setValue('m-nip#'.($i+1), $mentors[$i]['nip']);
            $templateProcessor->setValue('m-pos#'.($i+1), $mentors[$i]['position']);
        }

        header("Content-Disposition: attachment; filename=Surat Permohonan" . $letters->first()->agency->name . ".docx");
        $templateProcessor->saveAs('php://output');
    }

    public function makeIntroductionLetter($data){
        $data = explode('.',$data);
        $letters = ApplicationLetter::with('agency', 'student')->whereYear('created_at', $data[1])->where('agency_id', $data[0])->get();

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('word_templates/Pengantar.docx');

        $students = [];
        foreach($letters as $letter){
            $class = GradeClass::with('department')->findOrFail($letter->student->grade_class_id);
            array_push($students, [
                'name' => $letter->student->name,
                'nisn' => $letter->student->nisn,
                'class' => $class->grade,
                'department' => $class->department->name
            ]);
        }

        $templateProcessor->cloneRow('num', count($students));
        for($i = 0; $i < count($students); $i++){
            $templateProcessor->setValue('num#'.($i+1), ($i+1));
            $templateProcessor->setValue('name#'.($i+1), $students[$i]['name']);
            $templateProcessor->setValue('nisn#'.($i+1), $students[$i]['nisn']);
            $templateProcessor->setValue('class#'.($i+1), $students[$i]['class']);
            $templateProcessor->setValue('department#'.($i+1), $students[$i]['department']);
        }

        $templateProcessor->setValues([
            'start-date' => $letters->first()->start_date,
            'end-date' => $letters->first()->end_date,
            'agency' => $letters->first()->agency->name,
            'leader' => $letters->first()->agency->leader,
            'total' => count($students)
        ]);

        header("Content-Disposition: attachment; filename=Surat Pengantar " . $letters->first()->agency->name . ".docx");
        $templateProcessor->saveAs('php://output');
    }
}
