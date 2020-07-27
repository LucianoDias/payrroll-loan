<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\ApiHelp\ApiError;
use App\ApiHelp\ApiFunctionHelp;

class CovenantsController extends Controller
{
    protected $covenants;

    public function __construct() {
        $archive = File::get(database_path().'/dbJson/convenios.json');
        $this->covenants = json_decode(trim($archive));
    }
    
   //method fetch all institutions
   public function all() {
       
        if(!$this->covenants){
            $msg = "There are no convents!";
            return  response()->json(ApiError::errorMessage($msg ,4040), 404);
        }
        return response()->json(['data'=>$this->covenants]); 
    }

    //Method fetch one institution
    public function one($name) {

        $covenant = ApiFunctionHelp::selectName($this->covenants ,$name);
 
        if(!$covenant){
             $msg = 'there is no data related to this convent !';
             return  response()->json(ApiError::errorMessage($msg ,4040),404);
        }
        $data = ['data' => $covenant];
        return response()->json($data); 
     }


}
