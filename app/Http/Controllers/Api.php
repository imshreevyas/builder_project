<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Api extends Controller
{
    //

    
    public function properties(){
        $data=Property::where('status',1)->with('documents')->get();
        if($data)
        return response()->json([
            'message' => 'success',
            'data' => $data
        ],200);
        else
        return response()->json(['message' => 'Something went wrong!'], 401);
    }
}
