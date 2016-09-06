<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

use App\IndicatorSource;

class IndicatorSourceController extends Controller
{
    private $indicatorSourceModel;

    public function __construct(IndicatorSource $indicatorSourceModel, Request $request)
    {
        $this->indicatorSourceModel = $indicatorSourceModel;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indicatorSources = $this->indicatorSourceModel
            ->orderBy('name')
            ->paginate(10);

        return view('admin.indicatorSources.index', compact('indicatorSources'));
    }

    public function search()
    {
        $indicatorSources = $this->indicatorSourceModel
            ->where('name', 'like', '%'.$this->request->searchedIndicatorSource.'%')
            ->orWhere('abbreviation', 'like', $this->request->searchedIndicatorSource.'%')
            ->paginate(10);

        Input::flash();

        return view('admin.indicatorSources.index', compact('indicatorSources'))->with($this->request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.indicatorSources.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make($this->request->all(), IndicatorSource::$rules, IndicatorSource::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/indicatorSources/create')
                ->withErrors($validator)
                ->withInput($this->request->all());
        }

        $newIndicatorSource = $this->indicatorSourceModel->create($this->request->all());

        session()->flash('success', 'A fonte de indicador '. $newIndicatorSource->name .' foi cadastrada com sucesso');

        return redirect('/admin/indicatorSources/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $indicatorSource = $this->indicatorSourceModel->find($id);

        $indicators = $indicatorSource->indicators()->get();

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

        return view('admin.indicatorSources.show', compact('indicatorSource', 'indicators'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $indicatorSource = $this->indicatorSourceModel->find($id);

        return view('admin.indicatorSources.edit', compact('indicatorSource'));
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
        $rules = IndicatorSource::$rules;
        array_set($rules, 'name', 'required|min:5|max:45|unique:indicator_sources,name,' . $id);
        array_set($rules, 'abbreviation', 'required|min:2|max:20|unique:indicator_sources,abbreviation,' . $id);
        $validator = Validator::make($this->request->all(), $rules, IndicatorSource::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/indicatorSources/edit/' . $id)
                ->withErrors($validator)
                ->withInput($this->request->all());
        }

        $updatedIndicatorSource = $this->indicatorSourceModel->find($id);
        $updatedIndicatorSource->update($this->request->all());

        session()->flash('success', 'A fonte de indicador ' . $updatedIndicatorSource->name . ' foi editada com sucesso');

        return redirect('/admin/indicatorSources');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deletedIndicatorSource = $this->indicatorSourceModel->find($id);
        $associatedIndicators = $deletedIndicatorSource->indicators;

        if (count($associatedIndicators))
        {
            if (count($associatedIndicators) == 1)
            {
                session()->flash('erro', 'Essa fonte de indicador está associada a ' . count($associatedIndicators) . ' indicador. Exclusão não permitida');
            }
            else
            {
                session()->flash('erro', 'Essa fonte de indicador está associada a ' . count($associatedIndicators) . ' indicadores. Exclusão não permitida');
            }

            return redirect('/admin/indicatorSources');
        }

        $deletedIndicatorSource->delete();

        session()->flash('success', 'A fonte de indicador ' . $deletedIndicatorSource->name . ' foi excluída com sucesso.');

        return redirect(\Illuminate\Support\Facades\URL::previous());
    }
}
