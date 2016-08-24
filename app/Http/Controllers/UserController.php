<?php

namespace rarasweb\Http\Controllers;

use Illuminate\Http\Request;

use rarasweb\Http\Requests;
use rarasweb\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use rarasweb\Role;
use rarasweb\RoleUser;
use rarasweb\User;


class UserController extends Controller
{
    /**
     * @var User
     */
    private $userModel;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Role
     */
    private $roleModel;
    /**
     * @var RoleUser
     */
    private $roleUserModel;

    public function __construct(User $userModel, Role $roleModel, RoleUser $roleUserModel, Request $request)
    {
        $this->userModel = $userModel;
        $this->request = $request;
        $this->roleModel = $roleModel;
        $this->roleUserModel = $roleUserModel;

//        if ((Gate::denies('user')))
//            abort(403, 'Not Allowed');
    }

    public function roles($id)
    {
        $user = $this->userModel->find($id);

        // recuperar permissions

        $roles = $user->roles;
        return view('admin.users.roles', compact('roles', 'user'));
    }

    public function index()
    {
        $users = $this->userModel->orderBy('name')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        $roles = $this->roleModel->orderBy('label')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function show($id)
    {
        $user = $this->userModel->find($id);
        return view('admin.users.show', compact('user'));
    }

    public function update($id)
    {
        $updateUser = $this->userModel->find($id);
        $roleUsers = $this->request->roleUsers;
        $this->roleUserModel
            ->where('user_id', $updateUser->id)
            ->delete();

        $updateUser->update($this->request->all());

        foreach ($roleUsers as $roleUser) {
            $newRoleUser = new RoleUser();
            $newRoleUser->role_id = $roleUser;
            $newRoleUser->user_id = $updateUser->id;
            $newRoleUser->save();
        }
        session()->flash('success', 'Usuário ' . $updateUser->name . ' foi editado com sucesso');

        return redirect('/admin/users');
    }



}
