<?php

namespace App\Http\Controllers;
use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class   MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $media = Media::all();
        return \response()->json(['data'=>$media]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dir = 'uploads/'. date('Y/m/d');
        $dir1 = 'images/'. date('Y/m/d');

        $request->validate([
            'avatar' => 'image|mimes:png,jpg,svg|max:10240',

        ]);
        $media = new Media();

        $imageName = date('Ymd') .  Str::random(2);
        if ($request->avatar){
            $request->avatar->storeAs($dir1, $imageName);
            $request->avatar->move(public_path($dir), $imageName);
            $path = 'uploads/' . date('Y/m/d/')  . $imageName;
            $url_image = url($path);
            $media->avatar = $imageName;
            $media->path = $path;
            $media->url_path = $url_image;
        }
        $media->save();
        $respond = [
          'message'=> 'create success'  ,
           'media'=>$media
        ];
        if ($media) {
            return \response()->json($respond);
        } else {
            return \response()->json(['error' => 'create false']);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Media $media, Request $request)
    {
        $dir_public = 'uploads/'. date('Y/m/d');
        $dir_storage = 'public/images/'. date('Y/m/d');

        if ($request->avatar) {
            $imagePath = $media->path;
            $imageName = date('Ymd') . Str::random(2);
            $path = 'uploads/' . date('Y/m/d/')  . $imageName;
            $url_image = asset($path);
            $request->avatar->storeAs($dir_storage, $imageName);
            $request->avatar->move(public_path($dir_public), $imageName);
            $media->avatar = $imageName;
            $media->path = $path;
            $media->url_path = $url_image;
            $media->save();
            File::delete($imagePath);
            $respond = [
                'message'=> 'update success'  ,
                'media'=>$media
            ];
            return \response()->json($respond);
        }
            return \response()->json(['message'=>'update image please!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {

        $delete = $media->delete();
        $imagePath = $media->path;
        File::delete($imagePath);
        if ($delete) {
            return \response()->json(['success' => 'delete success']);
        } else {
            return \response()->json(['error' => 'delete false']);


        }

    }
}
