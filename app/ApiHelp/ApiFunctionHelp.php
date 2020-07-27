<?php 
namespace App\ApiHelp;

class ApiFunctionHelp 
{
    public static function  selectName($array ,$name) {
        $name = strtoupper($name);
        foreach( $array as $item){

            if($item->chave == $name ){
                $data = ['chave' => $item->chave,'valor' => $item->valor];
                return $data;
            }
        }  
    }
}