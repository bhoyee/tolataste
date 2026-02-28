<?php
namespace App\Http\Controllers\WEB\Admin;
use App\Http\Controllers\Controller;
use App\Models\ProductGallery;
use App\Models\Product;
use Illuminate\Http\Request;
use Image;
use File;
use Str;
class ProductGalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index($productId)
    {
        $product = Product::find($productId);
        if($product){
            $gallery = ProductGallery::where('product_id',$productId)->get();

            return view('admin.product_image_gallery',compact('gallery','product'));
        }else{
            $notification = trans('admin_validation.Something went wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('admin.product.index')->with($notification);
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'images' => 'required',
            'product_id' => 'required',
        ];

        $customMessages = [
            'images.required' => trans('admin_validation.Image is required'),
            'product_id.required' => trans('admin_validation.Product is required'),
        ];
        $this->validate($request, $rules,$customMessages);

     $product = Product::find($request->product_id);

        if($product){
            if($request->images){
foreach ($request->images as $file) {
    $ext = $file->getClientOriginalExtension();
    $generatedName = 'Gallery' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $ext;

    // This is the actual server path
    $imageDir = base_path('../public_html/uploads/custom-images');

    if (!is_dir($imageDir)) {
        mkdir($imageDir, 0755, true); // create if not exists
    }

    // Save path for DB and HTML usage
    $relativePath = 'uploads/custom-images/' . $generatedName;
    $absolutePath = $imageDir . '/' . $generatedName;

    // Save image
    \Image::make($file)->save($absolutePath);

    // Store in DB
    $gallery = new \App\Models\ProductGallery();
    $gallery->product_id = $request->product_id;
    $gallery->image = $relativePath;
    $gallery->save();
}

                $notification = trans('admin_validation.Uploaded Successfully');
                $notification=array('messege'=>$notification,'alert-type'=>'success');
                return redirect()->back()->with($notification);
            }
        }else{
            $notification = trans('admin_validation.Something went wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
    }

    public function destroy($id)
    {
        $gallery = ProductGallery::find($id);
    
        if (!$gallery) {
            $notification = trans('admin_validation.Gallery Not Found');
            return redirect()->back()->with([
                'messege' => $notification,
                'alert-type' => 'error',
            ]);
        }
    
        $old_image = $gallery->image;
    
        $gallery->delete();
    
        if ($old_image && File::exists(public_path($old_image))) {
            @unlink(public_path($old_image));
        }
    
        $notification = trans('admin_validation.Delete Successfully');
        return redirect()->back()->with([
            'messege' => $notification,
            'alert-type' => 'success',
        ]);
    }
    
}
