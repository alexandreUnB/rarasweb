<?php

namespace rarasweb\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use rarasweb\DisorderType;

class DisorderTypeController extends Controller
{
    private $disorderTypeModel;
    
    public function __construct(DisorderType $disorderTypeModel, Request $request)
    {
        $this->disorderTypeModel = $disorderTypeModel;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disorderTypes = $this->disorderTypeModel
            ->orderBy('name')
            ->paginate(10);

        return view('admin.disorderTypes.index', compact('disorderTypes'));
    }

    public function search()
    {
        $disorderTypes = $this->disorderTypeModel
            ->where('name' , 'like' , $this->request->searchedDisorderType.'%')
            ->orderBy('name')
            ->paginate(10);

        Input::flash();

        return view('admin.disorderTypes.index', compact('disorderTypes'))->with($this->request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.disorderTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make($this->request->all(), DisorderType::$rules, DisorderType::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/disordertypes/create')
                ->withErrors($validator)
                ->withInput($this->request->all());
        }

        $newDisorderType = $this->disorderTypeModel->create($this->request->all());

        session()->flash('success', 'O tipo de desordem ' . $newDisorderType->name . ' foi cadastrado com sucesso');
        
        return redirect('/admin/disordertypes/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $disorderType = $this->disorderTypeModel->find($id);
        
        $disorders = $disorderType->disorders()
            ->orderBy('name')
            ->paginate(10);

        return view('admin.disorderTypes.show', compact('disorderType', 'disorders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $disorderType = $this->disorderTypeModel->find($id);

        return view('admin.disorderTypes.edit', compact('disorderType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $rules = DisorderType::$rules;
        array_set($rules, 'name', 'required|min:5|max:100|unique:disorder_types,name,' . $id);
        $validator = Validator::make($this->request->all(), $rules, DisorderType::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/disordertypes/edit/' . $id)
                ->withErrors($validator)
                ->withInput($this->request->all());
        }

        $updatedDisorderType = $this->disorderTypeModel->find($id);
        $updatedDisorderType->update($this->request->all());

        session()->flash('success', 'O tipo de desordem ' . $updatedDisorderType->name . ' foi editado com sucesso');
        
        return redirect('/admin/disordertypes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deletedDisorderType = $this->disorderTypeModel->find($id);
        $associatedDisorders = $deletedDisorderType->disorders;

        if (count($associatedDisorders))
        {
            if (count($associatedDisorders) == 1)
            {
                session()->flash('erro', 'Esse tipo de desordem está associado a ' . count($associatedDisorders) . ' desordem. Exclusão não permitida');
            }
            else
            {
                session()->flash('erro', 'Esse tipo de desordem está associado a ' . count($associatedDisorders) . ' desordens. Exclusão não permitida');
            }

            return redirect('/admin/disordertypes');
        }

        $deletedDisorderType->delete();

        session()->flash('success', 'O tipo de desordem ' . $deletedDisorderType->name . ' foi excluído com sucesso');

        return redirect(\Illuminate\Support\Facades\URL::previous());
    }
}
