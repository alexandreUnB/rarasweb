<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Sign;

class SignController extends Controller
{
    private $signModel;

    public function __construct(Sign $signModel, Request $request)
    {
        $this->signModel = $signModel;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $signs = $this->signModel
            ->orderBy('name')
            ->orderBy('frequency')
            ->paginate(10);

        return view('admin.signs.index', compact('signs'));
    }

    public function search()
    {
        $signs = $this->signModel
            ->where('name', 'like', '%'.$this->request->searchedSign.'%')
            ->orderBy('name')
            ->orderBy('frequency')
            ->paginate(10);

        Input::flash();

        return view('admin.signs.index', compact('signs'))->with($this->request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $frequencies = $this->signModel
            ->distinct()
            ->orderBy('frequency')
            ->lists('frequency');

        return view('admin.signs.create', compact('frequencies'));
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
        $validator = Validator::make($request, Sign::$rules, Sign::$messages);

        if ($validator->fails()) {
            return redirect('admin/signs/create')
                ->withErrors($validator)
                ->withInput($request);
        }

        $newSign = $request;

        $validationSign = $this->signModel->where([
            ['name', $newSign['name']],
            ['frequency', $newSign['frequency']],
        ])->first();

        if($validationSign)
        {
            session()->flash('erro', 'O sinal ' . $newSign['name'] . ' - ' . $newSign['frequency'] . ' já está cadastrado');

            return redirect('/admin/signs/create')->withInput($request);
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'O nome do sinal não pode conter os símbolos / e \\');

            return redirect('admin/signs/create')->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        $this->signModel->create($newSign);

        session()->flash('success', 'O sinal ' . $newSign['name'] .
            ' - ' . $newSign['frequency'] . ' foi cadastrado com sucesso');

        return redirect('admin/signs/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sign = $this->signModel->find($id);

        $signDisorders = $sign->disorders()
            ->orderBy('name')
            ->paginate(10);

        return view('admin.signs.show', compact('sign', 'signDisorders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sign = $this->signModel->find($id);

        $frequencies = $this->signModel
            ->distinct()
            ->orderBy('frequency')
            ->lists('frequency');

        return view('admin.signs.edit', compact('sign', 'frequencies'));
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
        $validator = Validator::make($request, Sign::$rules, Sign::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/sign/create')
                ->withErrors($validator)
                ->withInput($request);
        }

        $updatedSign = $request;

        $validationSign = $this->signModel->where([
            ['name', $updatedSign['name']],
            ['frequency', $updatedSign['frequency']],
        ])->first();

        if($validationSign)
        {
            session()->flash('erro', 'O sinal ' . $updatedSign['name'] . ' - ' . $updatedSign['frequency'] . ' já está cadastrado');

            return redirect('/admin/signs/edit/' . $id)->withInput($request);
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'O nome do sinal não pode conter os símbolos / e \\');

            return redirect('admin/signs/edit/' . $id)->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        $this->signModel->find($id)->update($updatedSign);

        session()->flash('success', 'O sinal ' . $updatedSign['name'] .
            ' - ' . $updatedSign['frequency'] . ' foi editado com sucesso');

        return redirect('/admin/signs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deletedSign = $this->signModel->find($id);
        $associatedDisorders = $deletedSign->disorders;

        if (count($associatedDisorders))
        {
            if (count($associatedDisorders) == 1)
            {
                session()->flash('erro', 'Esse sinal está associado a ' . count($associatedDisorders) . ' desordem. Exclusão não permitida');
            }
            else
            {
                session()->flash('erro', 'Esse sinal está associado a ' . count($associatedDisorders) . ' desordens. Exclusão não permitida');
            }

            return redirect('/admin/signs');
        }

        $deletedSign->delete();

        session()->flash('success', 'O sinal ' . $deletedSign->name .
            ' - ' . $deletedSign->frequency . ' foi excluído com sucesso.');

        return redirect(\Illuminate\Support\Facades\URL::previous());
    }
}
