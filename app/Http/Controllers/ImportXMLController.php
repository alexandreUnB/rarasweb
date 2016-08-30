<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AuxDisEsp;
use App\AuxProtocols;
use App\Disorder;

use App\DisorderReference;
use App\DisorderSign;
use App\DisorderSpecialty;
use App\DisorderType;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Protocol;
use App\Reference;
use App\Sign;
use App\Specialty;
use App\Synonymous;


class ImportXMLController extends Controller
{
    public function disorders()
    {

        $fileName = date('Ym').'-'.'Disorder'.'.xml' ;
        $fileXML = public_path("xml\\" . $fileName);

        if (!file_exists($fileXML)) {
            echo "O arquivo $fileXML não existe" . "<br>";
            echo "Fazendo Download do arquivo XML diretamente da Orphadata"  . "<br>";
            file_put_contents($fileXML, file_get_contents('http://www.orphadata.org/data/xml/en_product1.xml'));
            echo "<hr>";
        }

        list($usec, $sec) = explode(' ', microtime());
        $script_start = (float) $sec + (float) $usec;

        $jdbor=simplexml_load_file($fileXML);

        $conta = 0;

        foreach ($jdbor->DisorderList as $disorders ){

            foreach ($disorders as $disorder) {

                $conta = $conta + 1;

                echo "RarasNumber: " . $conta . "<br>";
                echo "OrphaNumber: " .$disorder->OrphaNumber. "<br>";
                echo "Nome da desordem: ". $disorder->Name."<br>";
                echo "Tipo da desordem: ". $disorder->DisorderType->Name."<br>";

                echo "Disorder Type: " . $disorder->DisorderType->Name . "<br>";




                $doenca = new Disorder();

                $doenca->name = $disorder->Name;
                $doenca->orphanumber = $disorder->OrphaNumber;

                /******* Gravando Tipo de Desordem**************/

                $disorderType = new DisorderType();

                $disorderType->name = $disorder->DisorderType->Name;


                $existDesorderType = DisorderType::where('name',$disorderType->name)->first();

                if (count($existDesorderType) == 0)
                {
                    $disorderType = new DisorderType();
                    $disorderType->name = $disorder->DisorderType->Name;
                    $disorderType->save();

                    $doenca->disorderType_id = $disorderType->id ;

                }else {

                    $doenca->disorderType_id = $existDesorderType->id;
                }

                $doenca->save();

                /******* Gravando Sinônimos ******************/



                echo "<br>Sinônimos <br>";
                foreach ($disorder->SynonymList->Synonym as $synonym) {

                    echo $synonym . "<br>";
                    $newSynonym = new Synonymous();
                    $newSynonym->name = $synonym ;
                    $newSynonym->disorder_id = $doenca->id ;

                    $newSynonym->save();

                }

                /******* Gravando Referências **************/

                echo "<br>Referências<br>";

                if(count($disorder->ExternalReferenceList->ExternalReference) > 0) {

                    foreach ($disorder->ExternalReferenceList->ExternalReference as $referencia) {

                        $existReference = Reference::where([
                            ['source',$referencia->Source],
                            ['reference',$referencia->Reference],
                            ['map_relation',$referencia->DisorderMappingRelation->Name]
                        ])->first();

                        $newReference = new References();

                        if (!$existReference) {


                            $newReference = new Reference();


                            $newReference->source = $referencia->Source;
                            $newReference->reference = $referencia->Reference;
                            $newReference->map_relation = $referencia->DisorderMappingRelation->Name;
                            $newReference->save();
                        }else{
                            $newReference->id = $existReference->id;
                        }

                        echo $referencia->Source . " - " . $referencia->Reference . " - " . $referencia
                                ->DisorderMappingRelation->Name . "<br>";

                        $newDisorderReference = new DisorderReference();

                        $newDisorderReference->disorder_id = $doenca->id;
                        $newDisorderReference->reference_id = $newReference->id;
                        $newDisorderReference->save();
                    }
                }

                set_time_limit(60);

                echo "<hr>";
            }

        }

        list($usec, $sec) = explode(' ', microtime());
        $script_end = (float) $sec + (float) $usec;
        $elapsed_time = round($script_end - $script_start, 5);

        echo 'Tempo de execução ===>>> ', $elapsed_time/60, ' min'. '<br>' .
            'Memoria Utilizada ===>>> ', round(((memory_get_peak_usage(true) / 1024) / 1024), 2), 'Mb';

    }

    public function signs()
    {

        $fileName = date('Ym').'-'.'Sign'.'.xml' ;
        $fileXML = public_path("xml\\" . $fileName);


        $badDisorder = "Lista de Doenças que tem sinais cadastrados mas não estão na tabela de Disorder." . PHP_EOL;


        if (!file_exists($fileXML)) {
            echo "O arquivo $fileXML não existe" . "<br>";
            echo "Fazendo Download do arquivo XML diretamente da Orphadata"  . "<br>";
            file_put_contents($fileXML, file_get_contents('http://www.orphadata.org/data/xml/en_product4.xml'));
            echo "<hr>";
        }

        list($usec, $sec) = explode(' ', microtime());
        $script_start = (float) $sec + (float) $usec;

        $jdbor=simplexml_load_file($fileXML);
        $conta = 0;

        foreach ($jdbor->DisorderList as $disorders ){

            $count = 0;
            foreach ($disorders as $disorder) {

                $conta = $conta + 1;

                echo "RarasNumber: " . $conta . "<br>";
                echo "OrphaNumber: " .$disorder->OrphaNumber. "<br>";
                echo "Nome da desordem: ". $disorder->Name."<br>";

                $existDisorder = Disorder::where('orphanumber',$disorder->OrphaNumber)->first();

                if ($existDisorder){
                    echo "<br>Sinais =>>> Frequência <br>";
                    foreach ($disorder->DisorderSignList->DisorderSign as $signs) {
                        echo  $signs->ClinicalSign->Name ." =>>> ".  $signs->SignFreq->Name ."<br>";


                        $existSign = Sign::where([
                            ['name',$signs->ClinicalSign->Name],
                            ['frequency',$signs->SignFreq->Name]
                        ])->first();


                        $newSign = new Sign();

                        if (!$existSign){
                            $newSign->name = $signs->ClinicalSign->Name ;
                            $newSign->frequency = $signs->SignFreq->Name ;
                            $newSign->save();
                        }else {
                            $newSign->id = $existSign->id;
                        }

                        $newDisorderSign = new DisorderSign();
                        $newDisorderSign->disorder_id = $existDisorder->id;
                        $newDisorderSign->sign_id = $newSign->id;

                        $newDisorderSign->save();

                    }
                }else {

                    $newDisorder = new Disorder();

                    $newDisorder->name = $disorder->Name;
                    $newDisorder->orphanumber = $disorder->OrphaNumber;
                    $newDisorder->save();

                    echo " <h3><strong>".'Doença Não encontrada no XML de Disorder'. "</strong></h3>";

                    echo $count++;

                    $badDisorder .= $count . ")\t" .$disorder->OrphaNumber . "\t\t\t" . $disorder->Name . PHP_EOL;


                }
                echo "<hr>";


                set_time_limit(60);

            }

        }


        $badDisorderFile = "Bad_Disorder.txt";
        $f = fopen($badDisorderFile, 'w');
        fwrite($f, $badDisorder);
        fclose($f);

        list($usec, $sec) = explode(' ', microtime());
        $script_end = (float) $sec + (float) $usec;
        $elapsed_time = round($script_end - $script_start, 5);

        echo 'Tempo de execução ===>>> ', $elapsed_time/60, ' min'. '<br>' .
            'Memória Utilizada ===>>> ', round(((memory_get_peak_usage(true) / 1024) / 1024), 2), 'Mb'.'<br>' .
            'Total de Doenças não encontradas no XML Disorder: ' .$count;
    }

    public function genes()
    {
        $fileName = date('Ym').'-'.'Genes'.'.xml' ;
        $fileXML = public_path("xml\\" . $fileName);



        if (!file_exists($fileXML)) {
            echo "O arquivo $fileXML não existe" . "<br>";
            echo "Fazendo Download do arquivo XML diretamente da Orphadata"  . "<br>";
            file_put_contents($fileXML, file_get_contents('http://www.orphadata.org/data/xml/en_product6.xml'));
            echo "<hr>";
        }


        $jdbor=simplexml_load_file(public_path("xml/genes.xml"));
        $conta = 0;
        foreach ($jdbor->DisorderList as $disorders ){

            foreach ($disorders as $disorder) {

                $conta = $conta + 1;

                echo "RarasNumber: " . $conta . "<br>";
                echo "OrphaNumber: " .$disorder->OrphaNumber. "<br>";
                echo "Nome da desordem: ". $disorder->Name."<br>";

                echo "<br>GeneList <br>";

                foreach ($disorder->GeneList as $genelist) {



                    foreach ($genelist->Gene->SynonymList->Synonym as $sinonym ) {
                        echo  "Synonym: ". $sinonym ." <BR> ";
                    }

                    echo  "GeneType: " . $genelist->Gene->GeneType->Name ."<br>";
                    echo  "GeneLocus: " . $genelist->Gene->LocusList->Locus->GeneLocus ."<br>";
                    echo  "LocusKey: " . $genelist->Gene->LocusList->Locus->LocusKey ."<br>";
                }

                foreach ($disorder->DisorderGeneAssociationList as $geneAssociationList){

                    echo "Gene Name: " .$geneAssociationList->DisorderGeneAssociation->Gene->Name . "<br>";
                    echo "Gene Symbol: " .$geneAssociationList->DisorderGeneAssociation->Gene->Symbol . "<br>";

                }

                foreach ($geneAssociationList->DisorderGeneAssociation->Gene->ExternalReferenceList->ExternalReference as
                         $externalReference) {

                    echo "External Reference Source: " . $externalReference->Source . "<br>";
                    echo "External Reference: " . $externalReference->Reference . "<br>";
                }

                echo "Gene Association Type: " . $geneAssociationList->DisorderGeneAssociation
                        ->DisorderGeneAssociationType->Name . "<br>";
                echo "Gene Association Status: " . $geneAssociationList->DisorderGeneAssociation
                        ->DisorderGeneAssociationStatus->Name . "<br>";

                echo "<hr>";

            }

        }
    }

    public function protocols()
    {
        $disorders = Disorder::orderBy('orphanumber')->get();
        $count = 0;
        foreach ($disorders as $disorder)
        {


            $filePDF = public_path().'\protocols\\'.$disorder->orphanumber.".pdf";

            if (file_exists($filePDF)) {

                $portaria = AuxProtocols::where([
                    ['orphanumber', $disorder->orphanumber],
                ])->first();

                $protocols = new Protocol();
                echo "O arquivo $filePDF existe" . "<br>";
                $protocols->document = $portaria->protocolo;
                $protocols->name_pdf = $disorder->orphanumber.".pdf";
                $protocols->disorder_id = $disorder->id;
                $protocols->save();

                echo $count++ . "<br>";

                echo "<hr>";
            }

        }
    }

    public function disEsp()
    {
        $doencas = Disorder::all();
        $count = 0;

        foreach ($doencas as $doenca) {


            $auxDisEsp = AuxDisEsp::where('orphanumber', $doenca->orphanumber)->first();
            if ($auxDisEsp){

                $especialidade = Specialty::where('cbo', $auxDisEsp->cbo1)->first();

                $disEsp = new DisorderSpecialty();
                $disEsp->disorder_id = $doenca->id;
                $disEsp->specialty_id = $especialidade->id;
                $disEsp->save();

                echo "No.: ".$count++." - Salvando orphanumber: " . $doenca->orphanumber . " Name: " . $especialidade->name;

                if ($auxDisEsp->cbo2) {

                    $especialidade = Specialty::where('cbo', $auxDisEsp->cbo2)->first();

//                    dd($especialidade);
                    $disEsp = new DisorderSpecialty();
                    $disEsp->disorder_id = $doenca->id;
                    $disEsp->specialty_id = $especialidade->id;
                    $disEsp->save();

                    echo "No.: ".$count++." - Salvando orphanumber: " . $doenca->orphanumber . " Name: " . $especialidade->name;

                    if ($auxDisEsp->cbo3) {
                        $especialidade = Specialty::where('cbo', $auxDisEsp->cbo3)->first();

                        $disEsp = new DisorderSpecialty();
                        $disEsp->disorder_id = $doenca->id;
                        $disEsp->specialty_id = $especialidade->id;
                        $disEsp->save();

                        echo "No.: ".$count++." - Salvando orphanumber: " . $doenca->orphanumber . " Name: " . $especialidade->name;

                        if ($auxDisEsp->cbo4) {
                            $especialidade = Specialty::where('cbo', $auxDisEsp->cbo4)->first();

                            $disEsp = new DisorderSpecialty();
                            $disEsp->disorder_id = $doenca->id;
                            $disEsp->specialty_id = $especialidade->id;
                            $disEsp->save();

                            echo "No.: ".$count++." - Salvando orphanumber: " . $doenca->orphanumber . " Name: " . $especialidade->name;
                        }
                    }
                }
            }
        }
    }
}
