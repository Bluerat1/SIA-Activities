<?php
  
namespace App\Http\Controllers;
   
use App\Models\Task;
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
        $data['tasks'] = Task::orderBy('id','desc')->paginate(5);
    
        return view('tasks.index', $data);
    }
     
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $Task = new Task;
        $Task->title = $request->title;
        $Task->description = $request->description;
        $Task->save();
     
        return redirect()->route('tasks.index')
                        ->with('success','Task has been created successfully.');
    }
     
    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('tasks.show',compact('task'));
    } 
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('tasks.edit',compact('task'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        
        $Task = Task::find($id);
        $Task->title = $request->title;
        $Task->description = $request->description;
        $Task->save();
    
        return redirect()->route('tasks.index')
                        ->with('success','Task Has Been updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
    
        return redirect()->route('tasks.index')
                        ->with('success','Task has been deleted successfully');
    }
}