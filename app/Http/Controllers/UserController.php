<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();

        if ($authUser->username === 'superadmin') {
            $users = User::where('id', '!=', $authUser->id)->get();
        } else {
            $users = User::where('id', $authUser->id)->get();
        }

        return view('admin.users.index', ['users' => $users]);

        // return view('admin.users.index', ['users' => User::all()]);
    }

    public function create()
    {
        $roles = Role::where('id', '!=', '1')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required|unique:users',
                'email' => 'nullable|email|unique:users',
                'password' => 'required|min:6',
                'role_id' => 'required',
                'status' => 'required'
            ],
            [
                'name.required' => __('validation.custom_edit.name.required'),
                'username.required' => __('validation.custom_edit.username.required'),
                'username.unique' => __('validation.custom_edit.username.unique'),
                'email.email' => __('validation.custom_edit.email.email'),
                'email.unique' => __('validation.custom_edit.email.unique'),
                'password.required' => __('validation.custom_edit.password.required'),
                'password.min' => __('validation.custom_edit.password.min'),
                'status.required' => __('validation.custom_edit.status.required'),
                'role_id' => __('validation.custom_edit.role_id.required'),
            ],

            // [
            //     'name.required' => 'The name field is required.',
            //     'username.required' => 'The username field is required.',
            //     'username.unique' => 'The username has already been taken.',
            //     // 'email.required' => 'The email field is required.',
            //     'email.email' => 'The email must be a valid email address.',
            //     'email.unique' => 'The email has already been taken.',
            //     'password.required' => 'The password field is required.',
            //     'password.min' => 'The password must be at least 6 characters.',
            //     'status.required' => 'The status field is required.',
            // ]
        );

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => '1',
            'role_id' => $request->role_id,
            'status' => $request->status
        ]);

        $user->userSetting()->create([
            'notifications_enabled' => $request->notifications_enabled,
        ]);

        return redirect()->route('user.index')->with('success', __('layouts.created_successfully'));
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        // $user is already the User model
        $roles = Role::where('id', '!=', 1)->get(); // exclude super-admin role

        if ($user->role_id != 1) {
            return view('admin.users.edit', compact('user', 'roles'));
        }

        // Optionally handle if user is super-admin
        return redirect()->route('user.index')->with('error', 'Cannot edit super-admin.');

        // return view('admin.users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // dd($request->all());
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required|unique:users,username,' . $user->id,
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'password' => 'nullable|min:6',
                'status' => 'required',
            ],
            [
                'name.required' => __('validation.custom_edit.name.required'),
                'username.required' => __('validation.custom_edit.username.required'),
                'username.unique' => __('validation.custom_edit.username.unique'),
                'email.email' => __('validation.custom_edit.email.email'),
                'email.unique' => __('validation.custom_edit.email.unique'),
                'password.min' => __('validation.custom_edit.password.min'),
                'status.required' => __('validation.custom_edit.status.required'),
            ],
        );

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'status' => $request->status,
            'role_id' => $request->role_id,
        ]);

        $user->userSetting()->create([
            'notifications_enabled' => $request->notifications_enabled,
        ]);

        return redirect()->route('user.index')->with('success',  __('layouts.updated_successfully'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success',  __('layouts.deleted_successfully'));
    }

    public function userSettings()
    {
        $user = auth()->user();
        $userSettings = UserSetting::where('user_id', $user->id)->with('country')->first();
        // $countries = Country::all();
        return view('admin.users.settings', compact('user', 'userSettings'));
    }

    public function updateUserSettings(Request $request)
    {
        $user = auth()->user();
        UserSetting::updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'country_id' => $request->country_id,
                'language' => $request->language,
                'notifications_enabled' => $request->notifications_enabled,
            ]
        );

        return redirect()->route('users.settings', ['lang' => $request->language])
            ->with('success', __('layouts.settings_updated_successfully'));
    }

    public function userProfileUpdate()
    {
        $user = auth()->user();
        // dd($user);
        // $userSettings = UserSetting::where('user_id', $user->id)->with('country')->first();
        // $countries = Country::all();
        return view('admin.users.profile_update', compact('user'));
    }

    public function storeUserProfileUpdate(Request $request)
    {
        $user = auth()->user();

        $request->validate(
            [
                'name' => 'required',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
            ],
            [
                'name.required' => __('validation.custom_edit.name.required'),
                'email.email' => __('validation.custom_edit.email.email'),
                'email.unique' => __('validation.custom_edit.email.unique'),
            ],
        );

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.profileUpdate')->with('success', __('layouts.user_profile_updated'));
    }

    public function changePassword()
    {
        $user = auth()->user();
        return view('admin.users.change_password', compact('user'));
    }

    public function storeChangePassword(Request $request)
    {
        $user = auth()->user();

        // dd($request->all());

        $request->validate(
            [
                'current_password' => 'required',
                'password' => 'required|min:6|confirmed',
            ],
            [
                'current_password.required' => __('validation.custom_edit.current_password.required'),
                'password.required' => __('validation.custom_edit.password.required'),
                'password.min' => __('validation.custom_edit.password.min'),
                'password.confirmed' => __('validation.custom_edit.password.confirmed'),
            ]
        );


        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => __('validation.custom_edit.current_password.invalid')]);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('user.changePassword')->with('success', __('layouts.password_changed_successfully'));
    }
}
