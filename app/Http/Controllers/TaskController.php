<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \JWTAuth::parseToken()->authenticate();
        $tasks = $user->tasks()->orderBy('id','desc')->get();
        
        return response($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \JWTAuth::parseToken()->authenticate();
        $tasks = $user->tasks()->create($request->only('name'));
        // $tasks->save();

        return response($tasks->fresh(), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $tasks = Task::find($id);
        if ($request->filled('name')) {
            $tasks->fill($request->only('name'));
        }
        if ($request->filled('is_done')) {
            $tasks->fill($request->only('is_done'));
        }        
        $tasks->save();

        return response($tasks->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response(Task::destroy($id));
    }
}
