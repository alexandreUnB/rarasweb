<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Disorder;
use App\Http\Requests;
use App\Indicator;
use App\Professional;
use App\Reference;
use App\Sign;
use App\Specialty;
use App\Synonymous;
use App\TreatmentCenter;

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

        return view('main.disorders.show', compact('disorder', 'disorderType', 'protocol', 'icds',
            'countICDs', 'meshes', 'countMeSHes', 'umlses', 'countUMLSes', 'meddras', 'countMedDRAs',
            'omims', 'countOMIMs', 'synonyms', 'signs', 'references', 'indicators'));
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

        return view('main.professionals.show', compact('professional', 'specialties', 'countSpecialties'));
    }

    public function showTreatmentCenters($id)
    {
        $treatmentCenter = $this->treatmentCenterModel->find($id);
        
        $specialties = $treatmentCenter->specialties;
        $countSpecialties = count($specialties) - 1;

        return view('main.treatmentCenters.show', compact('treatmentCenter', 'specialties', 'countSpecialties'));
    }
}
