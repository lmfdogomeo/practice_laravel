<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'role' => 'required|in:admin,merchant',
            'password' => 'required|string',
            'confirm_password' => 'required|same:password',
            "merchant_id" => 'required_if:role,merchant'
        ]);

        $user = new User([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password)
        ]);

        if ($user->save()) {

            if ($user->role === "merchant") {
                $merchantId = Merchant::where("uuid", $request->merchant_id)->first();
                if ($merchantId) {
                    $user->merchantUser()->create([
                        "merchant_id" => $merchantId->id,
                    ]);
                }
            }

            return response()->json([
                'status' => 'Success',
                'message' => 'Successfully registered',
                'data' => $user->with(["merchantUser", "merchantUser.merchant"])->where("id", $user->id)->first()
            ]);
        }

        throw new Exception("Failed to register. Please double check your details.", Response::HTTP_BAD_REQUEST);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember_me' => 'boolean'
        ]);

        $credentials = $request->only('email', 'password');
        $rememberMe = $request->remember_me ?? false;

        if (!Auth::attempt($credentials, $rememberMe)) {
            return response()->json([
                'status' => 'Unauthorize',
                'message' => 'Invalid email or password'
            ]);
        }

        $user = $request->user();
        $tokenResult = $user->createToken("Personal Access Token");
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'status' => 'Success',
            'message' => 'Successfully registered',
            'token_type' => 'bearer',
            'token' => $token
        ]);
    }
}
