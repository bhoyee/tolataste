<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\BannerImage;
use Hash;
use Auth;
use Str;
use File;

class AdminProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $defaultProfile = BannerImage::whereId('15')->first();
        return view('admin.admin_profile', compact('admin', 'defaultProfile'));
    }
    
    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();
    
        // Validate input
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:admins,email,' . $admin->id,
            'password' => 'nullable|confirmed',
        ];
    
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'email.required' => trans('admin_validation.Email is required'),
            'email.unique' => trans('admin_validation.Email already exist'),
            'password.confirmed' => trans('admin_validation.Confirm password does not match'),
        ];
    
        $this->validate($request, $rules, $customMessages);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            \Log::info('🟢 Image upload detected');
    
            $file = $request->file('image');
            $filename = Str::slug($request->name) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $uploadFolder = 'uploads/website-images';
    
            // Force absolute path to public_html (outside Laravel root)
            $absolutePath = base_path('../public_html/' . $uploadFolder);
            \Log::info('Saving to: ' . $absolutePath);
    
            if (!File::isDirectory($absolutePath)) {
                File::makeDirectory($absolutePath, 0755, true);
                \Log::info('📁 Directory created at: ' . $absolutePath);
            }
    
            try {
                // Move the file
                $file->move($absolutePath, $filename);
                \Log::info('✅ File saved: ' . $absolutePath . '/' . $filename);
    
                // Delete old image if it exists
                if ($admin->image && File::exists(public_path($admin->image))) {
                    File::delete(public_path($admin->image));
                    \Log::info('🗑️ Old image deleted: ' . public_path($admin->image));
                }
    
                // Save relative path to DB
                $admin->image = $uploadFolder . '/' . $filename;
    
            } catch (\Exception $e) {
                \Log::error('❌ Image upload failed: ' . $e->getMessage());
            }
        }
    
        // Update profile fields
        $admin->name = $request->name;
        $admin->email = $request->email;
    
        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
    
        $admin->save();
    
        // Redirect with success message
        $notification = trans('admin_validation.Update Successfully');
        return redirect()->route('admin.profile')->with([
            'messege' => $notification,
            'alert-type' => 'success'
        ]);
    }



}
