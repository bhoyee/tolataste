<?php

namespace App\Http\Controllers\Web\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleryImages = Gallery::all();
        return view('admin.gallery.index', compact('galleryImages'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048', // Validate image (max 2MB)
        ]);
    
        $file = $request->file('image');
        $filename = 'gallery_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
    
        $uploadPath = base_path('../public_html/uploads/gallery');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
    
        $file->move($uploadPath, $filename);
    
        $gallery = new \App\Models\Gallery();
        $gallery->image_path = $filename;
        $gallery->save();
    
        return redirect()->back()->with('success', 'Image uploaded successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Gallery::findOrFail($id);
        $path = base_path('../public_html/uploads/gallery/' . $image->image_path);
    
        if (file_exists($path)) {
            unlink($path);
        }
    
        $image->delete();
    
        return redirect()->back()->with('success', 'Image deleted successfully.');
    }
    
}
