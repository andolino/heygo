<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Request;
use App\Models\Teachers;
use App\Models\Students;
use App\Models\TeacherFeeds;
use App\Models\StudentFeeds;
use App\Models\TeacherFeedsAttachments;
use App\Models\StudentFeedsAttachments;
use Auth;
use DB;

class FeedsController extends Controller{


    public function postTeacherFeeds(Request $request){
        // return response()->json(['message'=>'route reached'], 200);
        $content = $request->feed_body;



        

        //custom validate
        if($content == null){
            return response()->json(['validationfail' => 'Post content is required']);
        }


        if ($request->file('file')) {
            /**
             * For Single Upload
             */
            //get name of file$file     = $request->file('file');
            // $filename = $file->getClientOriginalName();
            // //strip out all spaces
            // $filename = str_replace(' ', '', $filename);
            
            // $path = $file->storeAs('uploads/teachers-feeds', $filename);
            // //store
            // // $path = $request->file('file')->store('uploads/teachers-feeds');
            // if ($path) {
            //     return response()->json(['message' => 'file uploaded'], 200);
            // }

            /**
             * Multiple file uplaod
             */
            $files = $request->file('file');
            if (!is_array($files)) {
                $files = [$files];
            }

            
            $teachersFeeds = TeacherFeeds::create([
                'teacher_id' => $request->teacher_id,
                'feed_title' => '',
                'feed_body' => $request->feed_body
            ]);
            $teachersFeeds->save();
            //get last insert id
            $teacher_newsfeed_id = $teachersFeeds->id;
            
            //loop through the array
            for ($i=0; $i < count($files); $i++) { 
                $file = $files[$i];
                $filename = $file->getClientOriginalName();
                $filename = str_replace(' ', '', $filename);
                $path = $file->storeAs('uploads/teachers-feeds', $filename);
                $teacherFeedsAttchmts = TeacherFeedsAttachments::create([
                    'teacher_newsfeed_id' => $teacher_newsfeed_id,
                    'file' => $filename,
                ]);
                $teacherFeedsAttchmts->save();
            }
            return response()->json(['message' => 'file uploaded', 'data' => $request->all()], 200);
        } else {
            if ($request->feed_body) {
                $teachersFeeds = TeacherFeeds::create([
                    'teacher_id' => $request->teacher_id,
                    'feed_title' => '',
                    'feed_body' => $request->feed_body
                ]);
                $teachersFeeds->save();
                return response()->json(['message' => 'Your Question is Posted', 'data' => $request->all()], 200);
            }
            return response()->json(['message' => 'error uploading file'], 503);
        }
    }
    
    public function postStudentFeeds(Request $request){
        // return response()->json(['message'=>'route reached'], 200);

        if ($request->file('file')) {
            $files = $request->file('file');
            if (!is_array($files)) {
                $files = [$files];
            }
            $studentFeeds = StudentFeeds::create([
                'student_id' => $request->student_id,
                'feed_title' => '',
                'feed_body'  => $request->feed_body
            ]);
            $studentFeeds->save();
            //get last insert id
            $student_newsfeed_id = $studentFeeds->id;
            //loop through the array
            for ($i=0; $i < count($files); $i++) { 
                $file     = $files[$i];
                $filename = $file->getClientOriginalName();
                $filename = str_replace(' ', '', $filename);
                $path = $file->storeAs('uploads/students-feeds', $filename);
                $studentFeedsAttchmts = StudentFeedsAttachments::create([
                    'student_newsfeed_id' => $student_newsfeed_id,
                    'file' => $filename,
                ]);
                $studentFeedsAttchmts->save();
            }
            return response()->json(['message' => 'file uploaded', 'data' => $request->all()], 200);
        } else {
            if ($request->feed_body) {
                $studentFeeds = StudentFeeds::create([
                    'student_id' => $request->student_id,
                    'feed_title' => '',
                    'feed_body' => $request->feed_body
                ]);
                $studentFeeds->save();
                return response()->json(['message' => 'Your Question is Posted', 'data' => $request->all()], 200);
            }
            return response()->json(['message' => 'error uploading file'], 503);
        }
    }

    public function displayTeacherFeeds(Request $request){
        // $teachers_id = $request->teachers_id;
        $feeds_id = $request->feeds_id == '' ? '' : ' WHERE tn.id = ' . $request->feeds_id;
        $question = DB::select(DB::raw("SELECT 
                                        tn.*,
                                        tna.file,
                                        t.lastname,
                                        t.firstname,
                                        t.middlename,
                                        t.rate_per_hr,
                                        t.email,
                                        GROUP_CONCAT(DISTINCT tna.file ORDER BY tna.file DESC SEPARATOR '==') as attmnts,
                                        tnl.is_like
                                    FROM teacher_newsfeed tn
                                    LEFT JOIN teacher_newsfeed_attachments tna ON tna.teacher_newsfeed_id = tn.id
                                    LEFT JOIN teacher_newsfeed_likes tnl ON tnl.teacher_newsfeed_id = tn.id
                                    LEFT JOIN teachers t ON t.id = tn.teacher_id
                                    $feeds_id
                                    GROUP BY tn.id ORDER BY tn.id DESC"));
                                    //WHERE tn.teacher_id = $teachers_id 
                                    // GROUP_CONCAT(DISTINCT test_score
                                    // ORDER BY test_score DESC SEPARATOR ' ')
        // teacher_newsfeed_comments
        $comments_result = DB::select(DB::raw("SELECT 
                                                    tnc.*,
                                                    coalesce(t.lastname, s.lastname) as lastname,
                                                    coalesce(t.firstname, s.firstname) as firstname,
                                                    coalesce(t.email, s.email) as email,
                                                    t.rate_per_hr,
                                                    tncu.is_like as usefull_like,
                                                    tncl.is_like
                                                FROM teacher_newsfeed_comments tnc
                                                LEFT JOIN teacher_newsfeed_com_usefull tncu ON tncu.teacher_newsfeed_com_id = tnc.id
                                                LEFT JOIN teacher_newsfeed_com_likes tncl ON tncl.teacher_newsfeed_com_id = tnc.id
                                                LEFT JOIN teachers t ON t.id = tnc.teachers_id
                                                LEFT JOIN students s ON s.id = tnc.students_id
                                                GROUP BY tnc.id ORDER BY tnc.id ASC"));
        $sub_comments_result = DB::select(DB::raw("SELECT 
                                                    tncs.*,
                                                    coalesce(t.lastname, s.lastname) as lastname,
                                                    coalesce(t.firstname, s.firstname) as firstname,
                                                    coalesce(t.email, s.email) as email
                                                FROM teacher_newsfeed_comments_sub tncs
                                                LEFT JOIN teachers t ON t.id = tncs.teachers_id
                                                LEFT JOIN students s ON s.id = tncs.students_id
                                                GROUP BY tncs.id ORDER BY tncs.id ASC"));
        $c = [];
        $sc = [];
        foreach ($comments_result as $r) { $c[$r->teacher_newsfeed_id][] = $r; }
        foreach ($sub_comments_result as $r) { $sc[$r->teacher_newsfeed_comments_id][] = $r; }
        // $q = [];
        // foreach ($question as $k => $v) { $d[$k] = $v; }
        // dd($c[14]);
        return response()->json(['question' => $question, 'comments' => $c, 'sub_comments' => $sc]);
    }

    public function displayStudentFeeds(Request $request){
        $feeds_id = $request->feeds_id == '' ? '' : ' WHERE tn.id = ' . $request->feeds_id;
        $question = DB::select(DB::raw("SELECT 
                                        tn.*,
                                        tna.file,
                                        t.lastname,
                                        t.firstname,
                                        t.middlename,
                                        -- t.rate_per_hr,
                                        t.email,
                                        GROUP_CONCAT(DISTINCT tna.file ORDER BY tna.file DESC SEPARATOR '==') as attmnts,
                                        tnl.is_like
                                    FROM student_newsfeed tn
                                    LEFT JOIN student_newsfeed_attachments tna ON tna.student_newsfeed_id = tn.id
                                    LEFT JOIN student_newsfeed_likes tnl ON tnl.student_newsfeed_id = tn.id
                                    LEFT JOIN students t ON t.id = tn.student_id
                                    $feeds_id
                                    GROUP BY tn.id ORDER BY tn.id DESC"));
        // teacher_newsfeed_comments
        $comments_result = DB::select(DB::raw("SELECT 
                                                    tnc.*,
                                                    coalesce(t.lastname, s.lastname) as lastname,
                                                    coalesce(t.firstname, s.firstname) as firstname,
                                                    coalesce(t.email, s.email) as email,
                                                    t.rate_per_hr,
                                                    tncu.is_like as usefull_like,
                                                    tncl.is_like
                                                FROM student_newsfeed_comments tnc
                                                LEFT JOIN student_newsfeed_com_usefull tncu ON tncu.student_newsfeed_com_id = tnc.id
                                                LEFT JOIN student_newsfeed_com_likes tncl ON tncl.student_newsfeed_com_id = tnc.id
                                                LEFT JOIN teachers t ON t.id = tnc.teachers_id
                                                LEFT JOIN students s ON s.id = tnc.students_id
                                                GROUP BY tnc.id ORDER BY tnc.id ASC"));
        $sub_comments_result = DB::select(DB::raw("SELECT 
                                                    tncs.*,
                                                    coalesce(t.lastname, s.lastname) as lastname,
                                                    coalesce(t.firstname, s.firstname) as firstname,
                                                    coalesce(t.email, s.email) as email
                                                FROM student_newsfeed_comments_sub tncs
                                                LEFT JOIN teachers t ON t.id = tncs.teachers_id
                                                LEFT JOIN students s ON s.id = tncs.students_id
                                                GROUP BY tncs.id ORDER BY tncs.id ASC"));
        $c = [];
        $sc = [];
        foreach ($comments_result as $r) { $c[$r->student_newsfeed_id][] = $r; }
        foreach ($sub_comments_result as $r) { $sc[$r->student_newsfeed_comments_id][] = $r; }
        // $q = [];
        // foreach ($question as $k => $v) { $d[$k] = $v; }
        // dd($c[14]);
        return response()->json(['question' => $question, 'comments' => $c, 'sub_comments' => $sc]);
    }

    public function postLikes(Request $request){
        // $request->type;
        // $request->user_id;
        // $request->is_students;
        // $request->is_like;
        if ($request->type == 'like-question') {
            /**
             * Post Like Question
             */
            if ($request->is_students == 0) {
                DB::table('teacher_newsfeed_likes')
                    ->updateOrInsert(
                        [ 'teacher_newsfeed_id' => $request->feeds_id, 'teachers_id' => $request->user_id ],
                        [ 'is_like' => $request->is_like, 'created_at' => date('Y-m-d H:i:s') ],
                    );
            } else {
                DB::table('student_newsfeed_likes')
                    ->updateOrInsert(
                        [ 'student_newsfeed_id' => $request->feeds_id, 'students_id' => $request->user_id ],
                        [ 'is_like' => $request->is_like, 'created_at' => date('Y-m-d H:i:s') ],
                    );
            }
        } elseif($request->type == 'usefull-comments'){
            if ($request->is_students == 0) {
                DB::table('teacher_newsfeed_com_usefull')
                    ->updateOrInsert(
                        [ 'teacher_newsfeed_com_id' => $request->feeds_id, 'teachers_id' => $request->user_id ],
                        [ 'is_like' => $request->is_like, 'created_at' => date('Y-m-d H:i:s') ],
                    );
            } else {
                DB::table('student_newsfeed_com_usefull')
                    ->updateOrInsert(
                        [ 'student_newsfeed_com_id' => $request->feeds_id, 'students_id' => $request->user_id ],
                        [ 'is_like' => $request->is_like, 'created_at' => date('Y-m-d H:i:s') ],
                    );
            }
        } else {
            /**
             * Post Like Comment in Question
             * type = like-comments
             */
            if ($request->is_students == 0) {
                DB::table('teacher_newsfeed_com_likes')
                    ->updateOrInsert(
                        [ 'teacher_newsfeed_com_id' => $request->feeds_id, 'teachers_id' => $request->user_id ],
                        [ 'is_like' => $request->is_like, 'created_at' => date('Y-m-d H:i:s') ],
                    );
            } else {
                DB::table('student_newsfeed_com_likes')
                    ->updateOrInsert(
                        [ 'student_newsfeed_com_id' => $request->feeds_id, 'students_id' => $request->user_id ],
                        [ 'is_like' => $request->is_like, 'created_at' => date('Y-m-d H:i:s') ],
                    );
            }
        }
    }

    public function postComments(Request $request){
        if ($request->type == 'comment-comments') {
            /**
             * Post Answer to Question
             */
            if ($request->is_students == 0) {
                DB::table('teacher_newsfeed_comments')
                    ->insert(['teacher_newsfeed_id' => $request->feeds_id, 
                                'teachers_id' => $request->user_id, 
                                'comments' => $request->comments,
                                'created_at' => date('Y-m-d H:i:s') ]);
            } else {
                DB::table('student_newsfeed_comments')
                    ->insert(['student_newsfeed_id' => $request->feeds_id, 
                                'students_id' => $request->user_id, 
                                'comments' => $request->comments,
                                'created_at' => date('Y-m-d H:i:s') ]);
            }
        } else {
           /**
             * Post Comments to Answer
             */
            if ($request->is_students == 0) {
                DB::table('teacher_newsfeed_comments_sub')
                    ->insert(['teacher_newsfeed_comments_id' => $request->feeds_id, 
                                'teachers_id' => $request->user_id, 
                                'comments' => $request->comments,
                                'created_at' => date('Y-m-d H:i:s') ]);
            } else {
                DB::table('student_newsfeed_comments_sub')
                    ->insert(['student_newsfeed_comments_id' => $request->feeds_id, 
                                'students_id' => $request->user_id, 
                                'comments' => $request->comments,
                                'created_at' => date('Y-m-d H:i:s') ]);
            }
        }
    }

    public function profileFeeds($teachers_id, $feeds_id){
        $data = DB::table('teachers')->where('id', '=', Auth::id())->first();
        return view('teachers-profile', ['data' => $data, 'teachers_id' => $teachers_id, 'feeds_id' => $feeds_id]);
    }

    public function getLessonPlan(){
        $tol = DB::table('type_of_lesson')->select('*')->get();
        $obj = array();
        foreach ($tol as $trow) {
            $dlp = [];
            $lp = DB::table('lesson_plan')->where('type_of_lesson_id', '=', $trow->id)->get();
            if (!empty($lp)) {
                $dlp['label'] = $trow->lesson_type;
                foreach ($lp as $lprow) {
                    $dlp['options'][] = array(
                        'value'=>$lprow->id,
                        'text'=>$lprow->body
                    );
                }
                
            }
            array_push($obj, $dlp);
        }
        return response()->json($obj);
    }
    
    public function getStudentsLevel(){
        $sl = DB::table('students_level')->select('*')->get();
        $obj = array();
        foreach ($sl as $row) {
            array_push($obj, array(
                'value' => $row->id,
                'text' => $row->level
            ));
        }
        return response()->json($obj);
    }

    





}
