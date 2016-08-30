<?php

namespace rarasweb\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

use rarasweb\IndicatorType;

class IndicatorTypeController extends Controller
{
    private $indicatorTypeModel;

    public function __construct(IndicatorType $indicatorTypeModel, Request $request)
    {
        $this->indicatorTypeModel = $indicatorTypeModel;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indicatorTypes = $this->indicatorTypeModel
            ->orderBy('name')
            ->paginate(10);

        return view('admin.indicatorTypes.index', compact('indicatorTypes'));
    }

    public function search()
    {
        $indicatorTypes = $this->indicatorTypeModel
            ->where('name', 'like', '%'.$this->request->searchedIndicatorType.'%')
            ->paginate(10);

        Input::flash();

        return view('admin.indicatorTypes.index', compact('indicatorTypes'))->with($this->request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.indicatorTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make($this->request->all(), IndicatorType::$rules, IndicatorType::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/indicatorTypes/create')
                ->withErrors($validator)
                ->withInput($this->request->all());
        }

        $newIndicatorType = $this->indicatorTypeModel->create($this->request->all());

        session()->flash('success', 'O tipo de indicador '. $newIndicatorType->name .' foi cadastrado com sucesso');
        
        return redirect('/admin/indicatorTypes/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $indicatorType = $this->indicatorTypeModel->find($id);

        $indicators = $indicatorType->indicators()->get();

        foreach ($indicators as $indicator)
        {
            $indicator['nameDisorder'] = $indicator->disorder->name;
            $indicator['nameIndicatorType'] = $indicator->indicatorType->name;
            $indicator['nameIndicatorSource'] = $indicator->indicatorSource->name;
        }

        $indicators = $indicators->sortBy('nameDisorder' . 'nameIndicatorType' . 'nameIndicatorSource' . 'year');

        $page = Input::get('page', 1); // Get the ?page=1 from the url
        $perPage = 10; // Number of items per page
        $offset = ($page * $perPage) - $perPage;

        $indicators = new LengthAwarePaginator(
            $indicators->slice($offset, $perPage, true), // Only grab the items we need
            count($indicators), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => $this->request->url(), 'query' => $this->request->query()] // We need this so we can keep all old query parameters from the url
        );

        return view('admin.indicatorTypes.show', compact('indicatorType', 'indicators'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $indicatorType = $this->indicatorTypeModel->find($id);

        return view('admin.indicatorTypes.edit', compact('indicatorType'));
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
        $rules = IndicatorType::$rules;
        array_set($rules, 'name', 'required|min:5|max:100|unique:indicator_types,name,' . $id);
        $validator = Validator::make($this->request->all(), $rules, IndicatorType::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/indicatorTypes/edit/' . $id)
                ->withErrors($validator)
                ->withInput($this->request->all());
        }

        $updatedIndicatorType = $this->indicatorTypeModel->find($id);
        $updatedIndicatorType->update($this->request->all());

        session()->flash('success', 'O tipo de indicador ' . $updatedIndicatorType->name . ' foi editado com sucesso');
        
        return redirect('/admin/indicatorTypes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deletedIndicatorType = $this->indicatorTypeModel->find($id);
        $associatedIndicators = $deletedIndicatorType->indicators;

        if (count($associatedIndicators))
        {
            if (count($associatedIndicators) == 1)
            {
                session()->flash('erro', 'Esse tipo de indicador está associado a ' .
                    count($associatedIndicators) . ' indicador. Exclusão não permitida');
            }
            else
            {
                session()->flash('erro', 'Esse tipo de indicador está associado a ' .
                    count($associatedIndicators) . ' indicadores. Exclusão não permitida');
            }

            return redirect('/admin/indicatorTypes');
        }

        $deletedIndicatorType->delete();

        session()->flash('success', 'O tipo de indicador ' . $deletedIndicatorType->name . ' foi excluído com sucesso.');

        return redirect(\Illuminate\Support\Facades\URL::previous());
    }
}
