<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{Comment, Role, CommentReply, Project, Task};
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Comment\CreateCommentRequest;
use App\Http\Requests\ReplyComment\CreateReplyCommentRequest;

class CommentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:list-comment|view-comment', ['only' => ['index']]);
        $this->middleware('permission:view-comment', ['only' => ['show']]);
    }
    public function index()
    {
        $userId = Auth()->user()->id;
        $roleName = Auth()->user()->roles[0]['name'];
        $role = Role::ROLE_NAME['User'];
        $project = [];
        if($roleName == $role) {
            $comment = Comment::where('user_id', $userId)->orderByDesc('id')->groupBy('task_id')->get();
            
            $project = Project::whereHas('user_project', function($q) use($userId) {
                $q->where('user_id', $userId);
            })->orderByDesc('id')->get();
        } else {
            $comment = Comment::where('parent_id', $userId)->orderByDesc('id')->groupBy('task_id')->get();
        }
        return view('pages.comments.index', compact('comment', 'project', 'roleName', 'role'));
    }
    public function store(CreateCommentRequest $request)
    {
        DB::beginTransaction();
        try {
            $userId = Auth()->user()->id;
            if ($request->file('file')) {
                $path = 'uploads/comments/';
                $file = $this->uploadFile($request->file, $path);
            }
            $comment = new Comment;
            $comment->parent_id  = Auth()->user()->parent_id;
            $comment->user_id    = $userId;
            $comment->task_id    = $request->task;
            $comment->project_id = $request->project;
            $comment->comments   = $request->comment;
            $comment->file       = !empty($request->file) ?
            $file['filePath'] : null;
            $comment->save();

            DB::commit();
            $request->session()->flash('message', trans('message.add_comment'));

            return response()->json(['status' => true, 'message' => trans('message.add_comment')]);
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage() ]);
        }
    }
    public function show($taskId)
    {
        DB::beginTransaction();
        try {
            $taskid = decrypt($taskId);
            $task = Task::find($taskid);
            if (!empty($task)) {
                $roleName = Auth()->user()->roles[0]['name'];
                $role = Role::ROLE_NAME['User'];
                $userId = Auth()->user()->id;
                if($roleName == $role) {
                    $comment = Comment::where(['user_id' => $userId, 'task_id' => $task->id])->get();
                } else {
                    $comment = Comment::where(['task_id' => $task->id])->get();
                }
                DB::commit();
                return view('pages.comments.view', compact('task', 'comment', 'roleName', 'role'));
            }else {
                return redirect()->route('comments.index')->with('error', trans('message.something_wrong'));
            }
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('comments.index')->with('error', $e->getMessage());
        }
    }
    public function getTask(Request $request)
    {
        DB::beginTransaction();
        try {
            $task = Task::select('id', 'title')
            ->where('project_id', $request->project_id)->get();

            DB::commit();
            return response()->json(['status'=>true, 'message' => $task]);
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>false, 'message' => $e->getMessage()]);
        }
    }
    public function replyComment(CreateReplyCommentRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->file('file')) {
                $path = 'uploads/comments/';
                $file = $this->uploadFile($request->file, $path);
            }
            $commentReply             = new CommentReply;
            $commentReply->user_id    = Auth()->user()->id;
            $commentReply->comment_id = $request->comment_id;
            $commentReply->comments	  = $request->comment;
            $commentReply->file       = !empty($request->file) ?
            $file['filePath'] : null;
            $commentReply->save();
            
            DB::commit();
            $request->session()->flash('message', trans('message.add_comment'));

            return response()->json(['status' => true, 'message' => trans('message.add_comment')]);
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage() ]);
        }
    }
    public function destroy($commentId)
    {
        DB::beginTransaction();
        try {
            $commentid = decrypt($commentId);
            $comment = Comment::find($commentid);
            if (!empty($comment)) {
                $this->unlinkFile($comment->file);
                $comment->delete();

                DB::commit();
                return redirect()->route('comments.index')
                ->with('success', trans('message.delete_comment'));
            }else {
                return redirect()->route('comments.index')
                ->with('error', trans('message.something_wrong'));
            }
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('comments.index')
            ->with('error', $e->getMessage());
        }
    }
}
