<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Request;
use App\Models\Teachers;
use App\Models\Students;
use App\Models\TeacherFeeds;
use App\Models\TeacherFeedsAttachments;
use Auth;
use DB;

class FeedsController extends Controller{


    public function postTeacherFeeds(Request $request){
        // return response()->json(['message'=>'route reached'], 200);

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

    public function displayTeacherFeeds(Request $request){
        // $teachers_id = $request->teachers_id;
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
        $c = [];
        foreach ($comments_result as $r) { $c[$r->teacher_newsfeed_id][] = $r; }
        // $q = [];
        // foreach ($question as $k => $v) { $d[$k] = $v; }
        // dd($c[14]);
        return response()->json(['question' => $question, 'comments' => $c]);
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
                DB::table('teacher_newsfeed_likes')
                    ->updateOrInsert(
                        [ 'teacher_newsfeed_id' => $request->feeds_id, 'students_id' => $request->user_id ],
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
                DB::table('teacher_newsfeed_com_usefull')
                    ->updateOrInsert(
                        [ 'teacher_newsfeed_com_id' => $request->feeds_id, 'students_id' => $request->user_id ],
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
                DB::table('teacher_newsfeed_com_likes')
                    ->updateOrInsert(
                        [ 'teacher_newsfeed_com_id' => $request->feeds_id, 'students_id' => $request->user_id ],
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
                DB::table('teacher_newsfeed_comments')
                    ->insert(['teacher_newsfeed_id' => $request->feeds_id, 
                                'students_id' => $request->user_id, 
                                'comments' => $request->comments,
                                'created_at' => date('Y-m-d H:i:s') ]);
            }
        } else {
           
        }
    }

    





}
