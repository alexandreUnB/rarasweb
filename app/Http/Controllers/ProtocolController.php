<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use App\Protocol;
use App\Disorder;

class ProtocolController extends Controller
{
    private $protocolModel;
    private $disorderModel;

    public function __construct(Protocol $protocolModel, Disorder $disorderModel, Request $request)
    {
        $this->protocolModel = $protocolModel;
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
        $protocols = $this->protocolModel
            ->paginate(10);

        return view('admin.protocols.index', compact('protocols'));
    }

    public function search()
    {
        $searchedExpression = $this->request->searchedProtocol;

        if ($this->request->searchType == 'protocolDisorderName')
        {
            $disorders = $this->disorderModel
                ->where('name' , 'like' , '%'.$searchedExpression.'%')
                ->orderBy('name')
                ->get();
        }
        elseif ($this->request->searchType == 'protocolDisorderNamePortuguese')
        {
            $disorders = $this->disorderModel
                ->where('name_portuguese' , 'like' , '%'.$searchedExpression.'%')
                ->orderBy('name_portuguese')
                ->paginate(10);
        }
        elseif ($this->request->searchType == 'protocolDisorderOrphanumber')
        {
            $disorders = $this->disorderModel
                ->where('orphanumber' , 'like' , $searchedExpression.'%')
                ->orderBy('orphanumber')
                ->get();
        }

        $protocols = collect();

        foreach ($disorders as $disorder)
        {
            if ($disorder->protocol)
            {
                $protocols->push($disorder->protocol);
            }
        }

        if ($protocols)
        {
            $page = Input::get('page', 1); // Get the ?page=1 from the url
            $perPage = 10; // Number of items per page
            $offset = ($page * $perPage) - $perPage;

            $protocols = new LengthAwarePaginator(
                $protocols->slice($offset, $perPage, true), // Only grab the items we need
                count($protocols), // Total items
                $perPage, // Items per page
                $page, // Current page
                ['path' => $this->request->url(), 'query' => $this->request->query()] // We need this so we can keep all old query parameters from the url
            );
        }

        Input::flash();

        return view('admin.protocols.index', compact('protocols'))->with($this->request->all());
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

        return view('admin.protocols.create', compact('disorders'));
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
        $validator = Validator::make($request, Protocol::$rules, Protocol::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/protocols/create')
                ->withErrors($validator)
                ->withInput($request);
        }

        if (str_contains($request['document'], '/') || str_contains($request['document'], '\\'))
        {
            session()->flash('erro', 'A portaria não pode conter os símbolos / e \\');

            return redirect('admin/protocols/create')->withInput($request);
        }

        $request['document'] = trim($request['document']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['document'] = str_replace('°', 'º', $request['document']); // Troca o símbolo de grau pelo indicador cardinal

        $pdf = $this->request->file('pdf');
        $disorder = $this->disorderModel->find($this->request->disorder_id);
        $fileExtension = $pdf->getClientOriginalExtension();
        $fileName = $disorder->orphanumber . "." . $fileExtension;
        $pdf->move(public_path('protocols'), $fileName);

        $newProtocol = $request;
        $newProtocol['name_pdf'] = $fileName;
        $this->protocolModel->create($newProtocol);

        session()->flash('success', 'O protocolo da doença ' . $disorder->name . ' foi cadastrado com sucesso');

        return redirect('/admin/protocols/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $protocol = $this->protocolModel->find($id);

        return view('admin.protocols.show', compact('protocol'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $protocol = $this->protocolModel->find($id);

        return view('admin.protocols.edit', compact('protocol'));
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
        $rules = Protocol::$rules;

        if (!$this->request->hasFile('pdf'))
        {
            array_pull($rules, 'pdf');
        }
        
        array_pull($rules, 'disorder_id');
        $request = $this->request->all();
        $validator = Validator::make($request, $rules, Protocol::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/protocols/edit/' . $id)
                ->withErrors($validator)
                ->withInput($request);
        }

        if (str_contains($request['document'], '/') || str_contains($request['document'], '\\'))
        {
            session()->flash('erro', 'A portaria não pode conter os símbolos / e \\');

            return redirect('admin/protocols/edit/' . $id)->withInput($request);
        }

        $request['document'] = trim($request['document']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['document'] = str_replace('°', 'º', $request['document']); // Troca o símbolo de grau pelo indicador cardinal

        $protocol = $this->protocolModel->find($id);
        $protocol->update($request);

        if ($this->request->hasFile('pdf'))
        {
            File::delete(public_path('protocols/' . $protocol->name_pdf));
            $this->request->file('pdf')->move(public_path('protocols'), $protocol->name_pdf);
        }

        session()->flash('success', 'O protocolo da doença ' . $protocol->disorder->name . ' foi editado com sucesso');

        return redirect('/admin/protocols');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deletedProtocol = $this->protocolModel->find($id);
        $deletedProtocol->delete();
        
        File::delete(public_path('protocols/' . $deletedProtocol->name_pdf));

        session()->flash('success', 'O protocolo da doença ' . $deletedProtocol->disorder->name . ' foi excluído com sucesso');

        return redirect(\Illuminate\Support\Facades\URL::previous());
    }
}
