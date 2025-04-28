<?php
namespace App\Http\Controllers;
use App\Http\Requests\Project\{CreateProjectRequest, UpdateProjectRequest};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\{Project, Role};

class ProjectController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:list-project|add-project|edit-project|delete-project', ['only' => ['index']]);
        $this->middleware('permission:add-project', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-project', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-project', ['only' => ['destroy']]);
    }
    public function index()
    {
        $userId = Auth()->user()->id;
        $roleName = Auth()->user()->roles[0]['name'];
        $role = Role::ROLE_NAME['User'];

        if($roleName == $role) {
            $projects = Project::whereHas('user_project', function($q) use($userId) {
                $q->where('user_id', $userId);
            })->orderByDesc('id')->get();
        } else {
            $projects = Project::where('user_id', $userId)->orderByDesc('id')->get();
        }
        $active = Project::STATUS['Active'];
        return view('pages.projects.index', compact('projects', 'active'));
    }
    public function create()
    {
        $status = Project::STATUS;
        return view('pages.projects.create', compact('status'));
    }
    public function store(CreateProjectRequest $request)
    {
        DB::beginTransaction();
        try {
            $project              = new Project;
            $project->user_id     = Auth()->user()->id;
            $project->name        = $request->name;
            $project->status      = $request->status;
            $project->description = $request->description;
            $project->save();

            DB::commit();
            return redirect()
                ->route('projects.index')
                ->with('success', trans('message.add_project'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->route('projects.create')
                ->withInput()->with('error', $e->getMessage());
        }
    }
    public function edit($projectId)
    {
        DB::beginTransaction();
        try {
            $projectid = decrypt($projectId);

            $project = Project::find($projectid);
            if (!empty($project)) {
                $status = Project::STATUS;

                DB::commit();
                return view('pages.projects.edit', compact('project', 'status'));
            }else {
                DB::rollback(); 
                return redirect()->route('projects.index')->with('error', trans('message.something_wrong'));
            }
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('projects.index')->with('error', $e->getMessage());
        }
    }
    public function update(UpdateProjectRequest $request, $projectId)
    {
        DB::beginTransaction();
        try {
            $projectid = decrypt($projectId);

            $project = Project::find($projectid);
            $project->name        = $request->name;
            $project->status      = $request->status;
            $project->description = $request->description;
            $project->save();

            DB::commit();
            return redirect()->route('projects.index')->with('success', trans('message.update_project'));
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('projects.edit', $projectId)->withInput()->with('error', $e->getMessage());
        }
    }
    public function destroy($projectId)
    {
        DB::beginTransaction();
        try {
            $projectid = decrypt($projectId);
            $project = Project::find($projectid);
            if (!empty($project)) {
                $project->delete();

                DB::commit();
                return redirect()->route('projects.index')->with('success', trans('message.delete_project'));
            }else {
                DB::rollback(); 
                return redirect()->route('projects.index')->with('error', trans('message.something_wrong'));
            }
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('projects.index')->with('error', $e->getMessage());
        }
    }
}
