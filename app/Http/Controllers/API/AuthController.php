<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Validator;

/**
 * Class AuthController
 *
 * @Controller(prefix="authorization")
 *
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    public function __construct()
    {
//        $this->middleware('guest')->except('logout');
    }


    /**
     * @Post("register")
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'messages' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $token = sha1(rand(100000000000000, 999999999999999));

        $user = new User();
        $user->email = $request->get('email');
        $user->password = sha1($request->get('password'));
        $user->token = $token;
        $user->save();

        return response()->json([
            'error' => false,
            'messages' => [
                'new user created',
            ],
            'content' => [
                'token' => $token,
            ]
        ], Response::HTTP_CREATED);
    }

    /**
     * @Post("login")
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'messages' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::where([
            'email' => $request->get('email'),
            'password' => sha1($request->get('password')),
        ])->first();

        if (empty($user)) {
            return response()->json([
                'error' => true,
                'messages' => $validator->errors()
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'error' => false,
            'messages' => [
                'logged in!',
            ],
            'content' => [
                'user' => $user,
            ],
        ], Response::HTTP_OK);
    }
}
