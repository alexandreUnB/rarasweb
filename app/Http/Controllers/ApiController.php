<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


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
use App\Protocol;
use App\Law;
use DB;

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
    /**
     * @var Specialties
     */
    private $specialtyModel;


    /**
    * Method constructor
    * @param
    **/
    public function __construct(Request $request, Disorder $disorderModel, Synonymous $synonymousModel,
                                Sign $signModel, Reference $referenceModel, Indicator $indicatorModel, 
                                Professional $professionalModel, TreatmentCenter $treatmentCenterModel,
                                Protocol $protocolModel, Law $lawModel, Specialty $specialtyModel)
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
        $this->specialtyModel = $specialtyModel;
    }

    // **********************************************************************
    // *                    Professional related routes                     *
    // **********************************************************************

    public function professionalName($name, $pos)
    {
        
        $response = DB::select('SELECT * FROM professionals WHERE name LIKE ? OR CONCAT(name,surname)=?', 
            ['%'.$name.'%', $name]);

        $professionals = collect();

        foreach ($response as $professional){
            $professionals->push($professional);

        }
        $professionalCount = $professionals->count();
        foreach ($professionals as $profAux){
            $profAux->count = $professionalCount;
            break;

        }
        $professionals = $professionals->splice($pos,10)->toArray();


        return  response()->json(compact('professionals'))->header('Access-Control-Allow-Origin' , '*')
          ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
          ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');


    }
    
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

        return response()->json(compact('professional', 'specialties', 'countSpecialties', 'professionalDisorders'))
            ->header('Access-Control-Allow-Origin' , '*')
            ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');

    }

    public function profLoader($id, $pos)
    {
        $disorder = $this->disorderModel->find($id);
        // $specialties = $disorder->specialties()
        //     ->orderBy('name')
        //     ->get();

        $professionals = collect();

        foreach ($specialties as $specialty) {
            $professionals = $professionals->merge($specialty->professionals);
        }

        $professionalsFilter = $professionals->splice($pos,10)->toArray();


        return response()->json(compact('professionalsFilter'));

    }

    public function profDisorder($disorderName, $pos)
    {
        $disorders = $this->disorderModel
            ->where('name', 'like', '%'.$disorderName.'%')
            ->orderBy('name')->get();


        // $specialties = collect();

        // foreach ($disorders as $disorder){
        //     $specialties = $specialties->merge($disorder->specialties);
        // }

        $professionals = collect();

        foreach ($specialties as $specialty){
            $professionals = $professionals->merge($specialty->professionals);
        }


        $professionalCount = $professionals->count();
        foreach ($professionals as $profAux){
            $profAux->count = $professionalCount;
            break;

        }

                $professionals = $professionals->splice($pos,10)->toArray();


       return response()->json(compact('professionals'))->header('Access-Control-Allow-Origin' , '*')
          ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
          ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');
;
    }

    public function professionalLocal($local, $pos)
    {

        $professionals = $this->professionalModel
            ->where('uf', 'like', '%'.$local.'%') 
            ->orWhere('city', 'like', '%'.$local.'%') 
            ->orderBy('name')->get();

        $professionalCount = $professionals->count();
        foreach ($professionals as $profAux){
            $profAux->count = $professionalCount;
            break;

        }
        $professionals = $professionals->splice($pos,10)->toArray();




       return response()->json(compact('professionals'))->header('Access-Control-Allow-Origin' , '*')
          ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
          ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');

    }


    public function professionalUF($local, $pos)
    {

        $professionals = $this->professionalModel
            ->where('uf', '=', $local) 
            ->orderBy('name')->get();

        $professionalCount = $professionals->count();
        foreach ($professionals as $profAux){
            $profAux->count = $professionalCount;
            break;

        }
        $professionals = $professionals->splice($pos,10)->toArray();


       return response()->json(compact('professionals'))->header('Access-Control-Allow-Origin' , '*')
          ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
          ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');

    }

    public function professionalSpecialty($specialtyName, $pos)
    {

        $specialties = $this->specialtyModel
            ->where('name', 'like', '%'.$specialtyName.'%') 
            ->orderBy('name')->get();


        $professionals = collect();

        foreach ($specialties as $specialty){
            $professionals = $professionals->merge($specialty->professionals);
        }


        $professionalCount = $professionals->count();
        foreach ($professionals as $profAux){
            $profAux->count = $professionalCount;
            break;

        }

        $professionals = $professionals->splice($pos,10)->toArray();

       return response()->json(compact('professionals'))->header('Access-Control-Allow-Origin' , '*')
          ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
          ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');

    }


    // **********************************************************************
    // *                    Center related routes                           *
    // **********************************************************************

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

        return response()->json(compact('treatmentCenter', 'centerDis'))->header('Access-Control-Allow-Origin' , '*')
          ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
          ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');


    }

    public function centerName($name, $pos)
    {
        $centers = $this->treatmentCenterModel
            ->where('name', 'like', '%'.$name.'%')
            ->orderBy('name')->get();

        $centerCount = $centers->count();
        foreach ($centers as $centerAux){
            $centerAux->count = $centerCount;
            break;

        }

        $centers = $centers->splice($pos,10)->toArray();

        return response()->json(compact('centers'))->header('Access-Control-Allow-Origin' , '*')
          ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
          ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');


    }

    public function centerDisorder($disorderName, $pos)
    {
        $disorders = $this->disorderModel
            ->where('name', 'like', '%'.$disorderName.'%')
            ->orderBy('name')->get();


        // $specialties = collect();

        // foreach ($disorders as $disorder){
        //     $specialties = $specialties->merge($disorder->specialties);
        // }

        $centers = collect();

        foreach ($specialties as $specialty){
            $centers = $centers->merge($specialty->treatmentCenters);
        }

        $centerCount = $centers->count();
        foreach ($centers as $centerAux){
            $centerAux->count = $centerCount;
            break;

        }

        $centers = $centers->splice($pos,10)->toArray();


       return response()->json(compact('centers'))->header('Access-Control-Allow-Origin' , '*')
          ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
          ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');

    }


    public function centerSpecialty($specialtyName, $pos)
    {

        $specialties = $this->specialtyModel
            ->where('name', 'like', '%'.$specialtyName.'%') 
            ->orderBy('name')->get();


        $centers = collect();

        foreach ($specialties as $specialty){
            $centers = $centers->merge($specialty->treatmentCenters);
        }

        $centerCount = $centers->count();
        foreach ($centers as $centerAux){
            $centerAux->count = $centerCount;
            break;

        }

        $centers = $centers->splice($pos,10)->toArray();

       return response()->json(compact('centers'))->header('Access-Control-Allow-Origin' , '*')
          ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
          ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');


    }



    public function centerLocal($local, $pos)
    {

        $centers= $this->treatmentCenterModel
            ->where('uf', 'like', '%'.$local.'%') 
            ->orWhere('city', 'like', '%'.$local.'%') 
            ->orderBy('name')->get();

        $centerCount = $centers->count();
        foreach ($centers as $centerAux){
            $centerAux->count = $centerCount;
            break;

        }

        $centers = $centers->splice($pos,10)->toArray();

       return response()->json(compact('centers'))->header('Access-Control-Allow-Origin' , '*')
          ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
          ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');

    }

    public function centerUF($local, $pos)
    {

        $centers= $this->treatmentCenterModel
            ->where('uf', '=', $local) 
            ->orderBy('name')->get();

        $centerCount = $centers->count();
        foreach ($centers as $centerAux){
            $centerAux->count = $centerCount;
            break;

        }

        $centers = $centers->splice($pos,10)->toArray();

       return response()->json(compact('centers'))->header('Access-Control-Allow-Origin' , '*')
          ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
          ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');

    }

    // ************************************************************************
    // *                    Signs related routes                              *
    // ************************************************************************


    public function signLoader($id, $pos)
    {
        $disorder = $this->disorderModel->find($id);

        $signs = $disorder->signs()
            ->orderBy('name')
            ->get()->splice($pos,10)->toArray();


 
        return response()->json(compact('signs'));

    }


    // **********************************************************************
    // *                    Disorder related routes                         *
    // **********************************************************************

    public function disorderID($id)
    {
        $disorder = $this->disorderModel->find($id);

        $disorderType = $disorder->disorderType;

        // $specialties = $disorder->specialties()
        //     ->orderBy('name')
        //     ->get();
        // $countSpecialties = count($specialties) - 1;

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

        // foreach ($specialties as $specialty) {
        //     $professionals = $professionals->merge($specialty->professionals);
        //     $treatmentCenters = $treatmentCenters->merge($specialty->treatmentCenters);
        // }


        // $specialties = $disorder->specialties()
        //     ->orderBy('name')
        //     ->get();

        $disorder = $this->disorderModel->find($id);

        $signs = $disorder->signs()
            ->orderBy('name')
            ->get();

        $signsLength = $signs->count(0);

        $signs = $signs->take(10);


        $centers = $treatmentCenters->toArray();

        $professionalsFilter = $professionals->take(10)->toArray();

        return response()->json(compact('disorder', 'signs', 
            'signsLength','centers', 'professionalsFilter', 'indicators','protocol','icds'))
            ->header('Access-Control-Allow-Origin' , '*')
            ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');


    }

    public function disorderName($name, $pos)
    {
        $disorders = $this->disorderModel
            ->where('name', 'like', '%'.$name.'%')
            ->orderBy('name')->get();



        $disordersCount = $disorders->count();
        foreach ($disorders as $disorder){
            $disorder->count = $disordersCount;
            break;

        }

        $disorders = $disorders->splice($pos,10)->toArray();

        return response()->json(compact('disorders'))
            ->header('Access-Control-Allow-Origin' , '*')
            ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');

    }



    public function disorderBySign($name, $pos){

        $disorders = $this->disorderModel
            ->where('name', 'like', '%'.$name.'%')
            ->orderBy('name')->get();

        $signs = collect();

        foreach ($disorders as $disorder) {
            $signs = $signs->merge($disorder->signs);
        }

        $signs = $signs->splice($pos,10)->toArray();

        return response()->json(compact('signs'))
            ->header('Access-Control-Allow-Origin' , '*')
            ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');


    }

    public function disorderCID($id, $pos)
     {
         $references = $this->referenceModel
             ->where('reference', 'like', '%'.$id.'%')
             ->where('source', 'ICD-10')
             ->get();
 
         $disorders = collect();
 
         foreach ($references as $reference){
             $disorders = $disorders->merge($reference->disorders);
         }
 
 
        $disordersCount = $disorders->count();
        foreach ($disorders as $disorder){
            $disorder->count = $disordersCount;
            break;

        }

        $disorders = $disorders->splice($pos,10)->toArray();

 
        return response()->json(compact('disorders'))
            ->header('Access-Control-Allow-Origin' , '*')
            ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');

     }

    // ***********************************************************************
    // *                    Protocols related routes                         *
    // ***********************************************************************

    public function protocolID($id)
    {
        $protocol = $this->protocolModel->find($id);

        return $protocol;
    }

    public function protocolName($name)
    {
        if($name == "all"){


        $response = DB::select('SELECT p.*, d.name as disorder_name FROM protocols p LEFT JOIN disorders d on p.disorder_id = d.id');

        $protocols = collect();

        foreach ($response as $protocol){
            $protocols->push($protocol);
        }


        $protocols = $protocols->toArray();

        


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
                    $disorder->protocol['disorder_name'] = $disorder->name;
                    $protocols->push($disorder->protocol);
                }
            }

        

        }

        return response()->json(compact('protocols'))->header('Access-Control-Allow-Origin' , '*')
            ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');


    }


    // ***********************************************************************
    // *                    Laws related routes                              *
    // ***********************************************************************

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
