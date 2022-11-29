<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Task;

class TaskController extends Controller
{
    public function index() {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        };

        $task = new Task;
        $task->name = $request->name;
        $task->due_date = $request->due_date;
        $task->done = $request->done;
        $task->save();

        return response()->json($task, 201);
    }

    public function show($id) {
        $task = Task::where('id',$id)->first();

        if(!$task) {
            return response()->json('Task not found', 404);
        }else{
            return response()->json($task, 200);
        }
    }

    public function update($id, Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        };

        $task = Task::where('id',$id)->first();

        if(!$task) {
            return response()->json('Task not found', 404);
        }

        $task->name = $request->name;
        $task->due_date = $request->due_date;
        $task->done = $request->done;
        $task->save();

        return response()->json($task, 201);
    }

    public function delete($id) {
        $task = Task::where('id',$id)->first();

        if(!$task) {
            return response()->json('Task not found', 404);
        }

        $task->delete();

        return response()->json('Task deleted!', 204);
    }
}
