<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 *
 * @Controller(prefix="threads")
 *
 */
class ThreadsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * @Get("/")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('threads.index');
    }

    /**
     * @Get("/{id}")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('threads.show');
    }
}
