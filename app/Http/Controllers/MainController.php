<?php

namespace rarasweb\Http\Controllers;

use Illuminate\Http\Request;

use rarasweb\Disorder;
use rarasweb\Http\Requests;
use rarasweb\Indicator;
use rarasweb\Professional;
use rarasweb\Reference;
use rarasweb\Sign;
use rarasweb\Specialty;
use rarasweb\Synonymous;
use rarasweb\TreatmentCenter;

class MainController extends Controller
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Disorder
     */
    private $disorderModel;
    /**
     * @var Synonymous
     */
    private $synonymousModel;
    /**
     * @var Sign
     */
    private $signModel;
    /**
     * @var Reference
     */
    private $referenceModel;
    /**
     * @var Indicator
     */
    private $indicatorModel;
    /**
     * @var Professional
     */
    private $professionalModel;
    /**
     * @var TreatmentCenter
     */
    private $treatmentCenterModel;

    public function __construct(Request $request, Disorder $disorderModel, Synonymous $synonymousModel,
                                Sign $signModel, Reference $referenceModel, Indicator $indicatorModel, 
                                Professional $professionalModel, TreatmentCenter $treatmentCenterModel)
    {
        $this->request = $request;
        $this->disorderModel = $disorderModel;
        $this->synonymousModel = $synonymousModel;
        $this->signModel = $signModel;
        $this->referenceModel = $referenceModel;
        $this->indicatorModel = $indicatorModel;
        $this->professionalModel = $professionalModel;
        $this->treatmentCenterModel = $treatmentCenterModel;
    }

    public function main(){
        return view('main.search');
    }

    public function search()
    {
        $searchedDisorder = $this->request->search;

        $disorders = $this->disorderModel
            ->where('orphanumber' , 'like' , $searchedDisorder.'%')
            ->orWhere('name', 'like', $searchedDisorder.'%')
            ->orderBy('orphanumber')
            ->paginate(10);

        return view('main.disorders.index', compact('disorders'));
    }

    public function showDisorders($id)
    {
        $disorder = $this->disorderModel->find($id);
        
        $disorderType = $disorder->disorderType;
        
        $specialties = $disorder->specialties()
            ->orderBy('name')
            ->get();
        $countSpecialties = count($specialties) - 1;
        
        $protocol = $disorder->protocol;
        
        $synonyms = $disorder->synonyms()
            ->orderBy('name')
            ->get();
        
        $signs = $disorder->signs()
            ->orderBy('name')
            ->get();
        
        $references = $disorder->references()
            ->orderBy('source')
            ->orderBy('reference')
            ->get();
        
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

        $professionals = collect();
        $treatmentCenters = collect();

        foreach ($specialties as $specialty) {
            $professionals = $professionals->merge($specialty->professionals);
            $treatmentCenters = $treatmentCenters->merge($specialty->treatmentCenters);
        }

        $professionals = $professionals->unique();
        $treatmentCenters = $treatmentCenters->unique();

        return view('main.disorders.show', compact('disorder', 'disorderType', 'specialties', 'countSpecialties',
            'protocol', 'icds', 'countICDs', 'meshes', 'countMeSHes', 'umlses', 'countUMLSes', 'meddras', 'countMedDRAs',
            'omims', 'countOMIMs', 'synonyms', 'signs', 'references', 'indicators', 'professionals', 'treatmentCenters'));
    }

    public function showSynonimous($id)
    {
        $synonymous = $this->synonymousModel->find($id);

        $synonymousDisorder = $this->disorderModel->find($synonymous->disorder_id);

        return view('main.synonyms.show', compact('synonymous', 'synonymousDisorder'));
    }
    
    public function showSigns($id)
    {
        $sign = $this->signModel->find($id);

        $signDisorders = $sign->disorders()
            ->orderBy('name')
            ->paginate(10);
        
        return view('main.signs.show', compact('sign', 'signDisorders'));
    }

    public function showReferences($id)
    {
        $reference = $this->referenceModel->find($id);

        $referenceDisorders = $reference->disorders()
            ->orderBy('name')
            ->paginate(10);
        
        return view('main.references.show', compact('reference', 'referenceDisorders'));
    }

    public function showIndicators($id)
    {
        $indicator = $this->indicatorModel->find($id);

        return view('main.indicators.show', compact('indicator'));
    }

    public function showProfessionals($id)
    {
        $professional = $this->professionalModel->find($id);

        $specialties = $professional->specialties()->get();
        $countSpecialties = count($specialties) - 1;
        
        $professionalDisorders = collect();

        foreach ($specialties as $specialty)
        {
            $professionalDisorders = $professionalDisorders->merge($specialty->disorders);
        }

        $professionalDisorders = $professionalDisorders->unique();

        return view('main.professionals.show', compact('professional', 'specialties', 'countSpecialties', 'professionalDisorders'));
    }

    public function showTreatmentCenters($id)
    {
        $treatmentCenter = $this->treatmentCenterModel->find($id);
        
        $specialties = $treatmentCenter->specialties;
        $countSpecialties = count($specialties) - 1;
        
        $centerDisorders = collect();

        foreach ($specialties as $specialty)
        {
            $centerDisorders = $centerDisorders->merge($specialty->disorders);
        }

        $centerDisorders = $centerDisorders->unique();

        return view('main.treatmentCenters.show', compact('treatmentCenter', 'specialties', 'countSpecialties', 'centerDisorders'));
    }
}
