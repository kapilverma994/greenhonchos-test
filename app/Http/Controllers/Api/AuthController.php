<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $id = 1;

        $data = Storage::disk('public')->get('text.json');

        $data = json_decode($data, true);
        if (!empty($data)) {
            $id = count($data) + 1;
        }
        $add_arr = [
            "user_id" => $id,
            "username" => $request->username,
            "email" => $request->email,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "password" => $request->password,
        ];
        $data[] = $add_arr;
        Storage::disk('public')->put('text.json', json_encode($data));
        return response()->json(['user_id' => $id], 200);
    }


    public function getalluser()
    {
        $data = Storage::disk('public')->get('text.json');
        $res = json_decode($data);
        return response()->json($res);
    }

    public function updateuser(Request $request, $id = null)
    {

        $data = Storage::disk('public')->get('text.json');

        $data_array = json_decode($data, true);

        $row = $data_array[$id - 1];


        $update_arr = array(
            "user_id" => $id,
            "username" => $request->username,
            "email" => $request->email,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "password" => $request->password,
        );
        $data_array[$id - 1] = $update_arr;
        $data = json_encode($data_array, true);

        Storage::disk('public')->put('text.json', $data);
        return response()->json($update_arr);
    }
}
