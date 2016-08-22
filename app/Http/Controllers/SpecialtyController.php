<?php

namespace rarasweb\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use rarasweb\Specialty;

class SpecialtyController extends Controller
{
    private $specialtyModel;

    public function __construct(Specialty $specialtyModel, Request $request)
    {
        $this->specialtyModel = $specialtyModel;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialties = $this->specialtyModel
            ->orderBy('name')
            ->paginate(10);

        return view('admin.specialties.index', compact('specialties'));
    }

    public function search()
    {
        $searchedExpression = $this->request->searchedSpecialty;

        if ($this->request->searchType == 'specialtyName')
        {
            $specialties = $this->specialtyModel
                ->where('name' , 'like' , '%'.$searchedExpression.'%')
                ->orderBy('name')
                ->paginate(10);
        }
        elseif ($this->request->searchType == 'specialtyCBO')
        {
            $specialties = $this->specialtyModel
                ->where('cbo' , 'like' , '%'.$searchedExpression.'%')
                ->orderBy('cbo')
                ->paginate(10);
        }

        Input::flash();

        return view('admin.specialties.index', compact('specialties'))->with($this->request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.specialties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make($this->request->all(), Specialty::$rules, Specialty::$messages);

        if ($validator->fails()) {
            return redirect('/admin/specialties/create')
                ->withErrors($validator)
                ->withInput($this->request->all());
        }

        $newSpecialty = $this->specialtyModel->create($this->request->all());

        session()->flash('success', 'A especialidade ' . $newSpecialty->name . ' foi cadastrada com sucesso');

        return redirect('/admin/specialties/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $specialty = $this->specialtyModel->find($id);

        $specialtyDisorders = $specialty->disorders()
            ->orderBy('name')
            ->paginate(10);

        return view('admin.specialties.show', compact('specialty', 'specialtyDisorders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $specialty = $this->specialtyModel->find($id);

        return view('admin.specialties.edit', compact('specialty'));
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
        $rules = Specialty::$rules;
        array_set($rules, 'name', 'required|min:5|max:50|unique:specialties,name,'. $id);
        array_set($rules, 'cbo', 'required|size:7|unique:specialties,cbo,'. $id);

        $validator = Validator::make($this->request->all(), $rules, Specialty::$messages);

        if ($validator->fails()) {
            return redirect('/admin/specialties/edit/' . $id)
                ->withErrors($validator)
                ->withInput($this->request->all());
        }

        $updatedSpecialty = $this->specialtyModel->find($id);
        $updatedSpecialty->update($this->request->all());

        session()->flash('success', 'A especialidade ' . $updatedSpecialty->name . ' foi editada com sucesso');

        return redirect('/admin/specialties');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deletedSpecialty = $this->specialtyModel->find($id);
        $associatedDisorders = $deletedSpecialty->disorders;

        if (count($associatedDisorders))
        {
            if (count($associatedDisorders) == 1)
            {
                session()->flash('erro', 'Essa especialidade está associada a ' . count($associatedDisorders) . ' desordem. Exclusão não permitida');
            }
            else
            {
                session()->flash('erro', 'Essa especialidade está associado a ' . count($associatedDisorders) . ' desordens. Exclusão não permitida');
            }

            return redirect('/admin/specialties');
        }

        $this->specialtyModel->find($id)->delete();

        session()->flash('success', 'A especialidade ' . $deletedSpecialty->name . ' foi excluída com sucesso.');

        return redirect('/admin/specialties');
    }
}
