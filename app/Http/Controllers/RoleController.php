<?php

namespace rarasweb\Http\Controllers;

use Illuminate\Http\Request;

use rarasweb\Http\Requests;
use rarasweb\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use rarasweb\Permission;
use rarasweb\PermissionRole;
use rarasweb\Role;

class RoleController extends Controller
{
    private $roleModel;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Permission
     */
    private $permissionModel;
    /**
     * @var PermissionRole
     */
    private $permissionRoleModel;

    public function __construct(Request $request, Role $roleModel, Permission $permissionModel,
                                    PermissionRole $permissionRoleModel)
    {
        $this->roleModel = $roleModel;
        $this->request = $request;
        $this->permissionModel = $permissionModel;
        $this->permissionRoleModel = $permissionRoleModel;

        if ((Gate::denies('user')))
        abort(403,'Not Allowed');
    }

    public function index(){
        $roles = $this->roleModel->orderBy('label')->paginate(10);

        return view('admin.roles.index', compact('roles'));
    }

    public function permissions($id){
        $role = $this->roleModel->find($id);

        // recupera permissions

        $permissions = $role->permissions;
        return view('admin.roles.permissions', compact('role','permissions'));
    }

    public function create(){
        $permissions = $this->permissionModel->orderBy('label')->get();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store()
    {
//        $validator = Validator::make($this->request->all(), IndicatorType::$rules, IndicatorType::$messages);
//
//        if ($validator->fails())
//        {
//            return redirect('/admin/indicatorTypes/create')
//                ->withErrors($validator)
//                ->withInput($this->request->all());
//        }

        $newRole = $this->roleModel->create($this->request->all());

        $newPermissions = $this->request->permissions;

        if ($newPermissions)
        {
            foreach ($newPermissions as $newPermission)
            {
                $newPermissionRole = new PermissionRole();
                
                $newPermissionRole->permission_id = $newPermission;
                $newPermissionRole->role_id = $newRole->id;
                $newPermissionRole->save();
            }
        }

        session()->flash('success', 'O Papel '. $newRole->label .' foi cadastrado com sucesso');
        return redirect('/admin/roles/create');
    }

    public function edit($id){
        $role = $this->roleModel->find($id);
        return view('admin.roles.edit', compact('role'));

    }



    public function delete($id){

        $permission = $this->permissionModel->find($id);
        $permissionRole = $permission->role;

        if ($permissionRole){
            session()->flash('erro', 'A permissão ' . $permissionRole->label . '. Exclusão não permitida.');

            return redirect('/admin/roles');
        }

        $permission->destroy();

        session()->flash('success', 'A permissão ' . $permissionRole->label . ' foi excluida com sucesso.');

        return redirect('/admin/roles');

    }
}
