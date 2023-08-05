<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            $customMessages = [
                'email.required' => 'O campo Nome é obrigatório.',
                'password.required' => 'O campo Senha é obrigatório.'
            ];

            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ], $customMessages);


            if ($validator->fails()) {
                return response()->json(["status" => "error", "message" => $validator->errors()], 422);
            }

            $auth = $this->loginService->execute($credentials);

            return response()->json(["status" => "success", "response" => $auth], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => "error", "message" => "Por favor, verifique seu email ou senha."], $e->getCode());
        }
    }

    public function user()
    {
        try {
            return response()->json(["status" => "success", "response" => auth()->user()], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function logout()
    {
        try {
            return response()->json(["status" => "success", "response" => auth()->logout(true)], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }
}
