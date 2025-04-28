<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\{Role, User, Project, Task};

class DashboardController extends Controller
{
    public function index()
    {
        $userId = \Auth::user()->id;
        $roleName = Auth::user()->roles[0]['name'];
        $userRole = Role::ROLE_NAME['User'];
        $user = User::where('parent_id', $userId)->count();
        $project = Project::where('user_id', $userId)->count();
        $task = Task::where('user_id', $userId)->count();
        $role = Role::count();
    
        return view('pages.dashboard.index', compact('user', 'project', 'task', 'role', 'roleName', 'userRole'));
    }
}
