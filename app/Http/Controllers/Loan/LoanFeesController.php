<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\ApiHelp\ApiError;
use App\ApiHelp\ApiFunctionHelp;

class LoanFeesController extends Controller
{
    protected $fees;
  
    public function __construct() {
        $fees = File::get(database_path().'/dbJson/taxas_instituicoes.json');
        $this->fees = json_decode(trim($fees)); 
    }

    public function show(Request $request) {

        $data = $request->all();
        $result = [];

        try{
            // checking if the loan field was informed
            if (!isset($data['loanValue'])) {
                $msg  =  'The field  is required ';
                return  response()->json(ApiError::errorMessage($msg ,4040));
            } 
            // Go through the institutions file when not informed
            if (!isset($data['institutions'])) {
                $institutions = json_decode(trim(File::get(database_path().'/dbJson/instituicoes.json')));
                foreach ($institutions as $institution) {
                    $data['institutions'][] = $institution->chave;
                }
            }
            // Go through the covenants file when not informed
            if (!isset($data['covenants'])) {
                $covenants = json_decode(trim(File::get(database_path().'/dbJson/convenios.json')));
                foreach ($covenants as $covenant) {
                    $data['covenants'][] = $covenant->chave;
                }
            }

            // Go through institutions to display data
            foreach($data['institutions'] as $institution){
                $fees_inst = array_filter($this->fees, function($obj) use ($institution) {
                    if($obj->instituicao == $institution)
                        return true;
                });
                // Search the rates to calculate
                foreach($fees_inst as $fee){
                    if(in_array($fee->convenio,$data['covenants'])){ 
                        if(isset($data['fee'])){
                            if($fee->parcelas == $data['fee']){ 
                                $result[$institution][] = [
                                    'taxa'=> $fee->taxaJuros,
                                    'parcelas'=> $fee->parcelas,
                                    'valor_parcela'=> number_format($data['loanValue'] * $fee->coeficiente,2),
                                    'convenio'=> $fee->convenio,
                                ];
                            }
                        }
                        else{
                            $result[$institution][] = [
                                'taxa'=> $fee->taxaJuros,
                                'parcelas'=> $fee->parcelas,
                                'valor_parcela'=>  number_format($data['loanValue'] * $fee->coeficiente,2),
                                'convenio'=> $fee->convenio,
                            ];
                        }  
                    }
                }
            }
            return $result;
        }catch(\Exception $e) {
            return response()->json(ApiError::errorMessage('There was an error in the call operation',1011), 500);
        }
   
    } 
}
