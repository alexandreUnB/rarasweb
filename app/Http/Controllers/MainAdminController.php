<?php

namespace rarasweb\Http\Controllers;

use Illuminate\Http\Request;

use rarasweb\Http\Requests;

use rarasweb\Disorder;
use rarasweb\Indicator;
use rarasweb\Professional;
use rarasweb\Protocol;
use rarasweb\Reference;
use rarasweb\Sign;
use rarasweb\Specialty;
use rarasweb\Synonymous;
use rarasweb\TreatmentCenter;

class MainAdminController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
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
//            return redirect()->to('/login');
        }

    }
}
