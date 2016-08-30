<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

<<<<<<< HEAD
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Disorder;
use App\Indicator;
use App\Professional;
use App\Reference;
use App\Sign;
use App\Specialty;
use App\Synonymous;
use App\TreatmentCenter;

=======
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
use rarasweb\Protocol;
use rarasweb\Law;
use DB;
>>>>>>> 51bbf94643a7aaaacec42d49a3e6a4157562649e

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
    /**
     * @var Protocols
     */
    private $protocolModel;
    /**
     * @var Laws
     */
    private $lawModel;

    public function __construct(Request $request, Disorder $disorderModel, Synonymous $synonymousModel,
                                Sign $signModel, Reference $referenceModel, Indicator $indicatorModel, 
                                Professional $professionalModel, TreatmentCenter $treatmentCenterModel,
                                Protocol $protocolModel, Law $lawModel)
    {
        $this->request = $request;
        $this->disorderModel = $disorderModel;
        $this->synonymousModel = $synonymousModel;
        $this->signModel = $signModel;
        $this->referenceModel = $referenceModel;
        $this->indicatorModel = $indicatorModel;
        $this->professionalModel = $professionalModel;
        $this->treatmentCenterModel = $treatmentCenterModel;
        $this->protocolModel = $protocolModel;
        $this->lawModel = $lawModel;
    }

    // function to search professional link by name
    public function professionalName($name)
    {
        
        return  $proessionals = DB::select('SELECT * FROM professionals WHERE name LIKE ? OR CONCAT(name,surname)=?', 
            ['%'.$name.'%', $name]);

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

        foreach ($indicators as $indicator)
        {
            $indicator['nameIndicatorType'] = $indicator->indicatorType->name;
            $indicator['nameIndicatorSource'] = $indicator->indicatorSource->name;
        }

        $professionals = collect();
        $treatmentCenters = collect();

        foreach ($specialties as $specialty) {
            $professionals = $professionals->merge($specialty->professionals);
            $treatmentCenters = $treatmentCenters->merge($specialty->treatmentCenters);
        }

        // $professionals = $professionals->unique()->sortBy('name');

        $specialties = $disorder->specialties()
            ->orderBy('name')
            ->get();

		$disorder = $this->disorderModel->find($id);

		$signs = $disorder->signs()
            ->orderBy('name')
            ->get();

        $signsLength = $signs->count(0);

        $signs = $signs->take(10);


        $centers = $treatmentCenters->toArray();

        $professionalsFilter = $professionals->take(10)->toArray();

        return response()->json(compact('specialties', 'disorder', 'signs', 
            'signsLength','centers', 'professionalsFilter', 'indicators'));

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

        $centerDis =  $centerDisorders->toArray();


        $treatmentCenter = $this->treatmentCenterModel->find($id);

        // return response()->json(compact('treatmentCenter', 'specialties', 'countSpecialties', 'centerDisorders'));
        return response()->json(compact('treatmentCenter', 'centerDis'));

    }

    public function signLoader($id, $pos)
    {
        $disorder = $this->disorderModel->find($id);

        $signs = $disorder->signs()
            ->orderBy('name')
            ->get()->splice($pos,10)->toArray();


 
        return response()->json(compact('signs'));

    }

    public function profLoader($id, $pos)
    {
        $disorder = $this->disorderModel->find($id);
        $specialties = $disorder->specialties()
            ->orderBy('name')
            ->get();

        $professionals = collect();

        foreach ($specialties as $specialty) {
            $professionals = $professionals->merge($specialty->professionals);
        }

        $professionalsFilter = $professionals->splice($pos,10)->toArray();


        return response()->json(compact('professionalsFilter'));

    }

    public function disorderName($name)
    {
        $disorders = $this->disorderModel
            ->where('name', 'like', '%'.$name.'%')
            ->orderBy('name')->get()->toArray();
        return response()->json(compact('disorders'));
    }

    public function centerName($name)
    {
        $centers = $this->treatmentCenterModel
            ->where('name', 'like', '%'.$name.'%')
            ->orderBy('name')->get()->toArray();
        return response()->json(compact('centers'));
    }

    public function protocolID($id)
    {
        $protocol = $this->protocolModel->find($id);

        return $protocol;
    }

    public function protocolName($name)
    {
        if($name == "all"){

            $protocols = collect();

            $protocols = $this->protocolModel
                ->orderBy('document')
                ->get();


        }else{
            $disorders = $this->disorderModel
            ->where('name', 'like', '%'.$name.'%')
            ->orderBy('name')
            ->get();

            $protocols = collect();

            $protocols = $this->protocolModel
                ->where('document', 'like', '%'.$name.'%')
                ->orderBy('document')
                ->get();

            foreach ($disorders as $disorder)
            {
                if ($disorder->protocol)
                {
                    $protocols->push($disorder->protocol);
                }
            }

        }

        return response()->json(compact('protocols'));

    }


    public function disorderBySign($name, $pos){

        $disorders = $this->disorderModel
            ->where('name', 'like', '%'.$name.'%')
            ->orderBy('name')->get();

        $signs = collect();


        // foreach ($disorders as $disorder)
        // {
        //     if ($disorder->signs)
        //     {
        //         foreach ($disorder->signs as $sign)
        //         {
        //             $signs->push($sign);
        //         }
        //     }
        // } 

        foreach ($disorders as $disorder) {
            $signs = $signs->merge($disorder->signs);
        }

        $signs = $signs->splice($pos,10)->toArray();

        return response()->json(compact('signs'));

    }


    public function lawID($id)
    {
        $law = $this->lawModel->find($id);

        return $law;
    }

    public function lawName($name)
    {
        
        $laws = $this->lawModel
            ->where('name_law', 'like', '%'.$name.'%')
            ->orderBy('name_law')
            ->get()->toArray();

  
        return response()->json(compact('laws'));
    }
}
