<?php

namespace App\Http\Controllers;
use App\Http\Requests\User\{CreateUserRequest, UpdateUserRequest};
use App\Models\{User, Role, UserProject, ModelHasRole};
use Illuminate\Support\Facades\{DB, Hash, Auth};
use App\Models\{Task, Project};
use Illuminate\Http\Request;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:list-user|add-user|edit-user|delete-user', ['only' => ['index']]);
        $this->middleware('permission:add-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }
    public function index()
    {
        $userId = Auth::user()->id;        
        $users = User::where('parent_id', $userId)->OrderBy('id', 'desc')->get();
        $active = User::STATUS['Active'];
        $role = Role::ROLE_NAME['Admin'];

        return view('pages.users.index', compact('users', 'active', 'role'));
    }
    public function create()
    {
        $role = Role::get();
        $status = User::STATUS;
        $user = Role::ROLE_NAME['User'];
        $project = Project::whereHas('task')->where('user_id', Auth::user()->id)->OrderByDesc('id')->get();
        return view('pages.users.create', compact('role', 'status', 'project', 'user'));
    }
    public function store(CreateUserRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->file('profile_picture')) {
                $path = 'uploads/users/';
                $file = $this->uploadFile($request->profile_picture, $path);
            }
            $user                      = new User;
            $user->parent_id           = \Auth::user()->id;
            $user->name                = $request->name;
            $user->email               = $request->email;
            $user->password            = Hash::make($request->password);
            $user->status              = $request->status;
            $user->bio                 = $request->bio;
            $user->profile_picture     = !empty($request->profile_picture) ?
            $file['filePath'] : null;
            $user->phone_number        = $request->phone_number;
            $user->save();
            $userId = $user->id;
            $user->assignRole($request->role);

            if(isset($request->project) && !empty($request->project)) {
                foreach ($request->project as $row) {
                    $task = Task::select('id', 'project_id')
                            ->where('project_id', $row)->first();

                    $userProject = new UserProject;
                    $userProject->user_id    = $userId;
                    $userProject->task_id    = $task->id;
                    $userProject->project_id = $row;
                    $userProject->save();
                }
            }
            
            DB::commit();
            $request->session()->flash('message', trans('message.add_user'));

            return response()->json(['status' => true, 'message' => trans('message.add_user')]);

        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage() ]);
        }
    }
    public function edit($userId)
    {
        DB::beginTransaction();
        try {
            $userid = decrypt($userId);
            $user = User::find($userid);
            if (!empty($user)) {
                $role = Role::get();
                $status = User::STATUS;
                $project = Project::whereHas('task')->where('user_id', Auth::user()->id)->OrderByDesc('id')->get();
                $userRole = Role::ROLE_NAME['User'];

                $userProject = UserProject::where('user_id', $userid)->pluck('project_id')->toArray();
                
                DB::commit();
                return view('pages.users.edit', compact('role', 'status', 'project', 'user','userProject', 'userRole'));
            }else {
                DB::rollback(); 
                return redirect()->route('users.index')
                ->with('error', trans('message.something_wrong'));
            }
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('users.index')
            ->with('error', $e->getMessage());
        }
    }
    public function update(UpdateUserRequest $request, $userId)
    {
        DB::beginTransaction();
        try {
            $userid = decrypt($userId);

            $user = User::find($userid);
            if (!empty($user)) {
                if ($request->file('profile_picture')) {
                    $this->unlinkFile($user->profile_picture);

                    $path = 'uploads/users/';
                    $file = $this->uploadFile($request->profile_picture, $path);
                }
                $user->name                = $request->name;
                $user->email               = $request->email;
                $user->password            = !empty($request->password) ?
                Hash::make($request->password) : $user->password;
                $user->status              = $request->status;
                $user->bio                 = $request->bio;
                $user->profile_picture     = !empty($request->profile_picture) ?
                $file['filePath'] : $user->profile_picture;
                $user->phone_number        = $request->phone_number;
                $user->save();
                $userId = $user->id;

                ModelHasRole::where('model_id', $userId)->delete();
                $user->assignRole($request->role);

                UserProject::where('user_id', $userId)->delete();


                foreach ($request->project as $row) {
                    $task = Task::select('id', 'project_id')
                               ->where('project_id', $row)->first();
    
                    $userProject = new UserProject;
                    $userProject->user_id    = $userId;
                    $userProject->task_id    = $task->id;
                    $userProject->project_id = $row;
                    $userProject->save();
                }

                DB::commit();
                $request->session()->flash('message', trans('message.update_user'));

                return response()->json(['status' => true, 'message' => trans('message.update_user')]);

            }else {
                DB::rollback();
                return response()->json(['status' => false, 'message' => trans('message.something_wrong') ]);
            }
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage() ]);
        }
    }
    public function destroy($userId)
    {
        DB::beginTransaction();
        try {
            $userid = decrypt($userId);
            $user = User::find($userid);
            if (!empty($user)) {
                $this->unlinkFile($user->profile_picture);
                $user->delete();

                DB::commit();
                return redirect()->route('users.index')
                ->with('success', trans('message.delete_user'));
            }else {
                return redirect()->route('users.index')
                ->with('error', trans('message.something_wrong'));
            }
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('users.index')
            ->with('error', $e->getMessage());
        }
    }
}
