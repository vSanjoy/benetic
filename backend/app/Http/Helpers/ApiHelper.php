<?php
/*****************************************************/
# Page/Class name : ApiHelper
/*****************************************************/
namespace App\Http\Helpers;
use Request;
use Helper;
use Illuminate\Http\Response;

class ApiHelper
{
    /*****************************************************/
    # Function name : generateResponseBody
    /*****************************************************/
    public static function generateResponseBody($code, $data, $responseStatus = true, $responseCode = null)
    {
        $result         = [];
        $collectedData  = [];
        $finalCode      = $code;

        $functionName   = null;
        
        if (strpos($code, '#') !== false) {
            $explodedCode   = explode('#',$code);
            $finalCode      = $explodedCode[0];
            $functionName   = $explodedCode[1];
        }

        $collectedData['code'] = $finalCode;
        if ($responseStatus) {
            $collectedData['status'] = Response::HTTP_OK;     // for success
        } else {
            $collectedData['status'] = $responseCode;     // for error
        }

        if (gettype($data) === 'string') {
            $collectedData['data'] = $data;
        } else if(gettype($data) === 'array' && array_key_exists('errors',$data)){
            $collectedData['data'] = implode(",",$data['errors']);
        }else {
            $collectedData['data'] = $data;
        }

        if ($functionName != null) {
            $result[$functionName] = $collectedData;
        } else {
            $result = $collectedData;
        }    

        return $result;
    }
    
    /*****************************************************/
    # Function name : replaceNulltoEmptyStringAndIntToString
    /*****************************************************/    
    public static function replaceNulltoEmptyStringAndIntToString($arr){
        array_walk_recursive($arr, function (&$item, $key) {
            $item = null === $item ? '' : $item;
            if($key != 'id'){
                $item = (gettype($item) == 'integer' || gettype($item) == 'double') ? (string)$item : $item;
            }
            $item = Helper::cleanString($item);
        });
        return $arr;
    }

}
