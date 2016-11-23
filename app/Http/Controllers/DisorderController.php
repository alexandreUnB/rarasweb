<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Disorder;
use App\DisorderType;
use App\Reference;
use App\Sign;
use App\DisorderReference;
use App\DisorderSign;

class DisorderController extends Controller
{
    private $disorderModel;
    private $disorderTypeModel;
    private $referenceModel;
    private $signModel;
    private $disorderReferenceModel;
    private $disorderSignModel;

    public function __construct(Disorder $disorderModel, DisorderType $disorderTypeModel, Reference $referenceModel,
                                Sign $signModel, DisorderReference $disorderReferenceModel,
                                DisorderSign $disorderSignModel, Request $request)
    {
        $this->disorderModel = $disorderModel;
        $this->disorderTypeModel = $disorderTypeModel;
        $this->referenceModel = $referenceModel;
        $this->signModel = $signModel;
        $this->disorderReferenceModel = $disorderReferenceModel;
        $this->disorderSignModel = $disorderSignModel;
        $this->request = $request;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disorders = $this->disorderModel
            ->orderBy('name')
            ->paginate(10);

        return view('admin.disorders.index', compact('disorders', 'index'));
    }

    public function search()
    {
        $searchedExpression = $this->request->searchedDisorder;

        if ($this->request->searchType == 'disorderName')
        {
            $disorders = $this->disorderModel
                ->where('name' , 'like' , '%'.$searchedExpression.'%')
                ->orderBy('name')
                ->paginate(10);
        }
//        elseif ($this->request->searchType == 'disorderNamePortuguese')
//        {
//            $disorders = $this->disorderModel
//                ->where('name_portuguese' , 'like' , '%'.$searchedExpression.'%')
//                ->orderBy('name_portuguese')
//                ->paginate(10);
//        }
        elseif ($this->request->searchType == 'disorderOrphanumber')
        {
            $disorders = $this->disorderModel
                ->where('orphanumber' , 'like' , $searchedExpression.'%')
                ->orderBy('orphanumber')
                ->paginate(10);
        }

        Input::flash();

        return view('admin.disorders.index', compact('disorders'))->with($this->request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $disorderTypes = $this->disorderTypeModel
            ->orderBy('name')
            ->get();

        $references = $this->referenceModel
            ->orderBy('source')
            ->orderBy('reference')
            ->get();

        $signs = $this->signModel
            ->orderBy('name')
            ->get();

        return view('admin.disorders.create', compact('disorderTypes', 'references', 'signs'));
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

        $validator = Validator::make($request, Disorder::$rules, Disorder::$messages );

        if ($validator->fails())
        {
            return redirect('/admin/disorders/create')
                ->withErrors($validator)
                ->withInput($request);
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'O nome da desordem não pode conter os símbolos / e \\');

            return redirect('admin/disorders/create')->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        $newDisorder = $this->disorderModel->create($request);

        $newReferences = $this->request->disorderReferences;
        $newSigns = $this->request->disorderSigns;

        if ($newReferences)
        {
            foreach ($newReferences as $newReference)
            {
                $newDisorderReference = new DisorderReference();
                $newDisorderReference->disorder_id = $newDisorder->id;
                $newDisorderReference->reference_id = $newReference;
                $newDisorderReference->save();
            }
        }

        if ($newSigns)
        {
            foreach ($newSigns as $newSign)
            {
                $newDisorderSign = new DisorderSign();
                $newDisorderSign->disorder_id = $newDisorder->id;
                $newDisorderSign->sign_id = $newSign;
                $newDisorderSign->save();
            }
        }

        session()->flash('success', 'A desordem ' . $newDisorder->name . ' foi cadastrada com sucesso');

        return redirect('/admin/disorders/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $disorder = $this->disorderModel->find($id);

        $disorderType = $disorder->disorderType;

        $protocol = $disorder->protocol;

        $synonyms = $disorder->synonyms()
            ->orderBy('name')
            ->paginate(10);

        $signs = $disorder->signs()
            ->orderBy('name')
            ->paginate(10);

        $references = $disorder->references()
            ->orderBy('source')
            ->orderBy('reference')
            ->paginate(10);

        $icds = $references
            ->where('source', 'ICD-10')
            ->pluck('reference');
        $countICDs = count($icds) - 1;

        $meshes = $references
            ->where('source', 'MeSH')
            ->pluck('reference');
        $countMeSHes = count($meshes) - 1;

        $umlses = $references
            ->where('source', 'UMLS')
            ->pluck('reference');
        $countUMLSes = count($umlses) - 1;

        $meddras = $references
            ->where('source', 'MedDRA')
            ->pluck('reference');
        $countMedDRAs = count($meddras) - 1;

        $omims = $references
            ->where('source', 'OMIM')
            ->pluck('reference');
        $countOMIMs = count($omims) - 1;

        $indicators = $disorder->indicators;

        return view('admin.disorders.show', compact('disorder', 'disorderType', 'protocol', 'icds',
            'countICDs', 'meshes', 'countMeSHes', 'umlses', 'countUMLSes', 'meddras', 'countMedDRAs',
            'omims', 'countOMIMs', 'synonyms', 'signs', 'references', 'indicators'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $disorder = $this->disorderModel->find($id);

        $disorderTypes = $this->disorderTypeModel
            ->orderBy('name')
            ->get();

        $references = $this->referenceModel
            ->orderBy('source')
            ->orderBy('reference')
            ->get();

        $disorderReferences = $disorder->references()->get();

        $signs = $this->signModel
            ->orderBy('name')
            ->get();

        $disorderSigns = $disorder->signs()->get();

        return view('admin.disorders.edit', compact('disorder', 'disorderTypes',
            'references', 'disorderReferences', 'signs', 'disorderSigns'));
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
        $rules = Disorder::$rules;
        array_set($rules, 'name', 'required|min:4|max:120|unique:disorders,name,' . $id);
        array_set($rules, 'orphanumber', 'required|digits_between:1,6|unique:disorders,orphanumber,' . $id);
        $validator = Validator::make($request, $rules, Disorder::$messages );

        if ($validator->fails())
        {
            return redirect('/admin/disorders/edit/' . $id)
                ->withErrors($validator)
                ->withInput($request);
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'O nome da desordem não pode conter os símbolos / e \\');

            return redirect('admin/disorders/edit/' . $id)->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        $updatedDisorder = $this->disorderModel->find($id);
        $updatedDisorder->update($request);

        $this->disorderReferenceModel
            ->where('disorder_id', $updatedDisorder->id)
            ->delete();
        $this->disorderSignModel
            ->where('disorder_id', $updatedDisorder->id)
            ->delete();

        $newReferencesID = $this->request->disorderReferences;
        $newSignsID = $this->request->disorderSigns;

        if ($newReferencesID)
        {
            foreach ($newReferencesID as $newReferenceID)
            {
                $newDisorderReference = new DisorderReference();
                $newDisorderReference->disorder_id = $updatedDisorder->id;
                $newDisorderReference->reference_id = $newReferenceID;
                $newDisorderReference->save();
            }
        }
        if ($newSignsID)
        {
            foreach ($newSignsID as $newSignID)
            {
                $newDisorderSign = new DisorderSign();
                $newDisorderSign->disorder_id = $updatedDisorder->id;
                $newDisorderSign->sign_id = $newSignID;
                $newDisorderSign->save();
            }
        }

        session()->flash('success', 'A desordem ' . $updatedDisorder->name . ' foi editada com sucesso');

        return redirect('/admin/disorders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deletedDisorder = $this->disorderModel->find($id);
        $deletedDisorder->delete();

        session()->flash('success', 'A desordem ' . $deletedDisorder->name . ' foi deletada com sucesso');

        return redirect(\Illuminate\Support\Facades\URL::previous());
    }
}
