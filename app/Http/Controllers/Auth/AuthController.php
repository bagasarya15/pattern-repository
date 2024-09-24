<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\Auth\AuthInterface;
use App\Http\Requests\Auth\AuthRequest;

class AuthController extends Controller
{
    protected $authInterface;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function login(AuthRequest $request)
    {
        return $this->authInterface->login($request);
    }
}
