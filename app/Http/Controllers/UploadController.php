<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Request;
use App\Models\Students;
use App\Models\Teachers;
use Auth;
use DB;
use Image;

class UploadController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(){
        // $this->middleware('auth');
    }

    
   public function uploadImage(Request $request){
        $req['data'] = json_decode($request['data']);
        $this->validate($request, [
            // 'photo' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
        ]);
        if ($req['data']->description == 'students') {
            $image = $request->file('photo');
            $stdnts = Students::where('id', $req['data']->students_id)->first();
            if ($stdnts->picture != '') {
                $deletethumb = public_path() . '\images\profile\students\thumb\\' . $stdnts->picture;
                $deleteimg = public_path() . '\images\profile\students\\' . $stdnts->picture;
                if (file_exists($deletethumb)) {
                    unlink($deletethumb);
                    unlink($deleteimg);
                }
            }
            $input['imagename'] = $stdnts->lastname.time().'.'.$image->extension();
            Students::where('id', $req['data']->students_id)
                                ->update(['picture' => $input['imagename']]);
            /**
             * Move thumb into thumb folder
             */
            $filePath = public_path('/images/profile/students/thumb');
            $img = Image::make($image->path());
            $img->fit(135, 135, function ($const) {
                // $const->aspectRatio();
            })->save($filePath.'/'.$input['imagename']);
            /**
             * Move actual size into main folder students
             */
            $filePath = public_path('/images/profile/students');
            $image->move($filePath, $input['imagename']);
        } else {
            if ($req['data']->type == 'video') {
                $video = $request->file('video');
                $lastname = Teachers::where('id', $req['data']->teachers_id)->first()->lastname;
                $input['videoname'] = $lastname.time().'.'.$video->extension();
                Teachers::where('id', $req['data']->teachers_id)
                                    ->update(['video' => $input['videoname']]);
                
                $filePath = public_path('/videos/teachers');
                $video->move($filePath, $input['videoname']);
            } else {
                $image = $request->file('photo');
                $tchrs = Teachers::where('id', $req['data']->teachers_id)->first();
                if ($tchrs->picture != '') {
                    $deletethumb = public_path() . '\images\profile\teachers\thumb\\' . $tchrs->picture;
                    $deleteimg = public_path() . '\images\profile\teachers\\' . $tchrs->picture;
                    if (file_exists($deletethumb)) {
                        unlink($deletethumb);
                        unlink($deleteimg);
                    }
                }
                $input['imagename'] = $tchrs->lastname.time().'.'.$image->extension();
                Teachers::where('id', $req['data']->teachers_id)
                                    ->update(['picture' => $input['imagename']]);
                /**
                 * Move thumb into thumb folder
                 */
                $filePath = public_path('/images/profile/teachers/thumb');
                $img = Image::make($image->path());
                $img->fit(135, 135, function ($const) {
                    // $const->aspectRatio();
                })->save($filePath.'/'.$input['imagename']);
                /**
                 * Move actual size into main folder teachers
                 */
                $filePath = public_path('/images/profile/teachers');
                $image->move($filePath, $input['imagename']);
            }
        }
        // return back()
        //     ->with('success','Image uploaded')
        //     ->with('fileName',$input['imagename']);
        return response()->json($input);
   }

    public function updateDefaultDp(Request $request){
        $teacher = Teachers::find(Auth::id());
        $teacher->display_status = $request->display_status;
        $teacher->save();
    }



}


