<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Purse;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $userData = $request->all();

        $validator = Validator::make($userData, [
            "username" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6|confirmed",
            "password_confirmation" => "required|min:6"
        ]);

        if ($validator->fails()) {
            return sendError('Validation Error', 422, $validator->errors());
        }

        $userData["password"] = Hash::make($userData['password']);

        try {
            $user = User::create($userData);

            $purseModel = new Purse;

            $purseModel->createPurse(["userId" => $user->id]);

            return sendResponse($user, 201);
        } catch (\Exception $e) {
            return sendError($e->getMessage());
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $userData = $request->only('email', 'password');

        $validator = Validator::make($userData, [
            "email" => "required|email",
            "password" => "required|min:6",
        ]);

        if ($validator->fails()) {
            return sendError('Validation Error', 422, $validator->errors());
        }

        if (!Auth::attempt($userData)) {
            return sendError("Email or password is incorrect");
        }

        $user = Auth::user();

        $response = [
            "user" => $user,
            "accessToken" => $user->createToken("accessToken")->accessToken
        ];

        return sendResponse($response);
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return sendResponse(["message" => "Logout is successful"]);
    }
}