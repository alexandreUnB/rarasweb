<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Disorder;
use App\Indicator;
use App\Professional;
use App\Protocol;
use App\Reference;
use App\Sign;
use App\Specialty;
use App\Synonymous;
use App\TreatmentCenter;
use Illuminate\Support\Facades\Auth;

class MainAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->hasRole(['admin','tec'])) {
            $sunDisorders = count(Disorder::all());
            $sunProfessionals = count(Professional::all());
            $sunProtocols = count(Protocol::all());
            $sunReferences = count(Reference::all());
            $sunSigns = count(Sign::all());
            $sunSpecialties = count(Specialty::all());
            $sunSynonymous = count(Synonymous::all());
            $sunTreatmentCenters = count(TreatmentCenter::all());
            $sunIndicators = count(Indicator::all());


            return view('admin.index', compact('sunDisorders', 'sunProfessionals', 'sunProtocols', 'sunSigns',
                'sunSpecialties', 'sunReferences', 'sunSynonymous', 'sunTreatmentCenters',
                'sunIndicators'));
        }else{

            session()->flash('erro', 'O usuário '. Auth::user()->name . '  não tem permissão para acessar o ambiente administrativo.');

            return redirect('/');
        }

    }
}
