<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Synonymous;
use App\Disorder;

class SynonymousController extends Controller
{
    private $synonymousModel;
    private $disorderModel;

    public function __construct(Synonymous $synonymousModel, Disorder $disorderModel, Request $request)
    {
        $this->synonymousModel = $synonymousModel;
        $this->disorderModel = $disorderModel;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $synonyms = $this->synonymousModel
            ->orderBy('name')
            ->paginate(10);

        return view('admin.synonyms.index', compact('synonyms'));
    }

    public function search()
    {
        $synonyms = $this->synonymousModel
            ->where('name', 'like', $this->request->searchedSynonymous.'%')
            ->orderBy('name')
            ->Paginate(10);

        Input::flash();

        return view('admin.synonyms.index', compact('synonyms'))->with($this->request->all());
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

        return view('admin.synonyms.create', compact('disorders'));
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
        $validator = Validator::make($request, Synonymous::$rules, Synonymous::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/synonyms/create')
                ->withErrors($validator)
                ->withInput($request);
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'O sinônimo não pode conter os símbolos / e \\');

            return redirect('admin/synonyms/create')->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        $newSynonymous = $this->synonymousModel->create($request);

        session()->flash('success', 'O sinônimo ' . $newSynonymous->name . ' foi cadastrado com sucesso');

        return redirect('/admin/synonyms/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $synonymous = $this->synonymousModel->find($id);
        
        $synonymousDisorder = $this->disorderModel->find($synonymous->disorder_id);

        return view('admin.synonyms.show', compact('synonymous', 'synonymousDisorder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $synonymous = $this->synonymousModel->find($id);

        return view('admin.synonyms.edit', compact('synonymous'));
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
        $rules = Synonymous::$rules;
        array_set($rules, 'name', 'required|min:2|max:150|unique:synonyms,name,' . $id);
        $request = $this->request->all();
        $validator = Validator::make($request, $rules, Synonymous::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/synonyms/edit/' . $id)
                ->withErrors($validator)
                ->withInput($request);
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'O sinônimo não pode conter os símbolos / e \\');

            return redirect('admin/synonyms/edit/' . $id)->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        $updatedSynonymous = $this->synonymousModel->find($id);
        $updatedSynonymous->update($request);

        session()->flash('success', 'O sinônimo ' . $updatedSynonymous->name . ' foi editado com sucesso');

        return redirect('/admin/synonyms');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deletedSynonymous = $this->synonymousModel->find($id);
        $deletedSynonymous->delete();
        
        session()->flash('success', 'O sinônimo ' . $deletedSynonymous->name . ' foi excluído com sucesso');

        return redirect(\Illuminate\Support\Facades\URL::previous());
    }
}
