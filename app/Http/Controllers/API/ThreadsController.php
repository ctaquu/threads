<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

/**
 *
 * @Controller(prefix="api/threads")
 *
 */
class ThreadsController extends Controller
{
    public function __construct()
    {
//        $this->middleware('guest')->except('logout');
    }


    /**
     * @Get("")
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'messages' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::where([
            'token' => $request->get('token'),
        ])->first();

        if (empty($user)) {
            return response()->json([
                'error' => true,
                'messages' => [
                    'invalid token',
                ]
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'error' => false,
            'messages' => [],
            'content' => [
                'threads' => $user->threads,
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
