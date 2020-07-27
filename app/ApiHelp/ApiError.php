<?php 
namespace App\ApiHelp;

class ApiError 
{
    public static function  errorMessage($message ,$code) {
        
        return [
            'data' => [
                'msg' => $message,
                'code' =>$code
            ]
        ];
    }
}