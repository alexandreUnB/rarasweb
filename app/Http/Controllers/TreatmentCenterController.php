<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

use App\TreatmentCenter;
use App\Specialty;
use App\SpecialtyTreatmentCenter;

class TreatmentCenterController extends Controller
{
    private $treatmentCenterModel;
    private $specialtyModel;
    private $specialtyTreatmentCenterModel;

    public function __construct(TreatmentCenter $treatmentCenterModel, Specialty $specialtyModel, 
                                SpecialtyTreatmentCenter $specialtyTreatmentCenterModel, Request $request)
    {
        $this->treatmentCenterModel = $treatmentCenterModel;
        $this->specialtyModel = $specialtyModel;
        $this->specialtyTreatmentCenterModel = $specialtyTreatmentCenterModel;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $treatmentCenters = $this->treatmentCenterModel
            ->orderBy('name')
            ->paginate(10);

        return view('admin.treatmentCenters.index', compact('treatmentCenters'));
    }

    public function search()
    {
        $searchedExpression = $this->request->searchedCenter;

        if ($this->request->searchType == 'centerName')
        {
            $treatmentCenters = $this->treatmentCenterModel
                ->where('name' , 'like' , $searchedExpression.'%')
                ->orderBy('name')
                ->paginate(10);
        }
        elseif ($this->request->searchType == 'centerCity')
        {
            $treatmentCenters = $this->treatmentCenterModel
                ->where('city' , 'like' , $searchedExpression.'%')
                ->orderBy('city')
                ->orderBy('name')
                ->paginate(10);
        }
        elseif ($this->request->searchType == 'centerSpecialty')
        {
            $specialties = $this->specialtyModel
                ->where('name' , 'like' , '%'.$searchedExpression.'%')
                ->get();

            $treatmentCenters = collect();

            foreach ($specialties as $specialty)
            {
                $treatmentCenters = $treatmentCenters->merge($specialty->treatmentCenters);
            }

            $treatmentCenters = $treatmentCenters->unique()->sortBy('name');

            $page = Input::get('page', 1); // Get the ?page=1 from the url
            $perPage = 10; // Number of items per page
            $offset = ($page * $perPage) - $perPage;

            $treatmentCenters = new LengthAwarePaginator(
                $treatmentCenters->slice($offset, $perPage, true), // Only grab the items we need
                count($treatmentCenters), // Total items
                $perPage, // Items per page
                $page, // Current page
                ['path' => $this->request->url(), 'query' => $this->request->query()] // We need this so we can keep all old query parameters from the url
            );
        }

        Input::flash();

        return view('admin.treatmentCenters.index', compact('treatmentCenters'))->with($this->request->all());
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

        return view('admin.treatmentCenters.create', compact('specialties'));
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
        $validator = Validator::make($request, TreatmentCenter::$rules, TreatmentCenter::$messages );

        if ($validator->fails())
        {
            return redirect('/admin/treatmentCenters/create')
                ->withErrors($validator)
                ->withInput($request);
        }

        $newTreatmentCenter = $this->treatmentCenterModel->create($request);
        $newSpecialties = $this->request->centerSpecialties;

        if ($newSpecialties)
        {
            foreach ($newSpecialties as $newSpecialty)
            {
                $newSpecialtyTreatmentCenter = new SpecialtyTreatmentCenter();
                $newSpecialtyTreatmentCenter->specialty_id = $newSpecialty;
                $newSpecialtyTreatmentCenter->treatmentCenter_id = $newTreatmentCenter->id;
                $newSpecialtyTreatmentCenter->save();
            }
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'O nome do centro não pode conter os símbolos / e \\');

            return redirect('admin/treatmentCenters/create')->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        if (str_contains($request['city'], '/') || str_contains($request['city'], '\\'))
        {
            session()->flash('erro', 'A cidade do centro não pode conter os símbolos / e \\');

            return redirect('admin/treatmentCenters/create')->withInput($request);
        }

        $request['city'] = trim($request['city']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['city'] = str_replace('°', 'º', $request['city']); // Troca o símbolo de grau pelo indicador cardinal

        session()->flash('success', 'O centro de tratamento ' . $newTreatmentCenter->name . ' foi cadastrado com sucesso');

        return redirect('/admin/treatmentCenters/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $treatmentCenter = $this->treatmentCenterModel->find($id);

        $specialties = $treatmentCenter->specialties;
        $countSpecialties = count($specialties) - 1;

        return view('admin.treatmentCenters.show', compact('treatmentCenter', 'specialties', 'countSpecialties'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $treatmentCenter = $this->treatmentCenterModel->find($id);

        $specialties = $this->specialtyModel
            ->orderBy('name')
            ->get();

        $centerSpecialties = $treatmentCenter->specialties;

        return view('admin.treatmentCenters.edit', compact('treatmentCenter', 'specialties', 'centerSpecialties'));
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
        $rules = TreatmentCenter::$rules;
        array_set($rules, 'name', 'required|min:8|max:200|unique:treatment_centers,name,' . $id);
        $validator = Validator::make($request, $rules, TreatmentCenter::$messages );

        if ($validator->fails())
        {
            return redirect('/admin/treatmentCenters/edit/' . $id)
                ->withErrors($validator)
                ->withInput($request);
        }

        $updatedTreatmentCenter = $this->treatmentCenterModel->find($id);
        $updatedTreatmentCenter->update($request);

        $this->specialtyTreatmentCenterModel
            ->where('treatmentCenter_id', $updatedTreatmentCenter->id)
            ->delete();
        
        $newSpecialtiesID = $this->request->centerSpecialties;

        if ($newSpecialtiesID)
        {
            foreach ($newSpecialtiesID as $newSpecialtyID)
            {
                $newSpecialtyTreatmentCenter = new SpecialtyTreatmentCenter();
                $newSpecialtyTreatmentCenter->specialty_id = $newSpecialtyID;
                $newSpecialtyTreatmentCenter->treatmentCenter_id = $updatedTreatmentCenter->id;
                $newSpecialtyTreatmentCenter->save();
            }
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'O nome do centro não pode conter os símbolos / e \\');

            return redirect('admin/treatmentCenters/edit/' . $id)->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        if (str_contains($request['city'], '/') || str_contains($request['city'], '\\'))
        {
            session()->flash('erro', 'A cidade do centro não pode conter os símbolos / e \\');

            return redirect('admin/treatmentCenters/edit/' . $id)->withInput($request);
        }

        $request['city'] = trim($request['city']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['city'] = str_replace('°', 'º', $request['city']); // Troca o símbolo de grau pelo indicador cardinal

        session()->flash('success', 'O centro de tratamento ' . $updatedTreatmentCenter->name . ' foi editado com sucesso');

        return redirect('/admin/treatmentCenters');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deletedTreatmentCenter = $this->treatmentCenterModel->find($id);
        $deletedTreatmentCenter->delete();

        session()->flash('success', 'O centro de tratamento ' . $deletedTreatmentCenter->name . ' foi deletado com sucesso');

        return redirect(\Illuminate\Support\Facades\URL::previous());
    }
}
