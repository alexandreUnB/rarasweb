<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Professional;
use App\Specialty;
use App\ProfessionalSpecialty;

class ProfessionalController extends Controller
{
    private $professionalModel;
    private $specialtyModel;
    private $professionalSpecialtyModel;
    
    public function __construct(Professional $professionalModel, Specialty $specialtyModel,
                                ProfessionalSpecialty $professionalSpecialty, Request $request)
    {
        $this->professionalModel = $professionalModel;
        $this->specialtyModel = $specialtyModel;
        $this->professionalSpecialtyModel = $professionalSpecialty;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professionals = $this->professionalModel
            ->orderBy('name')
            ->paginate(10);
        
        return view('admin.professionals.index', compact('professionals'));
    }

    public function search()
    {
        $searchedExpression = $this->request->searchedProfessional;

        if ($this->request->searchType == 'professionalName')
        {
            $professionals = $this->professionalModel
                ->where(DB::raw("CONCAT(name, '', surname)") , 'like' , $searchedExpression.'%')
                ->orderBy('name')
                ->orderBy('surname')
                ->paginate(10);
        }
        elseif ($this->request->searchType == 'professionalCity')
        {
            $professionals = $this->professionalModel
                ->where('city' , 'like' , $searchedExpression.'%')
                ->orderBy('city')
                ->orderBy('name')
                ->orderBy('surname')
                ->paginate(10);
        }
        elseif ($this->request->searchType == 'professionalSpecialty')
        {
            $specialties = $this->specialtyModel
                ->where('name' , 'like' , '%'.$searchedExpression.'%')
                ->get();

            $professionals = collect();

            foreach ($specialties as $specialty)
            {
                $professionals = $professionals->merge($specialty->professionals);
            }

            $professionals = $professionals->unique()->sortBy('name' . 'surname');

            $page = Input::get('page', 1); // Get the ?page=1 from the url
            $perPage = 10; // Number of items per page
            $offset = ($page * $perPage) - $perPage;

            $professionals = new LengthAwarePaginator(
                $professionals->slice($offset, $perPage, true), // Only grab the items we need
                count($professionals), // Total items
                $perPage, // Items per page
                $page, // Current page
                ['path' => $this->request->url(), 'query' => $this->request->query()] // We need this so we can keep all old query parameters from the url
            );
        }

        Input::flash();

        return view('admin.professionals.index', compact('professionals'))->with($this->request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialties = $this->specialtyModel
            ->orderBy('name')
            ->get();

        return view('admin.professionals.create', compact('specialties'));
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
        $validator = Validator::make($request, Professional::$rules, Professional::$messages );

        if ($validator->fails())
        {
            return redirect('/admin/professionals/create')
                ->withErrors($validator)
                ->withInput($request);
        }

        $newProfessional = $this->professionalModel->create($request);
        $newSpecialties = $this->request->professionalSpecialties;

        if ($newSpecialties)
        {
            foreach ($newSpecialties as $newSpecialty)
            {
                $newProfessionalSpecialty = new ProfessionalSpecialty();
                $newProfessionalSpecialty->professional_id = $newProfessional->id;
                $newProfessionalSpecialty->specialty_id = $newSpecialty;
                $newProfessionalSpecialty->save();
            }
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'O nome do profissional não pode conter os símbolos / e \\');

            return redirect('admin/professionals/create')->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        if (str_contains($request['surname'], '/') || str_contains($request['surname'], '\\'))
        {
            session()->flash('erro', 'O sobrenome do profissional não pode conter os símbolos / e \\');

            return redirect('admin/professionals/create')->withInput($request);
        }

        $request['surname'] = trim($request['surname']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['surname'] = str_replace('°', 'º', $request['surname']); // Troca o símbolo de grau pelo indicador cardinal

        if (str_contains($request['city'], '/') || str_contains($request['city'], '\\'))
        {
            session()->flash('erro', 'A cidade do profissional não pode conter os símbolos / e \\');

            return redirect('admin/professionals/create')->withInput($request);
        }

        $request['city'] = trim($request['city']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['city'] = str_replace('°', 'º', $request['city']); // Troca o símbolo de grau pelo indicador cardinal

        session()->flash('success', 'O profissional ' . $newProfessional->name .
            '' . $newProfessional->surname . ' foi cadastrado com sucesso');

        return redirect('/admin/professionals/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $professional = $this->professionalModel->find($id);

        $specialties = $professional->specialties()->get();
        $countSpecialties = count($specialties) - 1;

        return view('admin.professionals.show', compact('professional', 'specialties', 'countSpecialties'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $professional = $this->professionalModel->find($id);

        $specialties = $this->specialtyModel
            ->orderBy('name')
            ->get();

        $professionalSpecialties = $professional->specialties;

        return view('admin.professionals.edit', compact('professional', 'specialties', 'professionalSpecialties'));
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
        $request = $this->request->all();
        $rules = Professional::$rules;
        array_set($rules, 'council_number', 'numeric|digits_between:2,5|unique:professionals,council_number,' . $id);
        $validator = Validator::make($request, $rules, Professional::$messages );

        if ($validator->fails())
        {
            return redirect('/admin/professionals/edit/' . $id)
                ->withErrors($validator)
                ->withInput($request);
        }

        $updatedProfessional = $this->professionalModel->find($id);
        $updatedProfessional->update($request);
        
        $this->professionalSpecialtyModel
            ->where('professional_id', $updatedProfessional->id)
            ->delete();

        $newSpecialtiesID = $this->request->professionalSpecialties;

        if ($newSpecialtiesID)
        {
            foreach ($newSpecialtiesID as $newSpecialtyID)
            {
                $newProfessionalSpecialty = new ProfessionalSpecialty();
                $newProfessionalSpecialty->professional_id = $updatedProfessional->id;
                $newProfessionalSpecialty->specialty_id = $newSpecialtyID;
                $newProfessionalSpecialty->save();
            }
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'O nome do profissional não pode conter os símbolos / e \\');

            return redirect('admin/professionals/edit/' . $id)->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        if (str_contains($request['surname'], '/') || str_contains($request['surname'], '\\'))
        {
            session()->flash('erro', 'O sobrenome do profissional não pode conter os símbolos / e \\');

            return redirect('admin/professionals/edit/' . $id)->withInput($request);
        }

        $request['surname'] = trim($request['surname']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['surname'] = str_replace('°', 'º', $request['surname']); // Troca o símbolo de grau pelo indicador cardinal

        if (str_contains($request['city'], '/') || str_contains($request['city'], '\\'))
        {
            session()->flash('erro', 'A cidade do profissional não pode conter os símbolos / e \\');

            return redirect('admin/professionals/edit/' . $id)->withInput($request);
        }

        $request['city'] = trim($request['city']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['city'] = str_replace('°', 'º', $request['city']); // Troca o símbolo de grau pelo indicador cardinal

        session()->flash('success', 'O profissional ' . $updatedProfessional->name .
            '' . $updatedProfessional->surname . ' foi editado com sucesso');

        return redirect('/admin/professionals');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deletedProfessional = $this->professionalModel->find($id);
        $deletedProfessional->delete();

        session()->flash('success', 'O profissional ' . $deletedProfessional->name . 
            '' . $deletedProfessional->surname . ' foi deletado com sucesso');

        return redirect(\Illuminate\Support\Facades\URL::previous());
    }
}
