<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view('front.pages.todos.index', compact('todos'));
    }

    public function fetchTodo()
    {
        $todos = Todo::latest()->get();
        return response()->json(['todos' => $todos]);
    }

    public function edit($id)
    {
        $todo = Todo::find($id);
        if ($todo) {
            return response()->json([
                'status' => 200,
                'todo' => $todo
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Todo Not Found!'
            ]);
        }
    }

    public function store(Request $request)
    {
        // ====> Returns Array <==== //
        // $data = $request->validate([
        //     'title' => 'required',
        //     'description' => 'required',
        // ]);
        // $todo = Todo::create($data);
        // return redirect()->route('todo.index')->with('success', 'Todo created successfully!');

        // ====> Returns Object <==== //
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $todo = new Todo;
            $todo->title = $request->title;
            $todo->description = $request->description;
            $todo->save();
            return response()->json([
                'status' => 200,
                'message' => 'Task Added Successfully.'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $todo = Todo::find($id);
            if ($todo) {
                $todo->title = $request->title;
                $todo->description = $request->description;
                $todo->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Task Edited Successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Todo Not Found!'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);
        if ($todo) {
            $todo->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Task Deleted Successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Todo Not Found!'
            ]);
        }
    }
}
