<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\Task\{CreateTaskRequest, UpdateTaskRequest};
use App\Http\Requests\Comment\CreateCommentRequest;
use Illuminate\Support\Facades\DB;
use App\Models\{Task, Project, Role, Comment};
use Helpers;

class TaskController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:list-task|add-task|edit-task|delete-task', ['only' => ['index']]);
        $this->middleware('permission:add-task', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-task', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-task', ['only' => ['destroy']]);

    }
    public function index()
    {
        $userId = Auth()->user()->id;
        $roleName = Auth()->user()->roles[0]['name'];
        $role = Role::ROLE_NAME['User'];

        if($roleName == $role) {
            $task = Task::whereHas('user_task', function($q) use($userId) {
                $q->where('user_id', $userId);
            })->orderByDesc('id')->get();
        } else {
            $task = Task::where('user_id', $userId)->orderByDesc('id')->get();
        }
        $status = Task::STATUS;
        $priority = Task::PRIORITY;
        return view('pages.tasks.index', compact('task', 'status', 'priority'));
    }
    public function create()
    {
        $userId = Auth()->user()->id;
        $status = Task::STATUS;
        $priority = Task::PRIORITY;
        $project = Project::where(['user_id' => $userId, 'status' => Project::STATUS['Active']])
        ->orderByDesc('id')->get();
        
        return view('pages.tasks.create', compact('status', 'project', 'priority'));
    }
    public function store(CreateTaskRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->file('file')) {
                $path = 'uploads/task/';
                $file = $this->uploadFile($request->file, $path);
            }

            $task              = new Task;
            $task->user_id     = Auth()->user()->id;
            $task->title       = $request->title;
            $task->project_id  = $request->project;
            $task->priority    = $request->priority;
            $task->start_date  = Helpers::dateFormat($request->start_date);
            $task->deadline    = Helpers::dateFormat($request->deadline);
            $task->status      = $request->status;
            $task->description = $request->description;
            $task->file        = !empty($request->file) ?
            $file['filePath'] : null;
            $task->save();

            DB::commit();
            return redirect()
                ->route('tasks.index')
                ->with('success', trans('message.add_project'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->route('tasks.create')
                ->withInput()->with('error', $e->getMessage());
        }
    }
    public function edit($taskId)
    {
        DB::beginTransaction();
        try {
            $taskid = decrypt($taskId);
            $task = Task::find($taskid);
            if (!empty($task)) {
                $userId = Auth()->user()->id;
                $status = Task::STATUS;
                $priority = Task::PRIORITY;
                $project = Project::where('user_id', $userId)->orderByDesc('id')->get();
        
                DB::commit();
                return view('pages.tasks.edit', compact('task', 'status', 'priority', 'project'));
            }else {
                return redirect()->route('tasks.index')->with('error', trans('message.something_wrong'));
            }
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('tasks.index')->with('error', $e->getMessage());
        }
    }
    public function update(UpdateTaskRequest $request, $taskId)
    {
        DB::beginTransaction();
        try {
            $taskid = decrypt($taskId);

            $task = Task::find($taskid);
            if ($request->file('file')) {
                $this->unlinkFile($task->file);

                $path = 'uploads/task/';
                $file = $this->uploadFile($request->file, $path);
            }
            $task->title       = $request->title;
            $task->project_id  = $request->project;
            $task->priority    = $request->priority;
            $task->start_date  = Helpers::dateFormat($request->start_date);
            $task->deadline    = Helpers::dateFormat($request->deadline);
            $task->status      = $request->status;
            $task->description = $request->description;
            $task->file        = !empty($request->file) ? $file['filePath'] : $task->file;
            $task->save();

            DB::commit();
            return redirect()->route('tasks.index')->with('success', trans('message.update_task'));
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('tasks.edit', $taskId)->withInput()->with('error', $e->getMessage());
        }
    }
    public function destroy($taskId)
    {
        DB::beginTransaction();
        try {
            $taskid = decrypt($taskId);
            $task = Task::find($taskid);
            if (!empty($task)) {
                $task->delete();

                DB::commit();
                return redirect()->route('tasks.index')->with('success', trans('message.delete_task'));
            }else {
                return redirect()->route('tasks.index')->with('error', trans('message.something_wrong'));
            }
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('tasks.index')->with('error', $e->getMessage());
        }
    }
}
