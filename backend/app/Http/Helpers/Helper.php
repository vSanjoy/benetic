<?php
/*****************************************************/
# Page/Class name   : Helper
# Purpose           : for global purpose
/*****************************************************/
namespace App\Http\Helpers;

use Auth;
use App\Model\Cms;
use App\Model\SiteSetting;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\NotificationHelper;
use Illuminate\Support\Str;

class Helper
{
    public const NO_IMAGE = 'no-image.png'; // No image

    public const WEBSITE_DEFAULT_LANGUAGE = 'en';

    public const WEBSITE_LANGUAGES = ['en', 'ar']; // Admin language array

    public const UPLOADED_DOC_FILE_TYPES = ['doc', 'docx', 'xls', 'xlsx', 'pdf', 'txt', 'ods', 'odp', 'odt']; //Uploaded document file types

    public const UPLOADED_IMAGE_FILE_TYPES = ['jpeg', 'jpg', 'png', 'svg']; //Uploaded image file types

    public const PROFILE_IMAGE_MAX_UPLOAD_SIZE = 5120; // profile image upload max size (5mb)

    public const PROFILE_IMAGE_THUMB_IMAGE_WIDTH  = '100';   // Profile thumb image width
    public const PROFILE_IMAGE_THUMB_IMAGE_HEIGHT = '100';   // Profile thumb image height

    public const VALID_EMAIL_REGEX = '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/';
    
    public const VALID_PASSWORD_REGEX = '/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';

    public const TOUR_HISTORY_LIST_LIMIT = '10';

    
    /*****************************************************/
    # Function name : getAppName
    # Params        :
    /*****************************************************/
    public static function getAppName()
    {
        //$getAppName = env('APP_NAME');
        $siteSettings = self::getSiteSettings();
        $appName = $siteSettings->website_title;
        return $appName;
    }

    /*****************************************************/
    # Function name : getAppNameFirstLetters
    # Params        :
    /*****************************************************/
    public static function getAppNameFirstLetters()
    {
        $siteSettings = self::getSiteSettings();
        $getAppName = $siteSettings->website_title;
        $explodedAppNamewords = explode(' ', $getAppName);
        $appLetters = '';
        foreach ($explodedAppNamewords as $letter) {
            $appLetters .= $letter[0];
        }
        return $appLetters;
    }

    /*****************************************************/
    # Function name : generateUniqueSlug
    # Params        : $model, $slug (name/title), $id
    /*****************************************************/
    public static function generateUniqueSlug($model, $slug, $id = null)
    {
        $slug = Str::slug($slug);
        $currentSlug = '';
        if ($id) {
            $currentSlug = $model->where('id', '=', $id)->value('slug');
        }

        if ($currentSlug && $currentSlug === $slug) {
            return $slug;
        } else {
            $slugList = $model->where('slug', 'LIKE', $slug . '%')->pluck('slug');
            if ($slugList->count() > 0) {
                $slugList = $slugList->toArray();
                if (!in_array($slug, $slugList)) {
                    return $slug;
                }
                $newSlug = '';
                for ($i = 1; $i <= count($slugList); $i++) {
                    $newSlug = $slug . '-' . $i;
                    if (!in_array($newSlug, $slugList)) {
                        return $newSlug;
                    }
                }
                return $newSlug;
            } else {
                return $slug;
            }
        }
    }

    /*****************************************************/
    # Function name : getSiteSettings
    # Params        :
    /*****************************************************/
    public static function getSiteSettings()
    {
        $siteSettingData = SiteSetting::first();
        return $siteSettingData;
    }

    /*****************************************************/
    # Function name : getBaseUrl
    # Params        :
    /*****************************************************/
    public static function getBaseUrl()
    {
        $baseUrl = url('/');
        return $baseUrl;
    }

    /*****************************************************/
    # Function name : getRolePermissionPages
    # Params        :
    /*****************************************************/
    public static function getRolePermissionPages()
    {
        $routePermissionArray = [];
        
        if (Auth::guard('admin')->user()->id != '') {
            if (Auth::guard('admin')->user()->role_id != 1) {
                $userRolePermission = Auth::guard('admin')->user()->allRolePermissionForUser;
                if (count($userRolePermission) > 0) {
                    foreach ($userRolePermission as $permission) {
                        if ($permission->page != null) {
                            $routePermissionArray[] = $permission->page->routeName;
                        }
                    }
                }
            }
        }
        return $routePermissionArray;
    }

    /*****************************************************/
    # Function name : formattedDate
    # Params        : $getDate
    /*****************************************************/
    public static function formattedDate($getDate = null)
    {
        $formattedDate = date('dS M, Y');
        if ($getDate != null) {
            $formattedDate = date('dS M, Y', strtotime($getDate));
        }
        return $formattedDate;
    }

    /*****************************************************/
    # Function name : formattedDateTime
    # Params        : $getDateTime = unix timestamp
    /*****************************************************/
    public static function formattedDateTime($getDateTime = null)
    {
        $formattedDateTime = '';
        if ($getDateTime != null) {
            $formattedDateTime = date('dS M, Y H:i', $getDateTime);
        }
        return $formattedDateTime;
    }

    /*****************************************************/
    # Function name : formattedDateFromTimestamp
    # Params        : $getDateTime = unix timestamp
    /*****************************************************/
    public static function formattedDateFromTimestamp($getDateTime = null)
    {
        $formattedDateTime = '';
        if ($getDateTime != null) {
            $formattedDateTime = date('dS M, Y', $getDateTime);
        }
        return $formattedDateTime;
    }

    /*****************************************************/
    # Function name : formattedTimestamp
    # Params        : $getDateTime = unix timestamp
    /*****************************************************/
    public static function formattedTimestamp($getDateTime = null)
    {
        $timestamp = '';
        if ($getDateTime != null) {
            $timestamp = \Carbon\Carbon::createFromFormat('m/d/Y', $getDateTime)->timestamp;
        }
        return $timestamp;
    }

    /*****************************************************/
    # Function name : formattedTimestampBid
    # Params        : $getDateTime = unix timestamp
    /*****************************************************/
    public static function formattedTimestampBid($getDateTime = null)
    {
        $timestamp = '';
        if ($getDateTime != null) {
            $timestamp = date('Y-m-d H:i:s', $getDateTime);
        }
        return $timestamp;
    }

    /*****************************************************/
    # Function name : differnceBtnTimestampDateFrmCurrentDateInDays
    # Params        : $getDate = null
    /*****************************************************/
    public static function differnceBtnTimestampDateFrmCurrentDateInDays($getDate = null)
    {
        $days = '';
        if ($getDate != null) {
            $currentDate = date('Y-m-d');
            $diff   = abs($getDate - strtotime($currentDate));
            $years  = floor($diff / (365*60*60*24)); 
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
            $days   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

            if ($getDate < strtotime($currentDate)) {
                $days = '-'.$days;
            } else {
                $days = '+'.$days;
            }

        }
        return $days;
    }

    /*****************************************************/
    # Function name : getData
    # Params        :
    /*****************************************************/
    public static function getData($table = 'SiteSetting', $where = '')
    {
        if ($table == 'cms') {
            $metaData = Cms::where('id', $where)->first();
        } else {
            $metaData = SiteSetting::first();
            $metaData['meta_title'] = $metaData['default_meta_title'];
            $metaData['meta_keyword'] = $metaData['default_meta_keyword'];
            $metaData['meta_description'] = $metaData['default_meta_description'];
        }
        return $metaData;
    }

    /*****************************************************/
    # Function name : customEncryptionDecryption
    # Params        :
    /*****************************************************/
    public static function customEncryptionDecryption($string, $action = 'encrypt')
    {
        $secretKey = 'c7tpe291z';
        $secretVal = 'GfY7r512';
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secretKey);
        $iv = substr(hash('sha256', $secretVal), 0, 16);

        if ($action == 'encrypt') {
            $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    /*****************************************************/
    # Function name : formatToTwoDecimalPlaces
    # Params        : $data
    /*****************************************************/
    public static function formatToTwoDecimalPlaces($data)
    {
        return number_format((float)$data, 2, '.', '');
    }

    /*****************************************************/
    # Function name : formatNumber
    # Params        : $data
    /*****************************************************/
    public static function formatNumber($data)
    {
        return number_format((float)$data);
    }
    
    /*****************************************************/
    # Function name : generateCsv
    # Params        : 
    /*****************************************************/
    public static function generateCsv($columnNames, $dataToPrint, $fileName) {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $fileName,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $callback = function() use ($columnNames, $dataToPrint ) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columnNames);
            foreach ($dataToPrint as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    /*****************************************************/
    # Function name : cleanString
    # Params        : $content
    /*****************************************************/
    public static function cleanString($content) {
        $content = preg_replace("/&#?[a-z0-9]+;/i","",$content); 
        $content = preg_replace("/[\n\r]/","",$content);
        $content = strip_tags($content);
        return $content;
    }

    /*****************************************************/
    # Function name : getMetaData
    # Params        :
    /*****************************************************/
    public static function getMetaData($table = 'SiteSetting', $where = '')
    {
        if ($table == 'cms') {
            $metaData = Cms::select('name', 'meta_keyword', 'meta_description')->where('slug', $where)->first();
            $return['title'] = $metaData['name'];
            $return['keyword'] = $metaData['meta_keyword'];
            $return['description'] = $metaData['meta_description'];
            return $return;
        } else {
            $metaData = SiteSetting::select('default_meta_title', 'default_meta_keywords', 'default_meta_description')->first();
            $return['title'] = $metaData['default_meta_title'];
            $return['keyword'] = $metaData['default_meta_keywords'];
            $return['description'] = $metaData['default_meta_description'];
            return $return;
        }
    }

    /*****************************************************/
    # Function name : validationMessageBeautifier
    # Params        : $errorMessageObject
    /*****************************************************/
    public static function validationMessageBeautifier($errorMessageObject) {
        $validationFailedMessages = '';
        foreach ($errorMessageObject as $fieldName => $messages) {
            foreach($messages as $message) {
                $validationFailedMessages .= $message.'<br>';
            }
        }
        return $validationFailedMessages;
    }

}
