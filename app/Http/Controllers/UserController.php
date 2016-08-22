<?php

namespace rarasweb\Http\Controllers;

use Illuminate\Http\Request;

use rarasweb\Http\Requests;
use rarasweb\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use rarasweb\User;

class UserController extends Controller
{
    /**
     * @var User
     */
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;

        if ((Gate::denies('user')))
            abort(403, 'Not Allowed');
    }

    public function index(){
        $users = $this->userModel->all();

        return view('user.index', compact('users'));
    }

    public function roles($id){
        $user = $this->userModel->find($id);

        // recuperar permissions

        $roles = $user->roles;
        return view('admin.users.roles', compact('roles','user'));
    }
}
