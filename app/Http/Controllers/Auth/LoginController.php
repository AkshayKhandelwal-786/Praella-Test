<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateLoginRequest;
use Illuminate\Support\Facades\{DB, Hash, Auth};
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function store(CreateLoginRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $request->email)->first();
            if (!empty($user) && Hash::check($request['password'], $user->password)) {
                $active = User::STATUS['Active'];
                if ($user->status == $active) {
                    $userdata = array(
                        'email'    => $request->email,
                        'password' => $request['password'],
                    );
                    if (Auth::attempt($userdata)) {
                        DB::commit();
                        return redirect()->route('admin.dashboard')
                        ->with('success', trans('message.login'));
                    }else {
                        DB::rollback(); 
                        $error = trans('message.something_wrong');
                    }
                }else {
                    DB::rollback(); 
                    $error = trans('message.account_deactived');
                }
            }else {
                DB::rollback(); 
                $error = trans('message.credentials_not_match');
            }
            return redirect()->route('login')->withInput()
            ->with('error', $error);
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('login')
            ->withInput()->with('error', $e->getMessage());
        }
    }
    public function logout()
    {
        try {
            Auth::logout();
            return redirect()->route('login')
            ->with('success', trans('message.user-logout'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
