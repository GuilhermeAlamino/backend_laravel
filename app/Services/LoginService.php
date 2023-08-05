<?php

namespace App\Services;

use Exception;

class LoginService
{

  public function execute(array $credentials)
  {
    if (!$token = auth()->setTTL(60)->attempt($credentials)) {
      throw new Exception("Token expired.", 401);
    }

    return [
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth()->factory()->getTTL(),
    ];
  }
}
