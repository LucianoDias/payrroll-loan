<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\ApiHelp\ApiError;
use App\ApiHelp\ApiFunctionHelp;

class InstitutionsController extends Controller
{
    protected $institutions;

    public function __construct() {
        $archive = File::get(database_path().'/dbJson/instituicoes.json');
        $this->institutions = json_decode(trim($archive));
    }

//method fetch all institutions
    public function all() {

        if(!$this->institutions){
            $msg = "No institutions found !";
            return  response()->json(ApiError::errorMessage($msg ,4040), 404);
        }
        return response()->json(['data'=>$this->institutions]);
    }

//Method fetch one institution
    public function one($name) {

       $institution = ApiFunctionHelp::selectName($this->institutions ,$name);

       if(!$institution){
            $msg = 'there is no data related to this instuitition !';
            return  response()->json(ApiError::errorMessage($msg ,4040),404);
       }
       $data = ['data' => $institution];
       return response()->json($data); 
    }

}
