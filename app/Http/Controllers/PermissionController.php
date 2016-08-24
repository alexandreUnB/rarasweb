<?php

namespace rarasweb\Http\Controllers;

use Illuminate\Http\Request;

use rarasweb\Http\Requests;
use rarasweb\Http\Controllers\Controller;
use rarasweb\Permission;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    private $permissionModel;
    /**
     * @var Request
     */
    private $request;

    public function __construct(Permission $permissionModel, Request $request)
    {
        $this->request = $request;
        $this->permissionModel = $permissionModel;

//        if ((Gate::denies('user')))
//            abort(403,'Not Allowed');
    }

    public function index(){
        $permissions = $this->permissionModel->orderBy('label')->paginate();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function roles($id){
        $permission = $this->permissionModel->find($id);

        // recuperar permissions

        $roles = $permission->roles;
        return view('admin.permissions.roles', compact('roles','permission'));
    }

    public function create(){
        return view('admin.permissions.create');
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

        $newPermission = $this->permissionModel->create($this->request->all());

        session()->flash('success', 'A Permissão '. $newPermission->label .' foi cadastrado com sucesso');
        return redirect('/admin/permissions/create');
    }

    public function edit($id){
        $permission = $this->permissionModel->find($id);
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update($id)
    {
//        $validator = Validator::make($this->request->all(), IndicatorType::$rules, IndicatorType::$messages);
//
//        if ($validator->fails())
//        {
//            return redirect('/admin/indicatorTypes/create')
//                ->withErrors($validator)
//                ->withInput($this->request->all());
//        }

        $newPermission = $this->permissionModel->find($id);
        $newPermission->update($this->request->all());

        session()->flash('success', 'A Permissão '. $newPermission->label .' foi alterada com sucesso');
        return redirect('/admin/permissions');
    }

    public function delete($id){

        $deletedPermission = $this->permissionModel->find($id);
        $hasRoles = $deletedPermission->roles;

        if(count($hasRoles) > 0){
            session()->flash('erro', 'A permissão ' . $deletedPermission->label .
                ' está associada a um ou mais papéis. Exclusão não permitida.');
            return redirect('/admin/permissions');
        }

        $deletedPermission->delete();

        session()->flash('success', 'A permissão ' . $deletedPermission->label . ' foi excluído com sucesso.');

        return redirect('/admin/permissions');
    }



}
