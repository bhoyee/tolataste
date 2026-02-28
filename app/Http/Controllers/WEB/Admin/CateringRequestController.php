<?php


namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CateringRequest;

class CateringRequestController extends Controller
{
    public function index()
    {
        $requests = CateringRequest::latest()->get();
        return view('admin.catering_requests.index', compact('requests'));
    }

    public function show($id)
    {
        $catering = CateringRequest::findOrFail($id);
        return view('admin.catering_requests.show', compact('catering'));
    }

    public function destroy($id)
    {
        $request = CateringRequest::findOrFail($id);
        $request->delete();
    
        return redirect()->route('admin.catering.index')->with('success', 'Catering request deleted successfully.');
    }
    

    
}
