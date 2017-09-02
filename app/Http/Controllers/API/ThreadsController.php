<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Thread;
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
        $this->middleware('check.token');
    }


    /**
     * @Get("/")
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = User::where([
            'token' => $request->get('token'),
        ])->first();

        return response()->json([
            'error' => false,
            'messages' => [],
            'content' => [
                'threads' => $user->threads,
            ]
        ], Response::HTTP_CREATED);
    }

    /**
     * @Get("/{id}")
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json([
            'error' => false,
            'messages' => [],
            'content' => [
                'thread' => Thread::find($id),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * @Post("/")
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'desc' => 'required|string',
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

        $thread = new Thread();
        $thread->title = $request->get('title');
        $thread->desc = $request->get('desc');
        $thread->user()->attach($user->id);
        $thread->save();

        return response()->json([
            'error' => false,
            'messages' => [],
            'content' => [
                'thread' => $thread,
            ]
        ], Response::HTTP_CREATED);
    }

    /**
     * @Delete("/{id}")
     * @param $id
     */
    public function destroy(Request $request, $id)
    {
        $thread = Thread::find($id);

        if (empty($thread)) {
            return response()->json([
                'error' => true,
                'messages' => 'thread not found!',
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::where([
            'token' => $request->get('token'),
        ])->first();

        if ($user->id !== $thread->user->id) {
            return response()->json([
                'error' => true,
                'messages' => 'thread is not yours!',
            ], Response::HTTP_BAD_REQUEST);
        }

        $thread->delete();

        return response()->json([
            'error' => false,
            'messages' => [],
            'content' => [
                'thread' => $thread,
            ]
        ], Response::HTTP_OK);
    }
}
