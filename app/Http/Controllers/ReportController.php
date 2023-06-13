<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Mentor;
use App\Models\Region;
use App\Models\Journal;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\Evaluation;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\StudentMentor;
use App\Models\StudentReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function studentTitleReportReview(Request $request){
        if ($request->ajax()) {
            $reports = StudentReport::select('student_reports.*', 'students.name as student', 'students.nisn as nisn', 'departments.name as department')
                                ->join('students', 'students.id', '=', 'student_reports.student_id')
                                ->join('grade_classes', 'students.grade_class_id', '=', 'grade_classes.id')
                                ->join('departments', 'grade_classes.department_id', '=', 'departments.id')
                                ->get();

            return DataTables::collection($reports)->make(true);
        }

        return view('report-menu.student-report-title',[
            'title' => 'Laporan Judul Laporan',
            'menu' => 'title-report'
        ]);
    }

    public function downloadStudentTitleReport(Request $request){
        $reports = StudentReport::select('student_reports.*', 'students.name as student', 'students.nisn as nisn', 'departments.name as department')
                    ->join('students', 'students.id', '=', 'student_reports.student_id')
                    ->join('grade_classes', 'students.grade_class_id', '=', 'grade_classes.id')
                    ->join('departments', 'grade_classes.department_id', '=', 'departments.id');

        if ($request->has('student')) {
            $reports->where('students.name', 'like', "%{$request->get('student')}%");
        }

        if ($request->has('nisn')) {
            $reports->where('students.nisn', 'like', "%{$request->get('nisn')}%");
        }

        if ($request->has('title')) {
            $reports->where('student_reports.title', 'like', "%{$request->get('title')}%");
        }

        if ($request->has('department')) {
            $reports->where('departments.name', 'like', "%{$request->get('department')}%");
        }

        $data = [
            'data' => $reports->get(),
            'title' => "Daftar Judul Laporan"
        ];

        $pdf = Pdf::loadView('report.student-report-title', $data);
    
        return $pdf->stream('Daftar Judul Laporan.pdf');
    }

    public function regionReportReview(Request $request){
        if ($request->ajax()) {
            $regions = Region::all();

            return DataTables::collection($regions)->make(true);
        }

        return view('report-menu.region-report',[
            'title' => 'Laporan Wilayah Magang',
            'menu' => 'region-report'
        ]);
    }

    public function downloadRegionReport(Request $request){
        $regions = Region::select('*');
                                       
        if ($request->has('name')) {
            $regions->where('name', 'like', "%{$request->get('name')}%");
        }

        if ($request->has('city')) {
            $regions->where('city', 'like', "%{$request->get('city')}%");
        }

        $data = [
            'data' => $regions->get(),
            'title' => "Daftar Wilayah Magang"
        ];

        $pdf = Pdf::loadView('report.region', $data);
    
        return $pdf->stream('Daftar Wilayah Magang.pdf');
    }

    public function agencyReportReview(Request $request){
        if ($request->ajax()) {
            $agencies = Agency::select('agencies.*', 'regions.name as region')
                                ->join('regions', 'regions.id', '=', 'agencies.region_id')
                                ->get();

            return DataTables::collection($agencies)->make(true);
        }

        return view('report-menu.agency-report',[
            'title' => 'Laporan Industri Magang',
            'menu' => 'agency-report'
        ]);
    }

    public function downloadAgencyReport(Request $request){
        $agencies = Agency::select('agencies.*', 'regions.name as region')
                                ->join('regions', 'regions.id', '=', 'agencies.region_id');
                                       
        if ($request->has('region')) {
            $agencies->where('regions.name', 'like', "%{$request->get('region')}%");
        }

        if ($request->has('name')) {
            $agencies->where('agencies.name', 'like', "%{$request->get('name')}%");
        }

        if ($request->has('leader')) {
            $agencies->where('leader', 'like', "%{$request->get('leader')}%");
        }

        if ($request->has('nip')) {
            $agencies->where('nip', 'like', "%{$request->get('nip')}%");
        }

        if ($request->has('phone')) {
            $agencies->where('phone', 'like', "%{$request->get('phone')}%");
        }

        if ($request->has('address')) {
            $agencies->where('address', 'like', "%{$request->get('address')}%");
        }

        if ($request->has('characteristic')) {
            $agencies->where('characteristic', 'like', "%{$request->get('characteristic')}%");
        }

        $agencies = $agencies->get();
        $data = [
            'data' => $agencies,
            'title' => "Daftar Industri Magang"
        ];

        $pdf = Pdf::loadView('report.agency', $data);
    
        return $pdf->stream('Daftar Industri.pdf');
    }

    public function studentReportReview(Request $request){
        if ($request->ajax()) {
            $students = Student::select('students.*', 'grade_classes.grade as grade', 'departments.name as department', 'users.email as email')
                            ->join('grade_classes', 'students.grade_class_id', '=', 'grade_classes.id')
                            ->join('departments', 'grade_classes.department_id', '=', 'departments.id')
                            ->join('users', 'students.user_id', '=', 'users.id')->get();

            return DataTables::collection($students)->make(true);
        }

        return view('report-menu.student-report',[
            'title' => 'Laporan Daftar Murid',
            'menu' => 'student-report'
        ]);
    }

    public function downloadStudentAccountReport(Request $request){
        $students = Student::select('students.*', 'grade_classes.grade as grade', 'departments.name as department', 'users.email as email')
                            ->join('grade_classes', 'students.grade_class_id', '=', 'grade_classes.id')
                            ->join('departments', 'grade_classes.department_id', '=', 'departments.id')
                            ->join('users', 'students.user_id', '=', 'users.id');
                          
                            
        if($request->name){
            $students->where('students.name', 'like', "%{$request->name}%");
        }

        if($request->nisn){
            $students->where('students.nisn', 'like', "%{$request->nisn}%");
        }
        
        if($request->grade){
            $students->where('grade_classes.grade', 'like', "%{$request->nisn}%");
        }
        
        if($request->department){
            $students->where('departments.name', 'like', "%{$request->nisn}%");  
        }
        
        if($request->email){
            $students->where('users.email', 'like', "%{$request->nisn}%");
        }

        $data = [
            'data' => $students->get(),
            'title' => "Daftar Siswa"
        ];

        $pdf = Pdf::loadView('report.student', $data);
    
        return $pdf->stream('Daftar Siswa.pdf');
    }

    public function downloadStudentReport(Request $request){
        $students = Student::select('students.*', 'grade_classes.grade as grade', 'departments.name as department')
                            ->join('grade_classes', 'students.grade_class_id', '=', 'grade_classes.id')
                            ->join('departments', 'grade_classes.department_id', '=', 'departments.id')
                            ->join('users', 'students.user_id', '=', 'users.id');
                          
                            
        if($request->name){
            $students->where('students.name', 'like', "%{$request->name}%");
        }

        if($request->nisn){
            $students->where('students.nisn', 'like', "%{$request->nisn}%");
        }
        
        if($request->grade){
            $students->where('grade_classes.grade', 'like', "%{$request->nisn}%");
        }
        
        if($request->department){
            $students->where('departments.name', 'like', "%{$request->nisn}%");  
        }

        $data = [
            'data' => $students->get(),
            'title' => "Daftar Siswa",
            'type' => 'non-account'
        ];

        $pdf = Pdf::loadView('report.student', $data);
    
        return $pdf->stream('Daftar Siswa.pdf');
    }

    public function teacherReportReview(Request $request){
        if ($request->ajax()) {
            $teachers = Teacher::select('teachers.*', 'users.email as email')
                            ->join('users', 'teachers.user_id', '=', 'users.id')->get();

            return DataTables::collection($teachers)->make(true);
        }

        return view('report-menu.teacher-report',[
            'title' => 'Laporan Daftar Guru',
            'menu' => 'teacher-report'
        ]);
    }

    public function downloadTeacherAccountReport(Request $request){
        $teachers = Teacher::select('teachers.*', 'users.email as email')
                            ->join('users', 'teachers.user_id', '=', 'users.id');

        if($request->name){
            $teachers->where('name', 'like', "%{$request->name}%");
        }

        if($request->nip){
            $teachers->where('nip', 'like', "%{$request->nip}%");
        }

        if($request->position){
            $teachers->where('position', 'like', "%{$request->position}%");
        }

        if($request->email){
            $teachers->where('user.email', 'like', "%{$request->email}%");
        }

        $data = [
            'data' => $teachers->get(),
            'title' => "Daftar Guru"
        ];

        $pdf = Pdf::loadView('report.teacher', $data);
    
        return $pdf->stream('Daftar Guru.pdf');
    }

    public function downloadTeacherReport(Request $request){
        $teachers = Teacher::select('teachers.*', 'users.email as email')
                            ->join('users', 'teachers.user_id', '=', 'users.id');

        if($request->name){
            $teachers->where('name', 'like', "%{$request->name}%");
        }

        if($request->nip){
            $teachers->where('nip', 'like', "%{$request->nip}%");
        }

        if($request->position){
            $teachers->where('position', 'like', "%{$request->position}%");
        }

        $data = [
            'data' => $teachers->get(),
            'title' => "Daftar Guru",
            'type' => 'non-account'
        ];

        $pdf = Pdf::loadView('report.teacher', $data);
    
        return $pdf->stream('Daftar Guru.pdf');
    }

    public function mentorReportReview(Request $request){
        if ($request->ajax()) {
            $mentors = Mentor::select('regions.name as region', 'regions.city as city', 'users.email as email', 'teachers.nip as nip', 'teachers.name as name', 'departments.name as department')
                            ->join('teachers', 'teachers.id', '=', 'mentors.teacher_id')
                            ->join('grade_classes', 'grade_classes.id', '=', 'teachers.grade_class_id')
                            ->join('departments', 'departments.id', '=', 'grade_classes.department_id')
                            ->join('regions', 'regions.id', '=', 'mentors.region_id')
                            ->join('users', 'teachers.user_id', '=', 'users.id')->get();

            return DataTables::collection($mentors)->make(true);
        }

        return view('report-menu.mentor-report',[
            'title' => 'Laporan Daftar Guru Pembimbing',
            'menu' => 'mentor-report'
        ]);
    }

    public function downloadMentorReport(Request $request){
        $mentors = Mentor::select('regions.name as region', 'regions.city as city', 'users.email as email', 'teachers.nip as nip', 'teachers.name as name', 'departments.name as department')
                            ->join('teachers', 'teachers.id', '=', 'mentors.teacher_id')
                            ->join('grade_classes', 'grade_classes.id', '=', 'teachers.grade_class_id')
                            ->join('departments', 'departments.id', '=', 'grade_classes.department_id')
                            ->join('regions', 'regions.id', '=', 'mentors.region_id')
                            ->join('users', 'teachers.user_id', '=', 'users.id');

        
        if($request->name){
            $mentors->where('teachers.name', 'like', "%{$request->get('name')}%");
        }

        if($request->department){
            $mentors->where('departments.name', 'like', "%{$request->get('department')}%");
        }

        if($request->nip){
            $mentors->where('teachers.nip', 'like', "%{$request->get('nip')}%");
        }

        if($request->email){
            $mentors->where('users.email', 'like', "%{$request->get('email')}%");
        }

        if($request->region){
            $mentors->where('regions.name', 'like', "%{$request->get('region')}%");
        }

        if($request->city){
            $mentors->where('regions.city', 'like', "%{$request->get('city')}%");
        }

        $data = [
            'data' => $mentors->get(),
            'title' => "Daftar Guru Pembimbing"
        ];

        $pdf = Pdf::loadView('report.mentor', $data);
    
        return $pdf->stream('Daftar Guru Pembimbing.pdf');
    }

    public function mentoringReportReview(Request $request){
        if ($request->ajax()) {
            $mentors = StudentMentor::select('teachers.name as teacher', 'teachers.nip', 'regions.city', 'regions.name as region', 'students.name as student', 'students.nisn', 'departments.name as department')
                                    ->join('mentors', 'mentors.id', '=', 'student_mentors.mentor_id')
                                    ->join('teachers', 'teachers.id', '=', 'mentors.teacher_id')
                                    ->join('regions', 'regions.id', '=', 'mentors.region_id')
                                    ->join('students', 'students.id', '=', 'student_mentors.student_id')
                                    ->join('grade_classes', 'students.grade_class_id', '=', 'grade_classes.id')
                                    ->join('departments', 'grade_classes.department_id', '=', 'departments.id')
                                    ->get();

            return DataTables::collection($mentors)->make(true);
        }

        return view('report-menu.mentoring-report',[
            'title' => 'Laporan Daftar Guru Pembimbing Siswa',
            'menu' => 'mentoring-report'
        ]);
    }

    public function downloadMentoringReport(Request $request){
        $mentors = StudentMentor::select('student_mentors.*', 'teachers.name as teacher', 'teachers.nip', 'regions.city', 'regions.name as region', 'students.name as student', 'students.nisn', 'departments.name as department')
                                    ->join('mentors', 'mentors.id', '=', 'student_mentors.mentor_id')
                                    ->join('teachers', 'teachers.id', '=', 'mentors.teacher_id')
                                    ->join('regions', 'regions.id', '=', 'mentors.region_id')
                                    ->join('students', 'students.id', '=', 'student_mentors.student_id')
                                    ->join('grade_classes', 'students.grade_class_id', '=', 'grade_classes.id')
                                    ->join('departments', 'grade_classes.department_id', '=', 'departments.id');

        if ($request->region) {
            $request->where('regions.name', 'like', "%{$request->get('region')}%");
        }

        if ($request->teacher) {
            $request->where('teachers.name', 'like', "%{$request->get('teacher')}%");
        }

        if ($request->nip) {
            $request->where('teachers.nip', 'like', "%{$request->get('nip')}%");
        }

        if ($request->student) {
            $request->where('students.name', 'like', "%{$request->get('student')}%");
        }

        if ($request->nisn) {
            $request->where('students.nisn', 'like', "%{$request->get('nisn')}%");
        }

        if ($request->department) {
            $request->where('departments.name', 'like', "%{$request->get('department')}%");
        }

        $data = [
            'data' => $mentors->get(),
            'title' => "Daftar Guru Pembimbing Siswa"
        ];

        $pdf = Pdf::loadView('report.mentoring', $data);
    
        return $pdf->stream('Daftar Guru Pembimbing Siswa.pdf');
    }

    public function journalReportReview(Request $request, $id){
            if ($request->ajax()) {
                $journals = Journal::select('journals.*', 'agencies.name as agency', 'students.name as student', 'regions.name as region', 'departments.name as department')
                                        ->join('application_letters', 'application_letters.id' ,'=', 'journals.application_letter_id')
                                        ->join('agencies', 'agencies.id' ,'=', 'application_letters.agency_id')
                                        ->join('regions', 'regions.id' ,'=', 'agencies.region_id')
                                        ->join('students', 'students.id' ,'=', 'journals.student_id')
                                        ->join('grade_classes', 'grade_classes.id' ,'=', 'students.grade_class_id')
                                        ->join('departments', 'departments.id' ,'=', 'grade_classes.department_id')
                                        ->where('students.id', $id)
                                        ->get();

                return DataTables::collection($journals)->make(true);
            }
            return view('report-menu.journal-report',[
                'title' => 'Laporan Jurnal kegiatan',
                'menu' => 'journal-report',
                'student' => Student::findOrFail($id)
            ]);
    }

    public function downloadJournalReport(Request $request, $id){
        $journals = Journal::select('journals.*', 'agencies.name as agency', 'students.name as student', 'regions.name as region', 'departments.name as department')
                                    ->join('application_letters', 'application_letters.id' ,'=', 'journals.application_letter_id')
                                    ->join('agencies', 'agencies.id' ,'=', 'application_letters.agency_id')
                                    ->join('regions', 'regions.id' ,'=', 'agencies.region_id')
                                    ->join('students', 'students.id' ,'=', 'journals.student_id')
                                    ->join('grade_classes', 'grade_classes.id' ,'=', 'students.grade_class_id')
                                    ->join('departments', 'departments.id' ,'=', 'grade_classes.department_id')
                                    ->where('students.id', $id);

        if ($request->date) {
            $journals->where('journals.date', 'like', "%{$request->get('date')}%");
        }

        if ($request->activity) {
            $journals->where('journals.activity', 'like', "%{$request->get('activity')}%");
        }

        $data = [
            'data' => $journals->get(),
            'title' => "laporan Jurnal Kegiatan Siswa"
        ];

        $pdf = Pdf::loadView('report.journal-all', $data);
    
        return $pdf->stream('Laporan Jurnal Kegiatan.pdf');
}

    public function journalSummaryReportReview(Request $request){
        if ($request->ajax()) {
            $datas = Student::select('students.id as student_id', 'students.nisn as nisn', 'students.name as student', 'departments.name as department')
                                    ->join('grade_classes', 'grade_classes.id' ,'=', 'students.grade_class_id')
                                    ->join('departments', 'departments.id' ,'=', 'grade_classes.department_id')
                                    ->get();

            return DataTables::collection($datas)->addColumn('action', function($data){
                return "<a class='text-center' href='". route('report.journal.index', ['id' => $data->student_id]) ."'>Detail<a/>";
            })->addColumn('competence', function($data) {
                $student = Student::with('evaluation')->findOrFail($data->student_id);
                if(empty($student->evaluation)){
                    return "Tidak Mencapai";
                }

                $score = $student->Evaluation->mean_score;
                if($score >= 70){
                    return "Tercapai";
                }else{
                    return "Tidak Mencapai";
                }
            })->rawColumns(['action', 'competence'])->make(true);
        }

        return view('report-menu.journal-summary-report',[
            'title' => 'Laporan Jurnal kegiatan',
            'menu' => 'journal-report'
        ]);
    }

    public function downloadJournalSummaryReport(Request $request){
        $datas = Student::select('students.id as student_id', 'students.nisn as nisn', 'students.name as student', 'departments.name as department')
                                    ->join('grade_classes', 'grade_classes.id' ,'=', 'students.grade_class_id')
                                    ->join('departments', 'departments.id' ,'=', 'grade_classes.department_id');

        if ($request->nisn) {
            $datas->where('students.nisn', 'like', "%{$request->get('nisn')}%");
        }

        if ($request->student) {
            $datas->where('students.name', 'like', "%{$request->get('student')}%");
        }

        if ($request->department) {
            $datas->where('departments.name', 'like', "%{$request->get('department')}%");
        }

        $datas = $datas->get();

        $final_data = [];
        foreach($datas as $data){
            $student = Student::with('evaluation')->findOrFail($data->student_id);
            if(empty($student->evaluation)){
                $competence = "Tidak Mencapai";
            }else{
                $score = $student->Evaluation->mean_score;
                if($score >= 70){
                    $competence = "Tercapai";
                }else{
                    $competence = "Tidak Mencapai";
                }
            }

            $isAppend = true;
            if($request->competence){
                $isAppend = $isAppend && ($competence == $request->competence);
            }

            if($isAppend){
                array_push($final_data, [
                    'nisn' => $data->nisn,
                    'student' => $data->student,
                    'department' => $data->department,
                    'competence' => $competence
                ]);
            }
        }

        $data = [
            'datas' => $final_data,
            'title' => "laporan Jurnal Kegiatan Siswa"
        ];

        $pdf = Pdf::loadView('report.journal-summary', $data);
    
        return $pdf->stream('Laporan Jurnal Kegiatan.pdf');
    }

    public function studentMonitoringReportReview(Request $request){
        if ($request->ajax()) {
            $monitorings = Monitoring::select('monitorings.*', 'teachers.name as teacher', 'regions.name as region', 'agencies.name as agency')
                                    ->join('teachers', 'teachers.id', '=', 'monitorings.teacher_id')
                                    ->join('application_letters', 'application_letters.id', '=', 'monitorings.application_letter_id')
                                    ->join('agencies', 'agencies.id', '=', 'application_letters.agency_id')
                                    ->join('regions', 'regions.id', '=', 'agencies.region_id')
                                    ->get();

            return DataTables::collection($monitorings)->make(true);
        }

        return view('report-menu.student-mentoring',[
            'title' => 'Laporan Bimbingan',
            'menu' => 'monitoring-report'
        ]);
    }

    public function downloadStudentMonitoringReport(Request $request){
        $monitorings = Monitoring::select('monitorings.*', 'teachers.name as teacher', 'regions.name as region', 'agencies.name as agency')
                                    ->join('teachers', 'teachers.id', '=', 'monitorings.teacher_id')
                                    ->join('application_letters', 'application_letters.id', '=', 'monitorings.application_letter_id')
                                    ->join('agencies', 'agencies.id', '=', 'application_letters.agency_id')
                                    ->join('regions', 'regions.id', '=', 'agencies.region_id');

        if ($request->date) {
            $monitorings->where('date', $request->get('date'));
        }

        if ($request->teacher) {
            $monitorings->where('teachers.name', 'like', "%{$request->get('teacher')}%");
        }

        if ($request->region) {
            $monitorings->where('regions.name', 'like', "%{$request->get('region')}%");
        }

        if ($request->agency) {
            $monitorings->where('agencies.name', 'like', "%{$request->get('agency')}%");
        }

        if ($request->description) {
            $monitorings->where('monitorings.description', 'like', "%{$request->get('description')}%");
        }

        $data = [
            'data' => $monitorings->get(),
            'title' => "Laporan Bimbingan Siswa"
        ];

        $pdf = Pdf::loadView('report.monitoring-all', $data);
    
        return $pdf->stream('Laporan Bimbingan Siswa.pdf');
    }

    public function attendanceReportReview(Request $request, $id){
        if($request->ajax()){
            $attendances = Attendance::select('attendances.*', 'students.name as student', 'agencies.name as agency')
                                    ->join('application_letters', 'application_letters.id', '=', 'attendances.application_letter_id')
                                    ->join('agencies', 'agencies.id', '=', 'application_letters.agency_id')
                                    ->join('students', 'students.id', '=', 'attendances.student_id')
                                    ->where('students.id', $id)
                                    ->get();

            return DataTables::collection($attendances)->addColumn('status', function($attendance) {
                if($attendance->isPermit){
                    return "Izin";
                }else if($attendance->isAlpha){
                    return "Alpha";
                }else if($attendance->isSick){
                    return "Sakit";
                }else{
                    return "Hadir";
                }
            })->editColumn('in', function($attendance) {
                return date("H:m", strtotime($attendance->in));
            })->editColumn('out', function($attendance) {
                return date("H:m", strtotime($attendance->out));
            })->make(true);
        }

        $student = Student::findOrFail($id);
        return view('report-menu.attendance-report', [
            'title' => 'Laporan Absensi Siswa',
            'menu' => 'attendance-report',
            'student' => $student
        ]);
    }

    public function downloadAttendanceReport(Request $request, $id){
        $attendances = Attendance::select('attendances.*', 'students.name as student', 'agencies.name as agency')
                        ->join('application_letters', 'application_letters.id', '=', 'attendances.application_letter_id')
                        ->join('agencies', 'agencies.id', '=', 'application_letters.agency_id')
                        ->join('students', 'students.id', '=', 'attendances.student_id')
                        ->where('students.id', $id);

        if ($request->date) {
            $attendances->where('attendances.date', 'like', "%{$request->get('date')}%");
        }

        if ($request->in) {
            $attendances->where('attendances.in', 'like', "%{$request->get('in')}%");
        }

        if ($request->out) {
            $attendances->where('attendances.out', 'like', "%{$request->get('out')}%");
        }

        if ($request->status) {
            $attendances->where('attendances.status', $request->get('status'));
        }

        if ($request->description) {
            $attendances->where('attendances.description', 'like', "%{$request->get('description')}%");
        }

        $attendances = $attendances->get();

        $data = [
            'data' => $attendances,
            'title' => "Laporan Absensi Siswa " . $attendances[0]->student
        ];

        $pdf = Pdf::loadView('report.attendance', $data);
        return $pdf->stream("Laporan Absensi Siswa {$attendances[0]->student}.pdf");
    }

    public function attendanceSummaryReportReview(Request $request){
        if ($request->ajax()) {
            $rawAttendances = DB::table('attendances')->join('application_letters', 'application_letters.id', '=', 'attendances.application_letter_id')
                                    ->join('students', 'students.id', '=', 'attendances.student_id')
                                    ->join('grade_classes', 'grade_classes.id' ,'=', 'students.grade_class_id')
                                    ->join('departments', 'departments.id' ,'=', 'grade_classes.department_id')
                                    ->select('attendances.*', 'students.id as student_id', 'students.name as student', 'students.nisn as nisn', 'departments.name as department');

            $allAttendance = $rawAttendances->get();

            $arrayOfAttendances = [];
            foreach($allAttendance as $attendance){
                if(isset($arrayOfAttendances[$attendance->nisn])){
                    if($attendance->isAlpha){
                        $arrayOfAttendances[$attendance->nisn]['alpha']++;
                    }else if($attendance->isPermit){
                        $arrayOfAttendances[$attendance->nisn]['permit']++;
                    }else if($attendance->isSick){
                        $arrayOfAttendances[$attendance->nisn]['sick']++;
                    }else{
                        $arrayOfAttendances[$attendance->nisn]['present']++;
                    }
                }else{
                    $arrayOfAttendances[$attendance->nisn] = [
                        'student_id' => $attendance->student_id,
                        'student' => $attendance->student,
                        'department' => $attendance->department,
                        'alpha' => $attendance->isAlpha ? 1 : 0,
                        'permit' => $attendance->isPermit ? 1 : 0,
                        'sick' => $attendance->isSick ? 1 : 0,
                        'present' => $attendance->in ? 1 : 0
                    ];
                }
            }

            $collectionOfAttendance = collect();
            foreach($arrayOfAttendances as $nisn => $attendance){
                $collectionOfAttendance->push((object) array(
                    "nisn" => $nisn,
                    'student_id' => $attendance['student_id'],
                    'student' => $attendance['student'],
                    'department' => $attendance['department'],
                    'alpha' => $attendance['alpha'],
                    'permit' => $attendance['permit'],
                    'sick' => $attendance['sick'],
                    'present' => $attendance['present'],
                ));
            }

            return DataTables::collection($collectionOfAttendance)
                            ->addColumn('action', function($attendance){
                                return "<a class='text-center' href='". route('report.attendance.index', ['id' => $attendance->student_id]) ."'>Detail<a/>";
                            })->make(true);
        }

        return view('report-menu.summary-attendance',[
            'title' => 'Laporan Absensi Siswa',
            'menu' => 'attendance-report'
        ]);
    }

    public function downloadAttendanceSummaryReport(Request $request){
        $rawAttendances = DB::table('attendances')->join('application_letters', 'application_letters.id', '=', 'attendances.application_letter_id')
                                    ->join('students', 'students.id', '=', 'attendances.student_id')
                                    ->join('grade_classes', 'grade_classes.id' ,'=', 'students.grade_class_id')
                                    ->join('departments', 'departments.id' ,'=', 'grade_classes.department_id')
                                    ->select('attendances.*', 'students.name as student', 'students.nisn as nisn', 'departments.name as department');

        $allAttendance = $rawAttendances->get();

        $arrayOfAttendances = [];
        foreach($allAttendance as $attendance){
            $isAppend = true;
            if($request->nisn){
                $isAppend = $isAppend && str_contains($attendance->nisn, $request->nisn);
            }

            if($request->student){
                $isAppend = $isAppend && str_contains($attendance->student, $request->student);
            }

            if($request->department){
                $isAppend = $isAppend && str_contains($attendance->department, $request->department);
            }

            if($isAppend){
                if(isset($arrayOfAttendances[$attendance->nisn])){
                    if($attendance->isAlpha){
                        $arrayOfAttendances[$attendance->nisn]['alpha']++;
                    }else if($attendance->isPermit){
                        $arrayOfAttendances[$attendance->nisn]['permit']++;
                    }else if($attendance->isSick){
                        $arrayOfAttendances[$attendance->nisn]['sick']++;
                    }else{
                        $arrayOfAttendances[$attendance->nisn]['present']++;
                    }
                }else{
                    $arrayOfAttendances[$attendance->nisn] = [
                        'student' => $attendance->student,
                        'department' => $attendance->department,
                        'alpha' => $attendance->isAlpha ? 1 : 0,
                        'permit' => $attendance->isPermit ? 1 : 0,
                        'sick' => $attendance->isSick ? 1 : 0,
                        'present' => $attendance->in ? 1 : 0,
                    ];
                }
            }
        }

        $collectionOfAttendance = collect();
        foreach($arrayOfAttendances as $nisn => $attendance){
            $isAppend = true;

            if(!is_null($request->present)){
                $isAppend = $isAppend && ($attendance['present'] == intval($request->present));
            }
            
            if(!is_null($request->alpha)){
                $isAppend = $isAppend && ($attendance['alpha'] == intval($request->alpha));
            }

            if(!is_null($request->permit)){
                $isAppend = $isAppend && ($attendance['permit'] == intval($request->permit));
            }

            if(!is_null($request->sick)){
                $isAppend = $isAppend && ($attendance['sick'] == intval($request->sick));
            }

            if($isAppend){
                $collectionOfAttendance->push((object) array(
                    "nisn" => $nisn,
                    'student' => $attendance['student'],
                    'department' => $attendance['department'],
                    'alpha' => $attendance['alpha'],
                    'permit' => $attendance['permit'],
                    'sick' => $attendance['sick'],
                    'present' => $attendance['present'],
                ));
            }
        }

        $data = [
            'data' => $collectionOfAttendance,
            'title' => "Laporan Absensi Siswa"
        ];

        $pdf = Pdf::loadView('report.attendance-summary', $data);
        return $pdf->stream('Laporan Absensi Siswa.pdf');
    }

    public function evaluationReportReview(Request $request){
        if ($request->ajax()) {
            $students = Student::select('students.id as student_id','students.name as student', 'students.nisn', 'grade_classes.grade as grade', 'departments.name as department')
                            ->join('grade_classes', 'students.grade_class_id', '=', 'grade_classes.id')
                            ->join('departments', 'grade_classes.department_id', '=', 'departments.id')
                            ->get();

            return DataTables::collection($students)
                            ->addColumn('teori', function($student){
                                $evaluation = Evaluation::where('student_id', $student->student_id)->get()->first();
                                if(empty($evaluation)){
                                    return 0;
                                }else{
                                    return $evaluation->teori;
                                }
                            })->addColumn('keterampilan', function($student){
                                $evaluation = Evaluation::where('student_id', $student->student_id)->get()->first();
                                if(!empty($evaluation)){
                                    return $evaluation->keterampilan;
                                }else{
                                    return 0;
                                }
                            })->addColumn('keselamatan', function($student){
                                $evaluation = Evaluation::where('student_id', $student->student_id)->get()->first();
                                if(!empty($evaluation)){
                                    return $evaluation->keselamatan;
                                }else{
                                    return 0;
                                }
                            })->addColumn('disiplin', function($student){
                                $evaluation = Evaluation::where('student_id', $student->student_id)->get()->first();
                                if(!empty($evaluation)){
                                    return $evaluation->disiplin;
                                }else{
                                    return 0;
                                }
                            })->addColumn('sikap', function($student){
                                $evaluation = Evaluation::where('student_id', $student->student_id)->get()->first();
                                if(!empty($evaluation)){
                                    return $evaluation->sikap;
                                }else{
                                    return 0;
                                }
                            })->addColumn('score', function($student){
                                $evaluation = Evaluation::where('student_id', $student->student_id)->get()->first();
                                if(!empty($evaluation)){
                                    return $evaluation->mean_score;
                                }else{
                                    return 0;
                                }
                            })
                            ->addColumn('predicate', function($student){
                                $evaluation = Evaluation::where('student_id', $student->student_id)->get()->first();
                                if(!empty($evaluation)){
                                    return $evaluation->final_score;
                                }else{
                                    return "D (Kurang)";
                                }
                            })->make(true);
        }

        return view('report-menu.evaluation-report',[
            'title' => 'Laporan Penilaian Siswa',
            'menu' => 'evaluation-report'
        ]);
    }

    public function downloadEvaluationReport(Request $request){
        $students = Student::select('students.id as student_id','students.name as student', 'students.nisn', 'grade_classes.grade as grade', 'departments.name as department')
                            ->join('grade_classes', 'students.grade_class_id', '=', 'grade_classes.id')
                            ->join('departments', 'grade_classes.department_id', '=', 'departments.id');

        if(!is_null($request->nisn)){
            $students->where('nisn', 'like', "%{$request->get('nisn')}%");
        }

        if(!is_null($request->student)){
            $students->where('student', 'like', "%{$request->get('student')}%");
        }

        if(!is_null($request->department)){
            $students->where('department', 'like', "%{$request->get('department')}%");
        }

        $students = $students->get();

        $datas = [];
        foreach($students as $student){
            $score = Evaluation::where('student_id', $student->student_id)->get()->first();

            array_push($datas, [
                'student' => $student->student,
                'nisn' => $student->nisn,
                'department' => $student->department,
                'teori' => $score->teori ?? '0',
                'keterampilan' => $score->keterampilan ?? '0',
                'keselamatan' => $score->keselamatan ?? '0',
                'disiplin' => $score->keselamatan ?? '0',
                'sikap' => $score->sikap ?? '0',
                'score' => $score->mean_score ?? '0',
                'predicate' => $score->final_score ?? 'D (Kurang)'
            ]);
        }

        $final_data = [];
        foreach($datas as $data){
            $isAppend = true;

            if(!is_null($request->teori)){
                $isAppend = $isAppend && ($request->teori == $data['teori']);
            }

            if(!is_null($request->keterampilan)){
                $isAppend = $isAppend && ($request->keterampilan == $data['keterampilan']);
            }

            if(!is_null($request->keselamatan)){
                $isAppend = $isAppend && ($request->keselamatan == $data['keselamatan']);
            }

            if(!is_null($request->disiplin)){
                $isAppend = $isAppend && ($request->disiplin == $data['disiplin']);
            }

            if(!is_null($request->sikap)){
                $isAppend = $isAppend && ($request->sikap == $data['sikap']);
            }

            if(!is_null($request->score)){
                $isAppend = $isAppend && ($request->score == $data['score']);
            }

            if(!is_null($request->predicate)){
                $isAppend = $isAppend && ($request->predicate == $data['predicate']);
            }

            if($isAppend){
                array_push($final_data, [
                    'student' => $data['student'],
                    'nisn' => $data['nisn'],
                    'department' => $data['department'],
                    'teori' => $data['teori'],
                    'keterampilan' => $data['keterampilan'],
                    'keselamatan' => $data['keselamatan'],
                    'disiplin' => $data['keselamatan'],
                    'sikap' => $data['sikap'],
                    'score' => $data['score'],
                    'predicate' => $data['predicate']
                ]);
            }
        }

        $data = [
            'data' => $final_data,
            'title' => "Laporan Penilaian Siswa"
        ];

        $pdf = Pdf::loadView('report.evaluation', $data);
        return $pdf->stream('Laporan Penilaian Siswa.pdf');
    }
}
