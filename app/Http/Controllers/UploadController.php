<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Request;
use App\Models\Students;
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
        // // Validate (size is in KB)
        $req['data'] = json_decode($request['data']);
        // // Read file contents...
        // $contents = file_get_contents($request->photo->path());
        // // ...or just move it somewhere else (eg: local `storage` directory or S3)
        // $students_id = $request->students_id;
        // $request->photo->store('storage/uploads');
        // $request->file('photo')->move('storage/uploads', $students_id.'img');

        $this->validate($request, [
            'photo' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
        ]);

        $image = $request->file('photo');
        $input['imagename'] = $req['data']->students_id.'img'.'.'.$image->extension();
     
        $filePath = public_path('/images/profile');

        $img = Image::make($image->path());
        $img->resize(135, 135, function ($const) {
            $const->aspectRatio();
        })->save($filePath.'/'.$input['imagename']);
   
        $filePath = public_path('/images');
        $image->move($filePath, $input['imagename']);
   
        return back()
            ->with('success','Image uploaded')
            ->with('fileName',$input['imagename']);

   }



}


