<?php
/*****************************************************/
# Page/Class name   : HomeController
/*****************************************************/
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiHelper;
use Illuminate\Http\Request;
use \Auth;
use Hash;
// use \Response;
use Illuminate\Http\Response;
use Helper;
use \Validator;
use App\Model\SiteSetting;
use App\Model\Cms;
use App\Model\Banner;
use App\Model\Logo;
use App\Model\BeneticTurn;
use App\Model\HowItWork;
use App\Model\Benefit;
use App\Model\User;
use App\Model\TeamMember;

class HomeController extends Controller
{
    /*****************************************************/
    # Function name : index
    # Params        : Request $request
    /*****************************************************/
    public function index()
    {
        return response()->json(ApiHelper::generateResponseBody('BE-0001#welcome', 'Api for Benetic'), Response::HTTP_OK);
    }

    /*****************************************************/
    # Function name : homePageDetails
    # Params        : 
    /*****************************************************/
    public function homePageDetails()
    {
        $data['cms_page']['image_source'] = 'cms/';
        
        $data['cms_page']['home_page'] = Cms::select('title','short_title','logo_short_title','short_description','description','image1')
                                        ->where('id', 1)
                                        ->first();
        $data['cms_page']['list'] = Cms::select('title','slug','short_description','home_widget_image')
                                        ->whereIn('id', [3,4,5])
                                        ->get();

        $data['banner']['image_source'] = 'banner/';
        $data['banner']['list'] = Banner::select('title','short_description','image')
                                        ->where(['status' => '1'])
                                        ->whereNull('deleted_at')
                                        ->orderBy('sort','ASC')
                                        ->get();
        $data['logo']['image_source'] = 'logo/';
        $data['logo']['list'] = Logo::select('title','image')
                                    ->where(['status' => '1'])
                                    ->whereNull('deleted_at')
                                    ->orderBy('sort','ASC')
                                    ->get();
        $data['benetic_turn']['image_source'] = 'benetic_turn/';
        $data['benetic_turn']['list'] = BeneticTurn::select('title','image')
                                                    ->where(['status' => '1'])
                                                    ->whereNull('deleted_at')
                                                    ->orderBy('sort','ASC')
                                                    ->take(4)
                                                    ->get();
        
        return response()->json(ApiHelper::generateResponseBody('BE-0002#home_page_details', $data, true), Response::HTTP_OK);
    }

    /*****************************************************/
    # Function name : platformPageDetails
    # Params        : 
    /*****************************************************/
    public function platformPageDetails()
    {
        $data['cms_page']['page'] = Cms::select('title','short_title','short_description','description','banner_title','banner_short_title',
                                            'banner_short_description','banner_image','image1')
                                        ->where('id', 2)
                                        ->first();
        
        $data['how_it_work']['image_source'] = 'how_it_work/';
        $data['how_it_work']['list'] = HowItWork::select('title','image')
                                                    ->where(['status' => '1'])
                                                    ->whereNull('deleted_at')
                                                    ->orderBy('sort','ASC')
                                                    ->take(4)
                                                    ->get();
        
        return response()->json(ApiHelper::generateResponseBody('BE-0003#platform_page_details', $data, true), Response::HTTP_OK);
    }

    /*****************************************************/
    # Function name : advisorsPageDetails
    # Params        : 
    /*****************************************************/
    public function advisorsPageDetails()
    {
        $data['cms_page']['image_source'] = 'cms/';
        $data['cms_page']['page'] = Cms::select('title','short_title','short_description','description','banner_title','banner_short_title',
                                            'banner_short_description','banner_image','image1')
                                        ->where('id', 3)
                                        ->first();
        $data['benefit']['image_source'] = 'benefit/';
        $data['benefit']['list'] = Benefit::select('title','image')
                                            ->where(['cms_page_id' => 3, 'status' => '1'])
                                            ->whereNull('deleted_at')
                                            ->orderBy('sort','ASC')
                                            ->get();
        $data['proposal_generation']['page'] = Cms::select('title','short_title','short_description','description','image1')
                                                    ->where('id', 6)
                                                    ->first();
        
        return response()->json(ApiHelper::generateResponseBody('BE-0004#advisors_page_details', $data, true), Response::HTTP_OK);
    }

    /*****************************************************/
    # Function name : recordkeeperPageDetails
    # Params        : 
    /*****************************************************/
    public function recordkeeperPageDetails()
    {
        $data['cms_page']['image_source'] = 'cms/';
        $data['cms_page']['page'] = Cms::select('title','short_title','short_description','description','banner_title','banner_short_title',
                                            'banner_short_description','banner_image','image1')
                                        ->where('id', 4)
                                        ->first();
        $data['benefit']['image_source'] = 'benefit/';
        $data['benefit']['list'] = Benefit::select('title','image')
                                            ->where(['cms_page_id' => 4, 'status' => '1'])
                                            ->whereNull('deleted_at')
                                            ->orderBy('sort','ASC')
                                            ->get();
        $data['online_storefront']['page'] = Cms::select('title','short_title','short_description','description','image1')
                                                    ->where('id', 7)
                                                    ->first();
        
        return response()->json(ApiHelper::generateResponseBody('BE-0005#recordkeeper_page_details', $data, true), Response::HTTP_OK);
    }

    /*****************************************************/
    # Function name : assetManagersPageDetails
    # Params        : 
    /*****************************************************/
    public function assetManagersPageDetails()
    {
        $data['cms_page']['image_source'] = 'cms/';
        $data['cms_page']['page'] = Cms::select('title','short_title','short_description','description','banner_title','banner_short_title',
                                            'banner_short_description','banner_image','image1')
                                        ->where('id', 5)
                                        ->first();
        $data['benefit']['image_source'] = 'benefit/';
        $data['benefit']['list'] = Benefit::select('title','image')
                                            ->where(['cms_page_id' => 5, 'status' => '1'])
                                            ->whereNull('deleted_at')
                                            ->orderBy('sort','ASC')
                                            ->get();
        $data['online_storefront']['page'] = Cms::select('title','short_title','short_description','description','image1')
                                                    ->where('id', 8)
                                                    ->first();
        
        return response()->json(ApiHelper::generateResponseBody('BE-0006#asset_managers_page_details', $data, true), Response::HTTP_OK);
    }

    /*****************************************************/
    # Function name : aboutPageDetails
    # Params        : 
    /*****************************************************/
    public function aboutPageDetails()
    {
        $data['cms_page']['image_source'] = 'cms/';
        $data['cms_page']['page'] = Cms::select('title','short_title','short_description','description','banner_title','banner_short_title',
                                            'banner_short_description','banner_image','image1')
                                        ->where('id', 9)
                                        ->first();
        $data['team_member']['image_source'] = 'team_member/thumbs/';
        $data['team_member']['list'] = TeamMember::select('name','designation','short_description','linkedin_link','image')
                                            ->where(['status' => '1'])
                                            ->whereNull('deleted_at')
                                            ->orderBy('sort','ASC')
                                            ->get();        
        
        return response()->json(ApiHelper::generateResponseBody('BE-0007#about_page_details', $data, true), Response::HTTP_OK);
    }

    /*****************************************************/
    # Function name : registration (Demo / Sign up)
    # Params        : 
    /*****************************************************/
    public function registration(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            $details                    = new User;
            $details->full_name = isset($request->name) ? trim($request->name,' ') : null;
            if (strpos($details->full_name, ' ') !== false) {
                $explodedName = explode(' ', $details->full_name);
                $details->first_name    = isset($explodedName[0]) ? $explodedName[0] : $details->full_name;
                $details->last_name     = isset($explodedName[1]) ? $explodedName[1] : null;
            } else {
                $details->first_name    = $details->full_name;
                $details->last_name     = null;
            }
            $details->email             = isset($request->email) ? trim($request->email,' ') : null;
            $details->password          = Hash::make($request->email);
            $details->type              = isset($request->type) ? trim($request->type,' ') : 'D';
            $details->status            = '1';
            if ($details->save()) {
                $responseCode = Response::HTTP_OK;
            } else {
                $responseCode = Response::HTTP_FORBIDDEN;
            }
            
        } else {
            $responseCode = Response::HTTP_FORBIDDEN;
        }       
        
        return response()->json(ApiHelper::generateResponseBody('BE-0008#capture_details', 'Registration', true), $responseCode);
    }

    /*****************************************************/
    # Function name : footerDetails
    # Params        : 
    /*****************************************************/
    public function footerDetails()
    {
        $data['image_source'] = 'cms/';
        
        $data['site_settings'] = SiteSetting::where('id', 1)->first();

        return response()->json(ApiHelper::generateResponseBody('BE-0009#footer_details', $data, true), Response::HTTP_OK);
    }

}