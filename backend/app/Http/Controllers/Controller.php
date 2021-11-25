<?php
/*****************************************************/
# Controller
# Purpose           :
/*****************************************************/

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller as BaseController;
use \Auth;
use AdminHelper;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $currentLang;
    private $setLang;

    public function __construct(Request $request)
    {
        $segmentValue = $request->segment(1);
        if ($segmentValue) {
            if (in_array($segmentValue, AdminHelper::WEBSITE_LANGUAGES)) {
                Session::put('websiteLang', '');
                Session::put('websiteLang', $segmentValue);
                \App::setLocale($segmentValue);
            } else {
                Session::put('websiteLang', '');
                Session::put('websiteLang', \App::getLocale());
                \App::setLocale(\App::getLocale());
            }
        }
    }

    /*****************************************************/
    # Function name : generateToastMessage
    # Params        :
    /*****************************************************/
    public function generateToastMessage($type, $validationFailedMessages, $extraTitle = false) {
        switch($type)
        {
            case 'success':
                if (!$extraTitle) {
                    $extraTitle = trans('custom_admin.message_success');
                }
                toastr()->success($validationFailedMessages, $extraTitle.'!');
                break;
            case 'warning':
                if (!$extraTitle) {
                    $extraTitle = trans('custom_admin.message_warning');
                }
                toastr()->warning($validationFailedMessages, $extraTitle.'!');
                break;
            case 'error':
                if (!$extraTitle) {
                    $extraTitle = trans('custom_admin.message_error');
                }
                toastr()->error($validationFailedMessages, $extraTitle.'!');
                break;
            default:
                if (!$extraTitle) {
                    $extraTitle = trans('custom_admin.message_info');
                }
                toastr()->info($validationFailedMessages, $extraTitle.'!');
        }
    }

    /*****************************************************/
    # Function name : getRandomPassword
    # Params        :
    /*****************************************************/
    public function getRandomPassword($stringLength = 8) {
        $capitalRandom = substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVWXYZ", 2)), 0, 2);
        $smallRandom   = substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 3)), 0, 3);
        $specailRandom = substr(str_shuffle(str_repeat("!@#$%^&*", 1)), 0, 1);
        $numberRandom  = substr(str_shuffle(str_repeat("0123456789", 1)), 0, 2);
        
        $randonString = $capitalRandom.$smallRandom.$specailRandom.$numberRandom;

        return $randonString;
    }

}
