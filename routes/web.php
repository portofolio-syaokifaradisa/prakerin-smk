<?php

use Illuminate\Http\Request;
use App\Models\StudentReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\GradeClassController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\StudentMentorController;
use App\Http\Controllers\StudentReportController;
use App\Http\Controllers\ApplicationLetterController;
use App\Mail\RegisterMail;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['guest'])->group(function(){
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('action-login');
    Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [LoginController::class, 'resetPassword'])->name('reset-password');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('action-register');

    Route::get('verify/{code}', function(Request $request){
        User::where('code_verification', $request->code)->update([
            'is_verified' => true
        ]);

        return redirect(route('login'))->with('success', 'Akun Berhasil Diverifikasi, SIlahkan Login!');
    })->name('verify');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('/admin-print', [AdminController::class, 'print'])->name('admin-print');
    Route::get('/admin/{id}', [AdminController::class, 'show'])->name('admin-show');
    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin-edit');
    Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin-update');
    Route::get('/admin-create', [AdminController::class, 'create'])->name('admin-create');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin-store');
    Route::get('/admin-delete/{id}', [AdminController::class, 'delete'])->name('admin-delete');

    Route::get('/agency', [AgencyController::class, 'index'])->name('agency');
    Route::get('/agency-print', [AgencyController::class, 'print'])->name('agency-print');
    Route::get('/agency-all', [AgencyController::class, 'allAgency'])->name('agency-all');
    Route::get('/agency/{id}', [AgencyController::class, 'show'])->name('agency-show');
    Route::get('/agency/{id}/edit', [AgencyController::class, 'edit'])->name('agency.edit');
    Route::put('/agency/{id}', [AgencyController::class, 'update'])->name('agency-update');
    Route::get('/agency-create', [AgencyController::class, 'create'])->name('agency-create');
    Route::post('/agency', [AgencyController::class, 'store'])->name('region-store');
    Route::get('/agency-delete/{id}', [AgencyController::class, 'delete'])->name('agency-delete');

    Route::get('/app-letter', [ApplicationLetterController::class, 'index'])->name('app-letter');
    Route::put('/accept-letter/{id}',[ApplicationLetterController::class, 'accept'])->name('accept-letter');
    Route::put('/finalization-letter/{id}',[ApplicationLetterController::class, 'finalization'])->name('finalization-letter');
    
    Route::get('/app-letter/{id}', [ApplicationLetterController::class, 'show'])->name('app-letter-show');
    Route::put('/app-letter/{id}', [ApplicationLetterController::class, 'update'])->name('app-letter-update');
    Route::get('/app-letter-create', [ApplicationLetterController::class, 'create'])->name('app-letter-create');
    Route::post('/app-letter', [ApplicationLetterController::class, 'store'])->name('app-letter-store');
    Route::get('/app-letter-delete/{id}', [ApplicationLetterController::class, 'delete'])->name('app-letter-delete');

    Route::prefix('/evaluation/{studentId}')->name('evaluation.')->group(function(){
        Route::get('/create', [EvaluationController::class, 'create'])->name('create');
        Route::post('/store', [EvaluationController::class, 'store'])->name('store');
        Route::get('/edit', [EvaluationController::class, 'edit'])->name('edit');
        Route::put('/update', [EvaluationController::class, 'update'])->name('update');
    });

    Route::prefix('/monitoring')->name('monitoring-admin.')->group(function(){
        Route::get('/', [MonitoringController::class, 'index_admin'])->name('index');
    });

    Route::get('attendance/print-all', [AttendanceController::class, 'printAll'])->name('attendance.print-all');
    Route::get('journal/print-all', [JournalController::class, 'printAll'])->name('journal.print-all');
    Route::get('monitoring/print-all', [MonitoringController::class, 'printAll'])->name('monitoring.print-all');

    Route::prefix('/student-report-title')->name('student-report-title.')->group(function(){
        Route::get('/', function(){
            return view('student-report.index-admin', [
                'reports' => StudentReport::with('student')->get(),
                'title' => 'Judul Laporan Siswa',
                'menu' => 'report-student'
            ]);
        })->name('index');
        Route::get('/report', [StudentReportController::class, 'report'])->name('report');
        Route::post('/store', [StudentReportController::class, 'store'])->name('store');
        Route::put('/{id}/update', [StudentReportController::class, 'update'])->name('update');
        Route::prefix('/{application_letter_id}/{id}')->group(function(){
            Route::get('/accept', [StudentReportController::class, 'accept'])->name('accept');
            Route::get('/refuse', [StudentReportController::class, 'refuse'])->name('refuse');
        });
    });

    Route::prefix('/app-letter/{id}')->name('app-letter.')->group(function(){
        Route::prefix('/journal')->name('journal.')->group(function(){
            Route::get('/', [JournalController::class, 'index'])->name('index');
            Route::get('/create', [JournalController::class, 'create'])->name('create');
            Route::post('/store', [JournalController::class, 'store'])->name('store');
            Route::get('/print', [JournalController::class, 'print'])->name('print');
            Route::prefix('{journal_id}')->group(function(){
                Route::get('/delete', [JournalController::class, 'delete'])->name('delete');
                Route::get('/edit', [JournalController::class, 'edit'])->name('edit');
                Route::put('/update', [JournalController::class, 'update'])->name('update');
            });
        });

        Route::prefix('attedance')->name('attedance.')->group(function(){
            Route::get('/in', [AttendanceController::class, 'in'])->name('in');
            Route::get('/out', [AttendanceController::class, 'out'])->name('out');
            Route::get('/sick', [AttendanceController::class, 'sick'])->name('sick');
            Route::get('/print', [AttendanceController::class, 'print'])->name('print');
            Route::get('/print-by-app-letter', [AttendanceController::class, 'printByAppLetter'])->name('print-by-app-letter');
            Route::get('/{type}', [AttendanceController::class, 'create'])->name('create');
            Route::post('/{type}/store', [AttendanceController::class, 'store'])->name('store');
        });

        Route::prefix('monitoring')->name('monitoring.')->group(function(){
            Route::get('/', [MonitoringController::class, 'index'])->name('index');
            Route::get('/create', [MonitoringController::class, 'create'])->name('create');
            Route::get('/print', [MonitoringController::class, 'print'])->name('print');
            Route::post('/store', [MonitoringController::class, 'store'])->name('store');
            Route::prefix('{monitoring_id}')->group(function(){
                Route::get('/edit', [MonitoringController::class, 'edit'])->name('edit');
                Route::put('/update', [MonitoringController::class, 'update'])->name('update');
                Route::get('/delete', [MonitoringController::class, 'delete'])->name('delete');
            });
        });
    });

    Route::prefix('report')->name('report.')->group(function(){
        Route::prefix('student-report-title')->name('student-report-title.')->group(function(){
            Route::get('/', [ReportController::class, 'studentTitleReportReview'])->name('index');
            Route::get('/download', [ReportController::class, 'downloadStudentTitleReport'])->name('download');
        });
        Route::prefix('region')->name('region.')->group(function(){
            Route::get('/', [ReportController::class, 'regionReportReview'])->name('index');
            Route::get('/download', [ReportController::class, 'downloadRegionReport'])->name('download');
        });
        Route::prefix('agency')->name('agency.')->group(function(){
            Route::get('/', [ReportController::class, 'agencyReportReview'])->name('index');
            Route::get('/download', [ReportController::class, 'downloadAgencyReport'])->name('download');
        });
        Route::prefix('student')->name('student.')->group(function(){
            Route::get('/', [ReportController::class, 'studentReportReview'])->name('index');
            Route::get('/download-account', [ReportController::class, 'downloadStudentAccountReport'])->name('download-account');
            Route::get('/download', [ReportController::class, 'downloadStudentReport'])->name('download');
        });
        Route::prefix('teacher')->name('teacher.')->group(function(){
            Route::get('/', [ReportController::class, 'teacherReportReview'])->name('index');
            Route::get('/download-account', [ReportController::class, 'downloadTeacherAccountReport'])->name('download-account');
            Route::get('/download', [ReportController::class, 'downloadTeacherReport'])->name('download');
        });
        Route::prefix('mentor')->name('mentor.')->group(function(){
            Route::get('/', [ReportController::class, 'mentorReportReview'])->name('index');
            Route::get('/download', [ReportController::class, 'downloadMentorReport'])->name('download');
        });
        Route::prefix('mentoring')->name('mentoring.')->group(function(){
            Route::get('/', [ReportController::class, 'mentoringReportReview'])->name('index');
            Route::get('/download', [ReportController::class, 'downloadMentoringReport'])->name('download');
        });
        Route::prefix('journal/{id}')->name('journal.')->group(function(){
            Route::get('/', [ReportController::class, 'journalReportReview'])->name('index');
            Route::get('/download', [ReportController::class, 'downloadJournalReport'])->name('download');
        });
        Route::prefix('journal-summary')->name('journal-summary.')->group(function(){
            Route::get('/', [ReportController::class, 'journalSummaryReportReview'])->name('index');
            Route::get('/download', [ReportController::class, 'downloadJournalSummaryReport'])->name('download');
        });
        Route::prefix('monitoring')->name('monitoring.')->group(function(){
            Route::get('/', [ReportController::class, 'studentMonitoringReportReview'])->name('index');
            Route::get('/download', [ReportController::class, 'downloadStudentMonitoringReport'])->name('download');
        });
        Route::prefix('attendance/{id}')->name('attendance.')->group(function(){
            Route::get('/', [ReportController::class, 'attendanceReportReview'])->name('index');
            Route::get('/download', [ReportController::class, 'downloadAttendanceReport'])->name('download');
        });
        Route::prefix('attendance-summary')->name('attendance-summary.')->group(function(){
            Route::get('/', [ReportController::class, 'attendanceSummaryReportReview'])->name('index');
            Route::get('/download', [ReportController::class, 'downloadAttendanceSummaryReport'])->name('download');
        });
        Route::prefix('evaluation')->name('evaluation.')->group(function(){
            Route::get('/', [ReportController::class, 'evaluationReportReview'])->name('index');
            Route::get('/download', [ReportController::class, 'downloadEvaluationReport'])->name('download');
        });
    });

    Route::get('/colaboration-letter/{id}', [ApplicationLetterController::class, 'makeColaborationLetter'])->name('colaboration-letter');
    Route::get('/request-letter/{data}', [ApplicationLetterController::class, 'makeRequestLetter'])->name('request-letter');
    Route::get('/introduction-letter/{data}', [ApplicationLetterController::class, 'makeIntroductionLetter'])->name('introduction-letter');
    Route::put('/response-letter/{id}',[ApplicationLetterController::class, 'responseLetter'])->name('response-letter');
    Route::get('/download-response-letter/{letter_number}',[ApplicationLetterController::class, 'downloadResponseLetter'])->name('response-letter');

    Route::get('/class', [GradeClassController::class, 'index'])->name('class');
    Route::get('/all-class', [GradeClassController::class, 'allClass'])->name('class-all');
    Route::get('/class/{id}', [GradeClassController::class, 'classShow'])->name('class-show');
    Route::get('/class/{id}/edit', [GradeClassController::class, 'classEdit'])->name('class-edit');
    Route::put('/class/{id}', [GradeClassController::class, 'classUpdate'])->name('class-update');
    Route::get('/class-create', [GradeClassController::class, 'classCreate'])->name('class-create');
    Route::post('/class', [GradeClassController::class, 'classStore'])->name('class-store');
    Route::get('/class-delete/{id}', [GradeClassController::class, 'classDelete'])->name('class-delete');

    Route::get('/department/{id}', [GradeClassController::class, 'departmentShow'])->name('department-show');
    Route::get('/department/{id}/edit', [GradeClassController::class, 'departmentEdit'])->name('department-edit');
    Route::get('/all-department', [GradeClassController::class, 'allDepartment'])->name('department-all');
    Route::put('/department/{id}', [GradeClassController::class, 'departmentUpdate'])->name('department-update');
    Route::get('/department-create', [GradeClassController::class, 'departmentCreate'])->name('department-create');
    Route::post('/department', [GradeClassController::class, 'departmentStore'])->name('department-store');
    Route::get('/department-delete/{id}', [GradeClassController::class, 'departmentDelete'])->name('department-delete');

    Route::get('/mentor', [MentorController::class, 'index'])->name('mentor');
    Route::get('/mentor-print', [MentorController::class, 'print'])->name('mentor-print');
    Route::get('/all-mentor', [MentorController::class, 'allMentor'])->name('mentor-all');
    Route::get('/mentor/{id}', [MentorController::class, 'show'])->name('mentor-show');
    Route::put('/mentor/{id}', [MentorController::class, 'update'])->name('mentor-update');
    Route::get('/mentor-create', [MentorController::class, 'create'])->name('mentor-create');
    Route::post('/mentor', [MentorController::class, 'store'])->name('mentor-store');
    Route::get('/mentor-delete/{id}', [MentorController::class, 'delete'])->name('mentor-delete');

    Route::get('/mentoring', [StudentMentorController::class, 'index'])->name('mentoring');
    Route::get('/mentoring-print', [StudentMentorController::class, 'print'])->name('mentoring-print');
    Route::get('/mentoring-gen-print', [StudentMentorController::class, 'generalPrint'])->name('mentoring-gen-print');
    Route::get('/mentoring/{id}', [StudentMentorController::class, 'show'])->name('mentoring-show');
    Route::put('/mentoring/{id}', [StudentMentorController::class, 'update'])->name('mentoring-update');
    Route::get('/mentoring-create', [StudentMentorController::class, 'create'])->name('mentoring-create');
    Route::post('/mentoring', [StudentMentorController::class, 'store'])->name('mentoring-store');
    Route::get('/mentoring-delete/{id}', [StudentMentorController::class, 'delete'])->name('mentoring-delete');

    Route::get('/region', [RegionController::class, 'index'])->name('region');
    Route::get('/region-print', [RegionController::class, 'print'])->name('region-print');
    Route::get('/all-region', [RegionController::class, 'allRegion'])->name('region-all');
    Route::get('/region/{id}', [RegionController::class, 'show'])->name('region-show');
    Route::get('/region/{id}/edit', [RegionController::class, 'edit'])->name('region.edit');
    Route::put('/region/{id}', [RegionController::class, 'update'])->name('region-update');
    Route::get('/region-create', [RegionController::class, 'create'])->name('region-create');
    Route::post('/region', [RegionController::class, 'store'])->name('region-store');
    Route::get('/region-delete/{id}', [RegionController::class, 'delete'])->name('region-delete');

    Route::get('/student', [StudentController::class, 'index'])->name('student');
    Route::get('/student-print', [StudentController::class, 'print'])->name('student-print');
    Route::get('/all-student', [StudentController::class, 'allStudent'])->name('student-all');
    Route::get('/student/{id}', [StudentController::class, 'show'])->name('student-show');
    Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::put('/student/{id}', [StudentController::class, 'update'])->name('student-update');
    Route::get('/student-create', [StudentController::class, 'create'])->name('student-create');
    Route::post('/student', [StudentController::class, 'store'])->name('student-store');
    Route::get('/student-delete/{id}', [StudentController::class, 'delete'])->name('student-delete');
    Route::get('/student-report', [StudentController::class, 'report'])->name('student-report');

    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher');
    Route::get('/teacher-print', [TeacherController::class, 'print'])->name('teacher-print');
    Route::get('/all-teacher', [TeacherController::class, 'allTeacher'])->name('teacher-all');
    Route::get('/teacher/{id}', [TeacherController::class, 'show'])->name('teacher-show');
    Route::get('/teacher/{id}/edit', [TeacherController::class, 'edit'])->name('teacher-edit');
    Route::put('/teacher/{id}', [TeacherController::class, 'update'])->name('teacher-update');
    Route::get('/teacher-create', [TeacherController::class, 'create'])->name('teacher-create');
    Route::post('/teacher', [TeacherController::class, 'store'])->name('teacher-store');
    Route::get('/teacher-delete/{id}', [TeacherController::class, 'delete'])->name('teacher-delete');

    Route::get('/logout', function(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});