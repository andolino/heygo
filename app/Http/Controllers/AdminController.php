<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Http\Request;
use App\Models\Admins;
use App\Models\Teachers;
use Auth;
use DB;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class AdminController extends Controller{
    
    public function adminsDashboard(){
        $data = DB::table('admins')->where('id', '=', Auth::id())->first();
        $link_url = request()->segment(1);
        return view('admin-dashboard', [ 'data' => $data, 'link' => $link_url]);
    }

    public function studentPayment(){
        $data = DB::table('admins')->where('id', '=', Auth::id())->first();
        $paymentTransaction = DB::select(DB::raw("SELECT 
                        concat(s.lastname, ', ', s.firstname) as student_name, 
                        concat(t.lastname, ', ', t.firstname) as teacher_name,
                        lpl.*, 
                        lo.title 
                    from lesson_schedule ls 
                    left join lesson_option lo on lo.id = ls.lesson_option_id
                    left join students s on s.id = ls.students_id
                    left join teachers t on t.id = ls.teachers_id
                    left join students_payment_log lpl on ls.id = lpl.lesson_schedule_id"));
        return view('admin.student-payment', [ 'data' => $data, 'paymentTransaction' => $paymentTransaction ]);
    }
    
    public function heygoWallet(){
        $data = DB::table('admins')->where('id', '=', Auth::id())->first();
        $paymentTransaction = DB::select(DB::raw("SELECT concat(s.lastname, ', ', s.firstname) as student_name, concat(t.lastname, ', ', t.firstname) as teacher_name,
                                                    spl.trans_id, spl.currency, spl.response_date, hw.* from heygo_wallet hw
                                                    LEFT JOIN students_payment_log spl on hw.students_payment_log_id = spl.id
                                                    LEFT JOIN lesson_schedule ls on ls.id = spl.lesson_schedule_id
                                                    LEFT JOIN teachers t on t.id = ls.teachers_id
                                                    LEFT JOIN students s on s.id = ls.students_id"));
        return response()->json($paymentTransaction);
        // return view('admin.heygo-wallet', [ 'data' => $data, 'paymentTransaction' => $paymentTransaction ]);
    }
    
    public function teacherWallet(){
        $data = DB::table('admins')->where('id', '=', Auth::id())->first();
        $paymentTransaction = DB::select(DB::raw("SELECT 
                                                    concat(s.lastname, ', ', s.firstname) as student_name, concat(t.lastname, ', ', t.firstname) as teacher_name, 
                                                    spl.trans_id, spl.currency, spl.response_date, hw.* 
                                                    from teachers_wallet hw
                                                    LEFT JOIN students_payment_log spl on hw.students_payment_log_id = spl.id
                                                    LEFT JOIN lesson_schedule ls on ls.id = spl.lesson_schedule_id
                                                    LEFT JOIN teachers t on t.id = ls.teachers_id
                                                    LEFT JOIN students s on s.id = ls.students_id"));
        return view('admin.teachers-wallet', [ 'data' => $data, 'paymentTransaction' => $paymentTransaction ]);
    }

    public function badgeList(Request $request){
        $columns = ['title', 'image', 'created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $searchValue = $request->search;
        $q = DB::table('badges')->select('id', 'title', 'image', 'created_at')->orderBy($columns[$column], $dir);

        if ($searchValue) {
            $q->where(function($q) use ($searchValue) {
                $q->where('title', 'like', '%' . $searchValue . '%')
                    ->orWhere('image', 'like', '%' . $searchValue . '%');
            });
        }

        $badge = $q->paginate($length);
        return ['data' => $badge, 'draw' => $request->draw];
    }

    public function teachersListSetup(Request $request){
        // $data = Admins::getTeachersSetup()->get();
        // return ['data'=>$data];
        $columns = ['lastname', 'firstname', 'middlename', 'rate_per_hr', 'contact_no', 'picture', 'number_of_lesson', 'title'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $searchValue = $request->search;
        $q = Teachers::leftJoin('lesson_schedule', 'teachers.id', '=', 'lesson_schedule.teachers_id')
                    ->leftJoin('lesson_plan', 'lesson_plan.id', '=', 'lesson_schedule.lesson_plan_id')
                    ->select('teachers.*', DB::raw('count(lesson_schedule.id) as number_of_lesson'), 'lesson_plan.title')
                    ->orderBy($columns[$column], $dir)
                    ->groupBy('teachers.id');
                    // select 
                    //     t.*, 
                    //     count(ls.id) as number_of_lesson, 
                    //     lp.title from teachers t
                    // left join lesson_schedule ls on t.id = ls.teachers_id
                    // left join lesson_plan lp on ls.lesson_plan_id = lp.id
                    // group by t.id, lp.id;
        if ($searchValue) {
            $q->where(function($q) use ($searchValue) {
                $q->where('teachers.lastname', 'like', '%' . $searchValue . '%')
                    ->orWhere('teachers.firstname', 'like', '%' . $searchValue . '%')
                    ->orWhere('teachers.email', 'like', '%' . $searchValue . '%');
            });
        }
        $badge = $q->paginate($length);
        return ['data' => $badge, 'draw' => $request->draw];
    }

    public function getLessonAndBadge(Request $request){
        $q = Teachers::leftJoin('lesson_schedule', 'teachers.id', '=', 'lesson_schedule.teachers_id')
                    ->leftJoin('lesson_plan', 'lesson_plan.id', '=', 'lesson_schedule.lesson_plan_id')
                    ->leftJoin('students', 'students.id', '=', 'lesson_schedule.students_id')
                    ->select('lesson_schedule.id', DB::raw("count(lesson_schedule.id) as no_of_lesson"), DB::raw("concat(students.lastname, ', ', students.firstname) as student_name"), 'lesson_plan.title')
                    ->where('teachers.id', $request->id)
                    ->groupBy('teachers.id', 'lesson_plan.id')->get();
        return ['data' => $q];
    }
    
    public function getPaymentTransactionStudent(Request $request){
        
        $columns = ['title'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $searchValue = $request->search;
        // dd($dir);
        $q = DB::table('lesson_schedule')
                ->select(DB::raw("concat(students.lastname, ', ', students.firstname) as student_name, 
                                    concat(teachers.lastname, ', ', teachers.firstname) as teacher_name"), 
                                    "students_payment_log.*", "lesson_option.title")
                ->leftJoin('lesson_option', 'lesson_schedule.lesson_option_id', '=', 'lesson_option.id')
                ->leftJoin('students', 'students.id', '=', 'lesson_schedule.students_id')
                ->leftJoin('teachers', 'teachers.id', '=', 'lesson_schedule.teachers_id')
                ->leftJoin('students_payment_log', 'students_payment_log.lesson_schedule_id', '=', 'lesson_schedule.id')
                ->orderBy($columns[$column], $dir);

        if ($searchValue) {
            $q->where(function($q) use ($searchValue) {
                $q->where('teachers.lastname', 'like', '%' . $searchValue . '%')
                    ->orWhere('teachers.firstname', 'like', '%' . $searchValue . '%');
            });
        }

        $pymnt = $q->paginate($length);
        return ['data' => $pymnt, 'draw' => $request->draw];
    }
    
    public function getPaymentTransactionTeacher(Request $request){
        
        $columns = ['students.lastname'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $searchValue = $request->search;
        $q = DB::table('teachers_wallet')
                ->select(DB::raw("concat(students.lastname, ', ', students.firstname) as student_name, 
                                concat(teachers.lastname, ', ', teachers.firstname) as teacher_name"), 
                                "students_payment_log.trans_id", 
                                "students_payment_log.currency", 
                                "students_payment_log.response_date", 
                                "teachers_wallet.*")
                ->leftJoin('students_payment_log', 'teachers_wallet.students_payment_log_id', '=', 'students_payment_log.id')
                ->leftJoin('lesson_schedule', 'lesson_schedule.id', '=', 'students_payment_log.lesson_schedule_id')
                ->leftJoin('teachers', 'teachers.id', '=', 'lesson_schedule.teachers_id')
                ->leftJoin('students', 'students.id', '=', 'lesson_schedule.students_id')
                ->orderBy($columns[$column], $dir);

        if ($searchValue) {
            $q->where(function($q) use ($searchValue) {
                $q->where('students.lastname', 'like', '%' . $searchValue . '%')
                    ->orWhere('students.firstname', 'like', '%' . $searchValue . '%');
            });
        }

        $pymnt = $q->paginate($length);
        return ['data' => $pymnt, 'draw' => $request->draw];
    }
    
    public function getHeygoWallet(Request $request){
        $columns = ['teachers.lastname'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $searchValue = $request->search;
        $q = DB::table('heygo_wallet')
                ->select(DB::raw("concat(students.lastname, ', ', students.firstname) as student_name, 
                                concat(teachers.lastname, ', ', teachers.firstname) as teacher_name"), 
                                "students_payment_log.trans_id", 
                                "students_payment_log.currency", 
                                "students_payment_log.response_date", 
                                "heygo_wallet.*")
                ->leftJoin('students_payment_log', 'heygo_wallet.students_payment_log_id', '=', 'students_payment_log.id')
                ->leftJoin('lesson_schedule', 'lesson_schedule.id', '=', 'students_payment_log.lesson_schedule_id')
                ->leftJoin('teachers', 'teachers.id', '=', 'lesson_schedule.teachers_id')
                ->leftJoin('students', 'students.id', '=', 'lesson_schedule.students_id')
                ->orderBy($columns[$column], $dir);
                // SELECT concat(s.lastname, ', ', s.firstname) as student_name, concat(t.lastname, ', ', t.firstname) as teacher_name,
                // spl.trans_id, spl.currency, spl.response_date, hw.* 
                // from heygo_wallet hw
                // LEFT JOIN students_payment_log spl on hw.students_payment_log_id = spl.id
                // LEFT JOIN lesson_schedule ls on ls.id = spl.lesson_schedule_id
                // LEFT JOIN teachers t on t.id = ls.teachers_id
                // LEFT JOIN students s on s.id = ls.students_id

        if ($searchValue) {
            $q->where(function($q) use ($searchValue) {
                $q->where('teachers.lastname', 'like', '%' . $searchValue . '%')
                    ->orWhere('teachers.firstname', 'like', '%' . $searchValue . '%');
            });
        }

        $pymnt = $q->paginate($length);
        return ['data' => $pymnt, 'draw' => $request->draw];
    }
}
