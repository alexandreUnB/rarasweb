<?php

namespace rarasweb\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use rarasweb\Reference;

class ReferenceController extends Controller
{
    private $referenceModel;

    public function __construct(Reference $referenceModel, Request $request)
    {
        $this->referenceModel = $referenceModel;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $references = $this->referenceModel
            ->orderBy('source')
            ->orderBy('reference')
            ->paginate(10);

        return view('admin.references.index', compact('references'));
    }
    
    public function search()
    {
        $searchedExpression = $this->request->searchedReference;

        if ($this->request->searchType == 'referenceReference')
        {
            $references = $this->referenceModel
                ->where('reference' , 'like' , $searchedExpression.'%')
                ->orderBy('reference')
                ->paginate(10);
        }
        elseif ($this->request->searchType == 'referenceSource')
        {
            $references = $this->referenceModel
                ->where('source' , 'like' , $searchedExpression.'%')
                ->orderBy('source')
                ->orderBy('reference')
                ->paginate(10);
        }
        elseif ($this->request->searchType == 'referenceMapRelation')
        {
            $references = $this->referenceModel
                ->where('map_relation' , 'like' , $searchedExpression.'%')
                ->orderBy('map_relation')
                ->orderBy('source')
                ->orderBy('reference')
                ->paginate(10);
        }

        Input::flash();

        return view('admin.references.index', compact('references'))->with($this->request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sources = $this->referenceModel
            ->distinct()
            ->orderBy('source')
            ->lists('source');

        return view('admin.references.create', compact('sources'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make($this->request->all(), Reference::$rules, Reference::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/references/create')
                ->withErrors($validator)
                ->withInput($this->request->all());
        }

        $newReference = $this->request->all();

        $validationReference = $this->referenceModel->where([
            ['source', $newReference['source']],
            ['reference', $newReference['reference']],
        ])->first();

        if($validationReference)
        {
            session()->flash('erro', 'A referência ' . $newReference['source'] .
                ' - ' . $newReference['reference'] . ' já está cadastrada');

            return redirect('/admin/references/create')
                ->withInput($this->request->all());
        }

        $this->referenceModel->create($newReference);

        session()->flash('success', 'A referência ' . $newReference['source'] .
            ' - ' . $newReference['reference'] . ' foi cadastrada com sucesso');

        return redirect('/admin/references/create');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reference = $this->referenceModel->find($id);
        
        $referenceDisorders = $reference->disorders()
            ->orderBy('name')
            ->paginate(10);

        return view('admin.references.show', compact('reference', 'referenceDisorders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reference = $this->referenceModel->find($id);

        $sources = $this->referenceModel
            ->distinct()
            ->orderBy('source')
            ->lists('source');

        return view('admin.references.edit', compact('reference', 'sources'));
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
        $validator = Validator::make($this->request->all(), Reference::$rules, Reference::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/references/create')
                ->withErrors($validator)
                ->withInput($this->request->all());
        }

        $updatedReference = $this->request->all();

        $validationReference = $this->referenceModel->where([
            ['source', $updatedReference['source']],
            ['reference', $updatedReference['reference']],
        ])->first();

        if($validationReference)
        {
            session()->flash('erro', 'A referência ' . $updatedReference['source'] .
                ' - ' . $updatedReference['reference'] . ' já está cadastrada');

            return redirect('/admin/references/create')
                ->withInput($this->request->all());
        }

        $this->referenceModel->find($id)->update($updatedReference);

        session()->flash('success', 'A referência ' . $updatedReference['source'] .
            ' - ' . $updatedReference['reference'] . ' foi editada com sucesso');

        return redirect('/admin/references');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deletedReference = $this->referenceModel->find($id);
        $associatedDisorders = $deletedReference->disorders;

        if (count($associatedDisorders))
        {
            if (count($associatedDisorders) == 1)
            {
                session()->flash('erro', 'Essa referência está associada a ' .
                    count($associatedDisorders) . ' desordem. Exclusão não permitida');
            }
            else
            {
                session()->flash('erro', 'Essa referência está associada a ' .
                    count($associatedDisorders) . ' desordens. Exclusão não permitida');
            }

            return redirect('/admin/references');
        }

        $deletedReference->delete();

        session()->flash('success', 'A referência ' . $deletedReference->source .
            ' - ' . $deletedReference->reference . ' foi excluída com sucesso.');

        return redirect('/admin/references');
    }
}
