<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use Request;
use App\Models\Teachers;
use App\Models\Students;
use App\Models\Messages;
use App\Models\Admins;
use App\Events\Message;
use Auth;
use DB;

class ChatController extends Controller{

    public function message(){
        $messages = new Messages;
        $usertype = Request::post('usertype');
        if ($usertype == 'students') {
            $messages->students_id = Auth::id();
            $messages->teachers_id = Request::post('user_id');
        } else {
            $messages->teachers_id = Auth::id();
            $messages->students_id = Request::post('user_id');
        }
        $messages->messages = Request::post('message');
        $messages->is_teacher = Request::post('is_teacher');
        $messages->save();
        event(new Message(Request::post('message'), Request::post('usertype'), Request::post('client_id'), Request::post('user_id'), Request::post('is_teacher'), Request::post('username')));
        
        return [Request::post('usertype')];
    }

    public function startChat($id){
        // $teachers_id = $id;
        // if ($teachers_id) {
        //     return redirect()->intended('/');
        // }
        // dd([$id, $students_id]);
        $routeS = Request::segment(1);
        if ($routeS == 'start-chat-teachers') {
            $data = DB::table('teachers')->where('id', '=', Auth::id())->first();
            $messageDisplay = DB::table('teachers')->where('id', '=', Auth::id())->get();
            $teachers_id = null;
            $students_id = $id;
            return view('teachers', ['data' => $data, 'uri' => 'chat', 'teachers_id' => $teachers_id, 'students_id' => $students_id ]);
        } else {
            $data = DB::table('students')->where('id', '=', Auth::id())->first();
            $messageDisplay = DB::table('students')->where('id', '=', Auth::id())->get();
            $teachers_id = $id;
            $students_id = null;
            return view('students', ['data' => $data, 'messageDisplay' => $messageDisplay, 'teachers_id' => $teachers_id, 'students_id' => $students_id ]);
        }
    }
    
    public function getConversation(){
        $user_id = Auth::id();
        $other_user_id = Request::post('user_id');
        $usertype = Request::post('usertype');
        if ($usertype == 'teachers') {
            $messages = Messages::where('messages.teachers_id', $user_id)
                            ->where('messages.students_id', $other_user_id)
                            ->leftJoin('teachers', 'messages.teachers_id', '=', 'teachers.id')
                            ->leftJoin('students', 'messages.students_id', '=', 'students.id')
                            ->select('messages.*', DB::raw("concat(teachers.lastname, ', ', teachers.firstname) as teachers_name"), 
                                DB::raw("concat(students.lastname, ', ', students.firstname) as students_name"))
                            ->groupBy('messages.id')
                            ->get();

    
        } else {
            $messages = Messages::where('messages.teachers_id', $other_user_id)
                            ->where('messages.students_id', $user_id)
                            ->leftJoin('teachers', 'messages.teachers_id', '=', 'teachers.id')
                            ->leftJoin('students', 'messages.students_id', '=', 'students.id')
                            ->select('messages.*', DB::raw("concat(teachers.lastname, ', ', teachers.firstname) as teachers_name"), 
                                DB::raw("concat(students.lastname, ', ', students.firstname) as students_name"))
                            ->groupBy('messages.id')
                            ->get();

        }
        
        $obj = array();
        $dlp = [];
        foreach ($messages as $trow) {
            $dlp[] = array(
                'msg'=>$trow->messages,
                'time'=>date('h:i A', strtotime($trow->create_at)),
                'username'=> $trow->is_teacher == 0 ? $trow->students_name : $trow->teachers_name,
                'usertype' => $usertype,
                'client_id' => $user_id,
                'is_teacher' => $trow->is_teacher
            );
        }
        $obj[] = $dlp;
        return response()->json($obj);
    }


}
