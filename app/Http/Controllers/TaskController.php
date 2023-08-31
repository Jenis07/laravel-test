<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function add(Request $request){
        $validator=Validator::make($request->all(),[
            'task'=>'required|string',
            'user_id'=>'required'
        ]);
        if($validator->fails()){
            return response($validator->errors());
        }
        if(User::where('id',$request->user_id)->exists()){
            $task=new Task();
            $task->user_id=$request->user_id;
            $task->task=$request->task;
            $task->save();
            return response()->json(['task'=>$task,'status'=>1,'message'=>"Successfully created a task"]);
        }else{
            return response()->json(['message'=>"Invalid User",'status'=>0]);
        }
    }
    public function updateStatus(Request $request){
        $validator=Validator::make($request->all(),[
            'task_id'=>'required',
            'status'=>'required'
        ]);
        if($validator->fails()){
            return response($validator->errors());
        }
        if(Task::where('id',$request->task_id)->exists()){
            if($request->status=="pending"){
                $update=Task::where('id',$request->task_id)->update(['status'=>"pending"]);
                $task=Task::where('id',$request->task_id)->get();
                if($update){
                    return response()->json(['status'=>1,'message'=>"Marked task as pending",'task'=>$task]);
                }
            }else if($request->status=="done"){
                $update=Task::where('id',$request->task_id)->update(['status'=>"done"]);
                $task=Task::where('id',$request->task_id)->get();
                if($update){
                    return response()->json(['status'=>1,'message'=>"Marked task as done",'task'=>$task]);
                }
            }
        }else{
            return response()->json(['message'=>"Invalid Task ID",'status'=>0]);
        }
    }
}
