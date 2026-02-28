<?php

namespace App\Http\Controllers\WEB\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Auth;

class AddressCotroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function store(Request $request){
        $rules = [
            'delivery_area_id'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
            'address'=>'required',
            'address_type'=>'required',
        ];
        $customMessages = [
            'delivery_area_id.required' => trans('user_validation.Delivery area is required'),
            'first_name.required' => trans('user_validation.First name is required'),
            'last_name.required' => trans('user_validation.Last name is required'),
            'address.required' => trans('user_validation.Address is required'),
            'address_type.required' => trans('user_validation.Address type is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = Auth::guard('web')->user();
        $is_exist = Address::where(['user_id' => $user->id])->count();
        $address = new Address();
        $address->user_id = $user->id;
        $address->delivery_area_id = $request->delivery_area_id;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->type = $request->address_type;
        if($is_exist == 0){
            $address->	default_address = 'Yes';
        }
        $address->save();

        $notification = trans('user_validation.Create Successfully');
        return response()->json(['address' => $address,'message' => $notification]);

    }

    public function update(Request $request, $id){

        $user = Auth::guard('web')->user();
        $address = Address::where(['user_id' => $user->id, 'id' => $id])->first();
        if(!$address){
            $notification = trans('user_validation.Something went wrong');
            return response()->json(['message' => $notification],403);
        }

        $rules = [
            'delivery_area_id'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
            'address'=>'required',
            'address_type'=>'required',
        ];
        $customMessages = [
            'delivery_area_id.required' => trans('user_validation.Delivery area is required'),
            'first_name.required' => trans('user_validation.First name is required'),
            'last_name.required' => trans('user_validation.Last name is required'),
            'address.required' => trans('user_validation.Address is required'),
            'address_type.required' => trans('user_validation.Address type is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $address->delivery_area_id = $request->delivery_area_id;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->type = $request->address_type;
        $address->save();

        $notification = trans('user_validation.Update Successfully');
        return response()->json(['address' => $address, 'message' => $notification]);
    }

    public function destroy($id){
        $user = Auth::guard('web')->user();
        $address = Address::where(['id' => $id])->first();

        if($address->default_address == 'Yes'){
            $notification = trans('user_validation.Opps!! Default address can not be delete.');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->back()->with($notification);
        }else{
            $address->delete();
            $notification = trans('user_validation.Delete Successfully');

            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->back()->with($notification);
        }
    }


    public function store_address_from_checkout(Request $request){
        $rules = [
            'delivery_area_id'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
            'address'=>'required',
            'address_type'=>'required',
        ];
        $customMessages = [
            'delivery_area_id.required' => trans('user_validation.Delivery area is required'),
            'first_name.required' => trans('user_validation.First name is required'),
            'last_name.required' => trans('user_validation.Last name is required'),
            'address.required' => trans('user_validation.Address is required'),
            'address_type.required' => trans('user_validation.Address type is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = Auth::guard('web')->user();
        $is_exist = Address::where(['user_id' => $user->id])->count();
        $address = new Address();
        $address->user_id = $user->id;
        $address->delivery_area_id = $request->delivery_area_id;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->type = $request->address_type;
        if($is_exist == 0){
            $address->	default_address = 'Yes';
        }
        $address->save();

        $notification = trans('user_validation.Create Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }
}

