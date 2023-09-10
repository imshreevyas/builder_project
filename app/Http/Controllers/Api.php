<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Property;
use App\Models\User;
use App\Models\UserProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Api extends Controller
{
    //

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth')->plainTextToken;
            return response()->json([
                'message' => 'success',
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    public function profileUpdate(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $fileName); // This stores the image in storage/app/public/images
            $data['profile'] = 'storage/images/' . $fileName;
            User::where('id',$request->user()->id)->update($data);
            return response()->json(['message' => 'Image uploaded successfully']);
        }

        return response()->json(['message' => 'No image uploaded'], 400);
    }
    public function properties()
    {
        $data = Property::where('status', 1)->with('documents')->get();
        if ($data)
            return response()->json([
                'message' => 'success',
                'data' => $data
            ], 200);
        else
            return response()->json(['message' => 'Something went wrong!'], 401);
    }
    public function propertyDetail(Request $request)
    {
        $data = Property::where(['status' => 1, 'id' => $request->id])->with('documents')->get();
        if ($data)
            return response()->json([
                'message' => 'success',
                'data' => $data
            ], 200);
        else
            return response()->json(['message' => 'Something went wrong!'], 401);
    }
    public function userProperties(Request $request)
    {
        $data = UserProperty::where('user_id', $request->user()->id)->with('property.documents')->get();
        if ($data)
            return response()->json([
                'message' => 'success',
                'data' => $data
            ], 200);
        else
            return response()->json(['message' => 'Something went wrong!'], 401);
    }

    public function transactionList(Request $request)
    {
        $data = Payment::where(['status' => 1, 'user_id' => $request->user()->id, 'property_id' => $request->property_id])->get();
        if ($data)
            return response()->json([
                'message' => 'success',
                'data' => $data
            ], 200);
        else
            return response()->json(['message' => 'Something went wrong!'], 401);
    }

    public function transactionDetail(Request $request)
    {
        $data = Payment::where(['status' => 1, 'user_id' => $request->user()->id, 'id' => $request->id])->with('property.documents')->get();
        if ($data)
            return response()->json([
                'message' => 'success',
                'data' => $data
            ], 200);
        else
            return response()->json(['message' => 'Something went wrong!'], 401);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        $pass['password'] = Hash::make($data['password']);
        $pass['dcrypt_password'] = $data['password'];
        if (User::where('id', $request->user()->id)->update($pass))
            return response()->json([
                'message' => 'Password changed successfully!',
                'status' => 1
            ], 200);
        else
            return response()->json(['message' => 'Something went wrong!', 'status' => 0], 401);
    }
    public function userLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout successfully!',
            'status' => 1
        ], 200);
    }
}
