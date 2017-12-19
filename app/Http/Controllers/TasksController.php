<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index(){
    	$tasks = Task::all();
    	return view('list', compact('tasks'));
    }

    public function create(Request $request){
    	$task = new Task;
    	$task->task = $request->text;
    	$task->save();
    	return 'Done';
    }

    public function delete(Request $request){
        Task::where('id', $request->id)->delete();
        return $request->all();
    }

    public function update(Request $request){
        $task = Task::find($request->id);
        $task->task = $request->value;
        $task->save();
        return $request->all();
    }
}
