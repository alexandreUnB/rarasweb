<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Specialty;

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
        $request = $this->request->all();
        $validator = Validator::make($request, Specialty::$rules, Specialty::$messages);

        if ($validator->fails()) {
            return redirect('/admin/specialties/create')
                ->withErrors($validator)
                ->withInput($request);
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'A especialidade não pode conter os símbolos / e \\');

            return redirect('admin/specialties/create')->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        $newSpecialty = $this->specialtyModel->create($request);

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

        return view('admin.specialties.show', compact('specialty'));
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

        $request = $this->request->all();
        $validator = Validator::make($request, $rules, Specialty::$messages);

        if ($validator->fails()) {
            return redirect('/admin/specialties/edit/' . $id)
                ->withErrors($validator)
                ->withInput($request);
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'A especialidade não pode conter os símbolos / e \\');

            return redirect('admin/specialties/edit/' . $id)->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        $updatedSpecialty = $this->specialtyModel->find($id);
        $updatedSpecialty->update($request);

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
        $associatedProfessionals = $deletedSpecialty->professionals;
        $associatedCenters = $deletedSpecialty->treatmentCenters;

        if (count($associatedProfessionals) || count($associatedCenters))
        {
            if (count($associatedProfessionals) == 1)
            {
                session()->flash('erro', 'Essa especialidade está associada a ' .
                    count($associatedProfessionals) . ' profissional. Exclusão não permitida');
            }
            else if (count($associatedProfessionals) > 1)
            {
                session()->flash('erro', 'Essa especialidade está associado a ' .
                    count($associatedProfessionals) . ' profissionais. Exclusão não permitida');
            }

            if (count($associatedCenters) == 1)
            {
                session()->flash('erro', 'Essa especialidade está associada a ' .
                    count($associatedCenters) . ' centro de tratamento. Exclusão não permitida');
            }
            else if (count($associatedCenters) > 1)
            {
                session()->flash('erro', 'Essa especialidade está associado a ' .
                    count($associatedCenters) . ' centros de tratamento. Exclusão não permitida');
            }

            return redirect('/admin/specialties');
        }

        $this->specialtyModel->find($id)->delete();

        session()->flash('success', 'A especialidade ' . $deletedSpecialty->name . ' foi excluída com sucesso.');

        return redirect(\Illuminate\Support\Facades\URL::previous());
    }
}
