<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

use App\Indicator;
use App\Disorder;
use App\IndicatorType;
use App\IndicatorSource;

class IndicatorController extends Controller
{
    private $indicatorModel;
    private $indicatorTypeModel;
    private $indicatorSourceModel;
    private $disorderModel;

    public function __construct(Indicator $indicatorModel, IndicatorType $indicatorTypeModel,
                                IndicatorSource $indicatorSourceModel,Disorder $disorderModel, Request $request)
    {
        $this->indicatorModel = $indicatorModel;
        $this->disorderModel = $disorderModel;
        $this->indicatorTypeModel = $indicatorTypeModel;
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
        $indicators = $this->indicatorModel
            ->get();

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

        return view('admin.indicators.index', compact('indicators'));
    }

    public function search()
    {
        $searchedExpression = $this->request->searchedIndicator;

        if ($this->request->searchType == 'indicatorDisorder')
        {
            $disorders = $this->disorderModel
                ->where('name' , 'like' , '%'.$searchedExpression.'%')
                ->get();

            $indicators = collect();

            foreach ($disorders as $disorder)
            {
                $indicators = $indicators->merge($disorder->indicators);
            }

            foreach ($indicators as $indicator)
            {
                $indicator['nameDisorder'] = $indicator->disorder->name;
                $indicator['nameIndicatorType'] = $indicator->indicatorType->name;
                $indicator['nameIndicatorSource'] = $indicator->indicatorSource->name;
            }

            $indicators = $indicators->sortBy(function($indicators) {
                return sprintf('%s %s %s %s', $indicators->nameDisorder, $indicators->nameIndicatorType,
                    $indicators->nameIndicatorSource, $indicators->year);
            });

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
        }
//        elseif ($this->request->searchType == 'indicatorDisorderPortuguese')
//        {
//            $disorders = $this->disorderModel
//                ->where('name_portuguese' , 'like' , '%'.$searchedExpression.'%')
//                ->get();
//
//            $indicators = collect();
//
//            foreach ($disorders as $disorder)
//            {
//                $indicators = $indicators->merge($disorder->indicators);
//            }
//
//            foreach ($indicators as $indicator)
//            {
//                $indicator['nameDisorder'] = $indicator->disorder->name_portuguese;
//                $indicator['nameIndicatorType'] = $indicator->indicatorType->name;
//                $indicator['nameIndicatorSource'] = $indicator->indicatorSource->name;
//            }
//
//            $indicators = $indicators->sortBy(function($indicators) {
//                return sprintf('%s %s %s %s', $indicators->nameDisorder, $indicators->nameIndicatorType,
//                    $indicators->nameIndicatorSource, $indicators->year);
//            });
//
//            $page = Input::get('page', 1); // Get the ?page=1 from the url
//            $perPage = 10; // Number of items per page
//            $offset = ($page * $perPage) - $perPage;
//
//            $indicators = new LengthAwarePaginator(
//                $indicators->slice($offset, $perPage, true), // Only grab the items we need
//                count($indicators), // Total items
//                $perPage, // Items per page
//                $page, // Current page
//                ['path' => $this->request->url(), 'query' => $this->request->query()] // We need this so we can keep all old query parameters from the url
//            );
//        }
        elseif ($this->request->searchType == 'indicatorType')
        {
            $indicatorTypes = $this->indicatorTypeModel
                ->where('name' , 'like' , '%'.$searchedExpression.'%')
                ->get();

            $indicators = collect();

            foreach ($indicatorTypes as $indicatorType)
            {
                $indicators = $indicators->merge($indicatorType->indicators);
            }

            foreach ($indicators as $indicator)
            {
                $indicator['nameIndicatorType'] = $indicator->indicatorType->name;
                $indicator['nameDisorder'] = $indicator->disorder->name;
                $indicator['nameIndicatorSource'] = $indicator->indicatorSource->name;
            }

            $indicators = $indicators->sortBy(function($indicators) {
                return sprintf('%s %s %s %s', $indicators->nameIndicatorType, $indicators->nameDisorder,
                    $indicators->nameIndicatorSource, $indicators->year);
            });

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
        }
        elseif ($this->request->searchType == 'indicatorSource')
        {
            $indicatorSources = $this->indicatorSourceModel
                ->where('name' , 'like' , '%'.$searchedExpression.'%')
                ->orWhere('abbreviation', 'like', $searchedExpression.'%')
                ->get();

            $indicators = collect();

            foreach ($indicatorSources as $indicatorSource)
            {
                $indicators = $indicators->merge($indicatorSource->indicators);
            }

            foreach ($indicators as $indicator)
            {
                $indicator['nameIndicatorSource'] = $indicator->indicatorSource->name;
                $indicator['nameDisorder'] = $indicator->disorder->name;
                $indicator['nameIndicatorType'] = $indicator->indicatorType->name;
            }

            $indicators = $indicators->sortBy(function($indicators) {
                return sprintf('%s %s %s %s', $indicators->nameIndicatorSource, $indicators->nameDisorder,
                    $indicators->nameIndicatorType, $indicators->year);
            });

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
        }

        Input::flash();

        return view('admin.indicators.index', compact('indicators'))->with($this->request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $disorders = $this->disorderModel
            ->orderBy('name')
            ->get();

        $indicatorTypes = $this->indicatorTypeModel
            ->orderBy('name')
            ->get();

        $indicatorSources = $this->indicatorSourceModel
            ->orderBy('name')
            ->get();

        return view('admin.indicators.create', compact('disorders', 'indicatorTypes', 'indicatorSources'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make($this->request->all(), Indicator::$rules, Indicator::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/indicators/create')
                ->withErrors($validator)
                ->withInput($this->request->all());
        }

        $newIndicator = $this->request->all();
        
        $validationIndicator = $this->indicatorModel->where([
            ['year', $newIndicator['year']],
            ['disorder_id', $newIndicator['disorder_id']],
            ['indicatorType_id', $newIndicator['indicatorType_id']],
            ['indicatorSource_id', $newIndicator['indicatorSource_id']],
        ])->first();

        $disorder = $this->disorderModel->find($newIndicator['disorder_id']);
        $indicatorType = $this->indicatorTypeModel->find($newIndicator['indicatorType_id']);
        $indicatorSource = $this->indicatorSourceModel->find($newIndicator['indicatorSource_id']);

        if ($validationIndicator)
        {
            session()->flash('erro', 'Já existe um dado de ' . $indicatorType->name . ' no ano de ' . $newIndicator['year'] .
                ' fornecido pelo(a) ' . $indicatorSource->abbreviation . ' para a desordem' . $disorder->name);

            return redirect('/admin/indicators/create')
                ->withInput($this->request->all());
        }

        $this->indicatorModel->create($newIndicator);

        session()->flash('success', 'O dado de ' . $indicatorType->name . ' do ano de ' . $newIndicator['year'] . ' fornecido pelo(a) ' .
            $indicatorSource->abbreviation . ' para a desordem ' . $disorder->name . ' foi cadastrado com sucesso');

        return redirect('/admin/indicators/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $indicator = $this->indicatorModel->find($id);

        return view('admin.indicators.show', compact('indicator'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $indicator = $this->indicatorModel->find($id);

        $disorders = $this->disorderModel
            ->orderBy('name')
            ->get();

        $indicatorTypes = $this->indicatorTypeModel
            ->orderBy('name')
            ->get();

        $indicatorSources = $this->indicatorSourceModel
            ->orderBy('name')
            ->get();

        return view('admin.indicators.edit', compact('indicator', 'disorders', 'indicatorTypes', 'indicatorSources'));
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
        $validator = Validator::make($this->request->all(), Indicator::$rules, Indicator::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/indicators/edit/' . $id)
                ->withErrors($validator)
                ->withInput($this->request->all());
        }

        $updatedIndicator = $this->request->all();

        $validationIndicator = $this->indicatorModel->where([
            ['year', $updatedIndicator['year']],
            ['disorder_id', $updatedIndicator['disorder_id']],
            ['indicatorType_id', $updatedIndicator['indicatorType_id']],
            ['indicatorSource_id', $updatedIndicator['indicatorSource_id']],
        ])->first();

        $disorder = $this->disorderModel->find($updatedIndicator['disorder_id']);
        $indicatorType = $this->indicatorTypeModel->find($updatedIndicator['indicatorType_id']);
        $indicatorSource = $this->indicatorSourceModel->find($updatedIndicator['indicatorSource_id']);

        if ($validationIndicator && $validationIndicator->id != $id)
        {
            session()->flash('erro', 'Já existe um dado de ' . $indicatorType->name . ' no ano de ' . $updatedIndicator['year'] .
                ' fornecido pelo(a) ' . $indicatorSource->abbreviation . ' para a desordem' . $disorder->name);

            return redirect('/admin/indicators/edit/' . $id)
                ->withInput($this->request->all());
        }

        $this->indicatorModel->find($id)->update($updatedIndicator);

        session()->flash('success', 'O dado de ' . $indicatorType->name . ' do ano de ' . $updatedIndicator['year'] . ' fornecido pelo(a) ' .
            $indicatorSource->abbreviation . ' para a desordem ' . $disorder->name . ' foi cadastrado com sucesso');

        return redirect('/admin/indicators');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deletedIndicator = $this->indicatorModel->find($id);
        $deletedIndicator->delete();

        session()->flash('success', 'O dado de ' . $deletedIndicator->indicatorType->name . ' do ano de ' .
            $deletedIndicator->year . ' fornecido pelo(a) ' . $deletedIndicator->indicatorSource->abbreviation .
            ' para a desordem ' . $deletedIndicator->disorder->name . ' foi excluído com sucesso');

        return redirect(\Illuminate\Support\Facades\URL::previous());
    }
}
