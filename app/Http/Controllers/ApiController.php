<?php

namespace rarasweb\Http\Controllers;

use Illuminate\Http\Request;

use rarasweb\Http\Requests;
use rarasweb\Http\Controllers\Controller;

use rarasweb\Disorder;
use rarasweb\Indicator;
use rarasweb\Professional;
use rarasweb\Reference;
use rarasweb\Sign;
use rarasweb\Specialty;
use rarasweb\Synonymous;
use rarasweb\TreatmentCenter;


class ApiController extends Controller
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

    // function to search professional link by name
    public function professionalName($name)
    {
        return $this->professionalModel
            ->where('name', 'like', '%' . $name . '%')
            ->get();

    }
    
    // function to search professional link by ID
    public function professionalID($id)
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

        return response()->json(compact('professional', 'specialties', 'countSpecialties', 'professionalDisorders'));
        
        // return $this->professionalModel
        //     ->where('id', $id)
        //     ->get();

    }


    // function to search disorder by id
    public function disorderID($id)
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

        $professionals = $professionals->unique()->sortBy('name');

        $specialties = $disorder->specialties()
            ->orderBy('name')
            ->get();

		$disorder = $this->disorderModel->find($id);

		$signs = $disorder->signs()
            ->orderBy('name')
            ->get();


        $centers = $treatmentCenters->toArray();

        return response()->json(compact('specialties', 'disorder', 'signs', 'centers'));
    }


    public function centerID($id)
    {
        $treatmentCenter = $this->treatmentCenterModel->find($id);

        $specialties = $treatmentCenter->specialties;
        $countSpecialties = count($specialties) - 1;
        
        $centerDisorders = collect();

        foreach ($specialties as $specialty)
        {
            $centerDisorders = $centerDisorders->merge($specialty->disorders);
        }

        $centersDis =  $centerDisorders->toArray();


        $treatmentCenter = $this->treatmentCenterModel->find($id);

        // return response()->json(compact('treatmentCenter', 'specialties', 'countSpecialties', 'centerDisorders'));
        return response()->json(compact('treatmentCenter'));

    }
}
