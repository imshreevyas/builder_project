<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Property;
use App\Models\User;
use App\Models\UserProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPwd;

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
        if ($request->photo) {
            if ($request->type == 1) {
                if (User::where('id', $request->user()->id)->update(['profile' => $request->photo]))
                    return response()->json(['message' => 'Image uploaded successfully', 'status' => 'success']);
            } else if ($request->type == 2) {
                if (User::where('id', $request->user()->id)->update(['aadhar' => $request->photo]))
                    return response()->json(['message' => 'Image uploaded successfully', 'status' => 'success']);
            } else if ($request->type == 3) {
                if (User::where('id', $request->user()->id)->update(['pancard' => $request->photo]))
                    return response()->json(['message' => 'Image uploaded successfully', 'status' => 'success']);
            }
            return response()->json(['message' => 'Something went wrong!', 'status' => 'fail'], 401);
        }

        return response()->json(['message' => 'No image uploaded', 'status' => 'fail'], 400);
    }
    public function updateNotificationId(Request $request)
    {
        if ($request->notificationId) {
            if (User::where('id', $request->user()->id)->update(['expo_push_token' => $request->notificationId]))
                return response()->json(['message' => 'Token updated successfully', 'status' => 'success']);
        }

        return response()->json(['message' => 'Please pass token', 'status' => 'fail'], 400);
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
                'status' => 'success'
            ], 200);
        else
            return response()->json(['message' => 'Something went wrong!', 'status' => 'fail'], 401);
    }
    public function forgotPassword(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
        ]);
        $randNum = rand(11111, 99999);
        $pass['password'] = Hash::make($randNum);
        $pass['dcrypt_password'] = $randNum;
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            $mailData = [
                'email' => $data['email'],
                'pwd' => $randNum
            ];
            Mail::to($data['email'])->send(new ForgotPwd($mailData));
            User::where('email', $data['email'])->update($pass);
            return response()->json(['message' => 'Email Verified successfully'], 201);
        } else {
            return response()->json(['message' => 'Email not found'], 409);
        }
        return response()->json(['message' => 'Something went wrong!', 'status' => 'fail'], 401);
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
