<?php

namespace rarasweb\Http\Controllers;

use Illuminate\Http\Request;

use rarasweb\Http\Requests;
use rarasweb\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use rarasweb\Role;
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

    public function __construct(User $userModel,Role $roleModel ,Request $request)
    {
        $this->userModel = $userModel;
        $this->request = $request;
        $this->roleModel = $roleModel;

        if ((Gate::denies('user')))
        abort(403, 'Not Allowed');
    }

    public function roles($id){
        $user = $this->userModel->find($id);

        // recuperar permissions

        $roles = $user->roles;
        return view('admin.users.roles', compact('roles','user'));
    }

    public function index(){
        $users = $this->userModel->orderBy('name')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function edit($id){
        $user = $this->userModel->find($id);
        $roles = $this->roleModel->orderBy('label')->get();
        return view('admin.users.edit', compact('user','roles'));
    }
}
