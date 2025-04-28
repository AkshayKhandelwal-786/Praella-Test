<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateRegisterRequest;
use Illuminate\Support\Facades\{DB, Hash};
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function store(CreateRegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $user           = new User;
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->password = Hash::make($request->password);
            $user->status   = User::STATUS['Active'];
            $user->save();

            DB::commit();
            return redirect()
                ->route('login')
                ->with('success', trans('message.registration'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->route('register')
                ->withInput()->with('error', $e->getMessage());
        }
    }
}
