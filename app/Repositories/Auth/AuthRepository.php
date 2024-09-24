<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Auth\AuthInterface;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Resources\Master\UserResource;

class AuthRepository implements AuthInterface
{
    use ResponseTrait;

    public function login(AuthRequest $request)
    {
        try {
            $user = User::where("username", $request->username)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'username atau kata sandi salah'
                ]);
            }

            if ($user->tokens()->count()) {
                $user->tokens()->delete();
            }

            $token = $user->createToken('user-token')->plainTextToken;

            $resource = (new UserResource($user))
                ->additional(['token' => $token])->response()->getData(true);


            return response()->json([
                'status' => 200,
                'message' => "Login success",
                'records' => $resource
            ], 200);

        } catch (\Throwable $th) {
            return $th;
        }
    }
}
