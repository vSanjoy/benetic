<?php
/*****************************************************/
# Page/Class name   : AdminHelper
# Purpose           : for global purpose
/*****************************************************/
namespace App\Http\Helpers;

use DateInterval;
use Auth;
use App\Model\Cms;
use App\Model\SiteSetting;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\NotificationHelper;
use Illuminate\Support\Str;

class AdminHelper
{
    public const NO_IMAGE = 'no-image.png'; // No image
    
    public const LOADER = 'loading.gif'; // Loading image

    public const WEBSITE_LANGUAGES = ['en']; // Admin language array
   
    public const IMAGE_MAX_UPLOAD_SIZE = 5120; // Image upload max size (5mb)
    
    public const ICON_MAX_UPLOAD_SIZE = 1024; // Image upload max size (1mb)

    public const IMAGE_CONTAINER = 300;  // image container

    public const ADMIN_BANNER_THUMB_IMAGE_WIDTH  = '100';   // Admin BANNER thumb image width

    public const ADMIN_BANNER_THUMB_IMAGE_HEIGHT = '100';   // Admin BANNER thumb image height

    public const ADMIN_LOGO_THUMB_IMAGE_WIDTH  = '100';   // Admin LOGO thumb image width

    public const ADMIN_LOGO_THUMB_IMAGE_HEIGHT = '100';   // Admin LOGO thumb image height

    public const ADMIN_FOOTER_THUMB_IMAGE_WIDTH  = '100';   // Admin FOOTER thumb image width

    public const ADMIN_FOOTER_THUMB_IMAGE_HEIGHT = '100';   // Admin FOOTER thumb image height

    public const ADMIN_TEAM_MEMBER_THUMB_IMAGE_WIDTH  = '490';   // Admin Team Member image width

    public const ADMIN_TEAM_MEMBER_THUMB_IMAGE_HEIGHT = '508';   // Admin Team Member image height

    public const UPLOADED_IMAGE_FILE_TYPES = ['jpeg', 'jpg', 'png', 'svg']; //Uploaded image file types

    public const CONFIRM_YES_BUTTON_COLOR = '#28a745';
    
    public const CANCEL_NO_BUTTON_COLOR = '#6c757d';

    public const VALID_EMAIL_REGEX = '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/';
    
    public const VALID_PASSWORD_REGEX = '/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
    
    public const POSITIVE_NUMBER_REGEX = '/^[0-9]+$/';

    public const VIDEO_MAX_UPLOAD_SIZE = 10240; // Image upload max size (10mb)

    
    /*****************************************************/
    # Function name : getAppName
    # Params        :
    /*****************************************************/
    public static function getAppName()
    {
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
    # Function name : formattedDatefromTimestamp
    # Params        : $getDateTime = unix timestamp
    /*****************************************************/
    public static function formattedDatefromTimestamp($getDateTime = null)
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
    # Function name : getData
    # Params        :
    /*****************************************************/
    public static function getData($table = 'SiteSetting', $where = '')
    {
        if ($table == 'cms') {
            $metaData = Cms::where('id', $where)->first();
        } else {
            $metaData = SiteSetting::first();
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
    # Purpose       : Format data to 2 decimal places
    # Params        : $data
    /*****************************************************/
    public static function formatToTwoDecimalPlaces($data) {
        return number_format((float)$data, 2, '.', '');
    }

    /*****************************************************/
    # Function name : paginationMessage
    # Purpose       : Format data to 2 decimal places
    # Params        : $data = null
    /*****************************************************/
    public static function paginationMessage($data = null) {
        return 'Records '.$data->firstItem().' - '.$data->lastItem().' of '.$data->total();
    }

    /*****************************************************/
    # Function name : getUserRoleSpecificRoutes
    # Params        : 
    /*****************************************************/
    public static function getUserRoleSpecificRoutes() {
        $existingRoutes = [];
        $userExistingRoles = \Auth::guard('admin')->user()->userRoles;
        if ($userExistingRoles) {
            foreach ($userExistingRoles as $role) {
                if ($role->rolePermissionToRolePage) {
                    foreach ($role->rolePermissionToRolePage as $permission) {
                        $existingRoutes[] = $permission['routeName'];
                    }
                }
            }
        }
        return $existingRoutes;
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
    # Function name : checkingAllowRouteToUser
    # Params        : $routeToCheck without admin. alias
    /*****************************************************/
    public static function checkingAllowRouteToUser($routePartToCheck = null) {
        $existingRoutes['is_super_admin']   = false;
        $existingRoutes['allow_routes']     = [];

        if (\Auth::guard('admin')->user()->id == 1 && \Auth::guard('admin')->user()->type == 'SA') {
            $existingRoutes['is_super_admin'] = true;
        } else {
            $userExistingRoles = \Auth::guard('admin')->user()->userRoles;
            if ($userExistingRoles) {
                foreach ($userExistingRoles as $role) {
                    if ($role->rolePermissionToRolePage) {
                        foreach ($role->rolePermissionToRolePage as $permission) {
                            if (strpos($permission['routeName'], $routePartToCheck) !== false) {
                                $existingRoutes['allow_routes'][] = $permission['routeName'];
                            }
                        }
                    }
                }
            }
        }

        return $existingRoutes;
    }

    /*****************************************************/
    # Function name : generateSortNumber
    # Params        : $model
    /*****************************************************/
    public static function generateSortNumber($model = null, $id = null)
    {
        if ($id != null) {
            $gettingLastSortedCount = $model::select('sort')->where('id','<>',$id)->whereNull('deleted_at')->orderBy('sort','desc')->first();
        } else {
            $gettingLastSortedCount = $model::select('sort')->whereNull('deleted_at')->orderBy('sort','desc')->first();
        }        
        $newSort = isset($gettingLastSortedCount->sort) ? ($gettingLastSortedCount->sort + 1) : 0;

        return $newSort;
    }
      
}
