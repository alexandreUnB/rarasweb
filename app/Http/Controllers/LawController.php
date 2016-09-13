<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\Law;

class LawController extends Controller
{
    private $lawModel;

    public function __construct(Law $lawModel, Request $request)
    {
        $this->lawModel = $lawModel;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laws = $this->lawModel
            ->orderBy('name_pdf')
            ->paginate(10);

        return view('admin.laws.index', compact('laws'));
    }

    public function search()
    {
        $laws = $this->lawModel
            ->where('name_law' , 'like' , $this->request->searchedLaw.'%')
            ->orderBy('name_law')
            ->paginate(10);

        Input::flash();

        return view('admin.laws.index', compact('laws'))->with($this->request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.laws.create');
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
        $validator = Validator::make($request, Law::$rules, Law::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/laws/create')
                ->withErrors($validator)
                ->withInput($request);
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'O nome da lei não pode conter os símbolos / e \\');

            return redirect('admin/laws/create')->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        $newLaw = $this->lawModel->create($request);

        $pdf = $this->request->file('pdf');
        $fileExtension = $pdf->getClientOriginalExtension();
        $fileName = $newLaw->id . "." . $fileExtension;
        $pdf->move(public_path('laws'), $fileName);

        DB::table('laws')
            ->where('id', $newLaw->id)
            ->update(['name_pdf' => $fileName]);

        session()->flash('success', 'A lei ' . $newLaw->name_law . ' foi cadastrada com sucesso');

        return redirect('/admin/laws/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $law = $this->lawModel->find($id);

        return view('admin.laws.show', compact('law'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $law = $this->lawModel->find($id);

        return view('admin.laws.edit', compact('law'));
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
        $rules = Law::$rules;

        if (!$this->request->hasFile('pdf'))
        {
            array_pull($rules, 'pdf');
        }

        array_set($rules, 'name_law', 'required|min:10|max:50|unique:laws,name_law,' . $id);
        $request = $this->request->all();
        $validator = Validator::make($request, $rules, Law::$messages);

        if ($validator->fails())
        {
            return redirect('/admin/laws/edit/' . $id)
                ->withErrors($validator)
                ->withInput($request);
        }

        if (str_contains($request['name'], '/') || str_contains($request['name'], '\\'))
        {
            session()->flash('erro', 'O nome da lei não pode conter os símbolos / e \\');

            return redirect('admin/laws/edit/' . $id)->withInput($request);
        }

        $request['name'] = trim($request['name']); // Remove espaços, tabulações e afins do começo e do final da string
        $request['name'] = str_replace('°', 'º', $request['name']); // Troca o símbolo de grau pelo indicador cardinal

        $law = $this->lawModel->find($id);
        $law->update($request);

        if ($this->request->hasFile('pdf'))
        {
            File::delete(public_path('laws/' . $law->name_pdf));
            $this->request->file('pdf')->move(public_path('laws'), $law->name_pdf);
        }

        session()->flash('success', 'A lei ' . $law->name_law . ' foi editada com sucesso');

        return redirect('/admin/laws');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deletedLaw = $this->lawModel->find($id);
        $deletedLaw->delete();

        File::delete(public_path('laws/' . $deletedLaw->name_pdf));

        session()->flash('success', 'A lei ' . $deletedLaw->name_law . ' foi excluída com sucesso');

        return redirect(\Illuminate\Support\Facades\URL::previous());
    }
}
