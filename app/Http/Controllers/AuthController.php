<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller {
    public function login(Request $r){
        $r->validate(['username'=>'required','password'=>'required']);
        $user = User::where('username',$r->username)->first();
        if(!$user || !\Hash::check($r->password, $user->password)){
            return response()->json(['message'=>'Invalid credentials'], 401);
        }
        $token = $user->createToken('api')->plainTextToken;
        return response()->json(['token'=>$token]);
    }
    public function logout(Request $r){
        $r->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'ok']);
    }
}
