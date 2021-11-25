<?php
/*****************************************************/
# Page/Class name   : AccountController
# Purpose           : Admin Account Management
/*****************************************************/
namespace App\Http\Controllers\admin;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Redirect;
use View;
use Image;
use App\Model\SiteSetting;
use App\Model\User;
use AdminHelper;

class AccountController extends Controller
{
    /*****************************************************/
    # Function name : dashboard
    # Purpose       : After login admin will see dashboard page
    /*****************************************************/
    public function dashboard()
    {
        $data['pageTitle']  = trans('custom_admin.label_dashboard');
        $data['panelTitle'] = trans('custom_admin.label_dashboard');

        $data['totalUser']  = User::where(['status' => '1','type' => 'C'])->whereNull('role_id')->whereNull('deleted_at')->count();
        
        return view('admin.account.dashboard', $data);
    }

    /*****************************************************/
    # Function name : editProfile
    # Params        : Request $request
    /*****************************************************/
    public function editProfile(Request $request)
    {
        $data['pageTitle'] = trans('custom_admin.label_edit_profile');
        $data['panelTitle'] = trans('custom_admin.label_edit_profile');

        try
        {
            $adminDetail        = Auth::guard('admin')->user();
            $data['adminDetail']= $adminDetail;

            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'full_name' => 'required|max:255',
                    'phone_no'  => 'required',
                );
                $validationMessages = array(
                    'full_name.required'    => trans('custom_admin.error_enter_full_name'),
                    'full_name.max'         => trans('custom_admin.error_maximum_character'),
                    'phone_no.required'     => trans('custom_admin.error_enter_phone_no'),
                );
                $Validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($Validator->fails()) {
                    $validationFailedMessages = AdminHelper::validationMessageBeautifier($Validator->messages()->getMessages());
                    $this->generateToastMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
                } else {
                    $updateAdminData = array(
                        'full_name' => $request->full_name,
                        'phone_no'  => $request->phone_no,
                    );
                    $saveAdminData = User::where('id', $adminDetail->id)->update($updateAdminData);
                    if ($saveAdminData) {
                        $this->generateToastMessage('success', trans('custom_admin.success_data_updated_successfully'), false);
                        return redirect()->back();
                    } else {
                        $this->generateToastMessage('error', trans('custom_admin.error_took_place_while_updating'), false);
                        return redirect()->back()->withInput();
                    }
                }
            }

            return view('admin.account.edit_profile', $data);
        } catch (Exception $e) {
            $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return redirect()->route('admin.dashboard');
        } catch (\Throwable $e) {
            $this->generateToastMessage('error', $e->getMessage(), false);
            return redirect()->route('admin.dashboard');
        }
    }

    /*****************************************************/
    # Function name : changePassword
    # Params        : Request $request
    /*****************************************************/
    public function changePassword(Request $request)
    {
        $data['pageTitle'] = trans('custom_admin.label_change_password');
        $data['panelTitle']= trans('custom_admin.label_change_password');

        try
        {
            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'current_password'  => 'required',
                    'password'          => 'required|regex:/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                    'confirm_password'  => 'required|regex:/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/|same:password',
                );
                $validationMessages = array(
                    'current_password.required' => trans('custom_admin.error_enter_current_password'),
                    'password.required'         => trans('custom_admin.error_enter_password'),
                    'password.regex'            => trans('custom_admin.error_enter_password_regex'),
                    'confirm_password.required' => trans('custom_admin.error_enter_confirm_password'),
                    'confirm_password.regex'    => trans('custom_admin.error_enter_password_regex'),
                    'confirm_password.same'     => trans('custom_admin.error_same_password'),
                );
                $Validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($Validator->fails()) {
                    $validationFailedMessages = AdminHelper::validationMessageBeautifier($Validator->messages()->getMessages());
                    $this->generateToastMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
                } else {
                    $adminDetail    = Auth::guard('admin')->user();
                    $user_id        = Auth::guard('admin')->user()->id;
                    $hashedPassword = $adminDetail->password;

                    // check if current password matches with the saved password
                    if (Hash::check($request->current_password, $hashedPassword)) {
                        $adminDetail->password = $request->password;
                        $updatePassword = $adminDetail->save();

                        if ($updatePassword) {
                            $this->generateToastMessage('success', trans('custom_admin.success_data_updated_successfully'), false);
                            Auth::guard('admin')->logout();
                        } else {
                            $this->generateToastMessage('error', trans('custom_admin.error_took_place_while_updating'), false);
                            return redirect()->back();
                        }
                    } else {
                        $this->generateToastMessage('error', trans('custom_admin.error_current_password'), false);
                        return redirect()->back();
                    }
                }
            }
            return view('admin.account.change_password', $data);
        } catch (Exception $e) {
            $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return redirect()->route('admin.dashboard');
        } catch (\Throwable $e) {
            $this->generateToastMessage('error', $e->getMessage(), false);
            return redirect()->route('admin.dashboard');
        }
    }

    /*****************************************************/
    # Function name : siteSettings
    # Params        : Request $request
    /*****************************************************/
    public function siteSettings(Request $request)
    {
        try
        {
            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'from_email'        => 'required|regex:'.AdminHelper::VALID_EMAIL_REGEX,
                    'to_email'          => 'required|regex:'.AdminHelper::VALID_EMAIL_REGEX,
                    'website_title'     => 'required|max:255',
                    'website_link'      => 'required',
                    'footer_text'       => 'required',
                    'copyright_text'    => 'required',
                );
                $validationMessages = array(
                    'from_email.required'       => trans('custom_admin.error_from_email'),
                    'from_email.regex'          => trans('custom_admin.error_valid_email'),
                    'to_email.required'         => trans('custom_admin.error_to_email'),
                    'to_email.regex'            => trans('custom_admin.error_valid_email'),
                    'website_title.required'    => trans('custom_admin.error_website_title'),
                    'website_title.max'         => trans('custom_admin.error_website_title_maximum'),
                    'website_link.required'     => trans('custom_admin.error_website_link'),
                    'footer_text.required'      => trans('custom_admin.error_footer_text'),
                    'copyright_text.required'   => trans('custom_admin.error_copyright_text'),
                );
                $Validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($Validator->fails()) {
                    $validationFailedMessages = AdminHelper::validationMessageBeautifier($Validator->messages()->getMessages());
                    $this->generateToastMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
                } else {                    
                    $siteSettings = SiteSetting::first();
                    if ($siteSettings == null) {
                        $newSiteSetting                     = new SiteSetting;
                        $newSiteSetting->from_email         = $request->from_email;
                        $newSiteSetting->to_email           = $request->to_email;
                        $newSiteSetting->website_title      = $request->website_title;
                        $newSiteSetting->website_link       = $request->website_link;
                        $newSiteSetting->facebook_link      = $request->facebook_link;
                        $newSiteSetting->linkedin_link      = $request->linkedin_link;
                        $newSiteSetting->youtube_link       = $request->youtube_link;
                        $newSiteSetting->googleplus_link    = $request->googleplus_link;
                        $newSiteSetting->twitter_link       = $request->twitter_link;
                        $newSiteSetting->rss_link           = $request->rss_link;
                        $newSiteSetting->pinterest_link     = $request->pinterest_link;
                        $newSiteSetting->instagram_link     = $request->instagram_link;
                        $newSiteSetting->dribbble_link      = $request->dribbble_link;
                        $newSiteSetting->tumblr_link        = $request->tumblr_link;
                        $newSiteSetting->address            = $request->address;
                        $newSiteSetting->phone_no           = $request->phone_no;
                        $newSiteSetting->footer_text        = $request->footer_text;
                        $newSiteSetting->copyright_text     = $request->copyright_text;
                        $newSiteSetting->tag_line           = $request->tag_line;
                        $newSiteSetting->learn_more_video_short_title = $request->learn_more_video_short_title;
                        $newSiteSetting->learn_more_video   = $request->learn_more_video;
                        $saveData = $newSiteSetting->save();
                        
                        if ($saveData) {
                            $this->generateToastMessage('success', trans('custom_admin.success_data_updated_successfully'), false);
                        } else {
                            $this->generateToastMessage('error', trans('custom_admin.error_took_place_while_updating'), false);
                        }
                        return redirect()->back();
                    } else {
                        $fileName = $siteSettings->footer_logo;
                        $image = $request->file('image');
                        if ($image != '') {
                            $validationConditionImage = array(
                                'image' =>  'dimensions:min_width='.AdminHelper::ADMIN_FOOTER_THUMB_IMAGE_WIDTH.', min_height='.AdminHelper::ADMIN_FOOTER_THUMB_IMAGE_HEIGHT,
                                'image' => 'mimes:jpeg,jpg,png,svg|max:'.AdminHelper::IMAGE_MAX_UPLOAD_SIZE,
                            );
                            $validationMessagesImage = array(
                                'image.dimensions'  => trans('custom_admin.error_image_width_height'),
                                'image.mimes'       => trans('custom_admin.error_image_types'),
                            );
                            $validatorImage = \Validator::make($request->all(), $validationConditionImage, $validationMessagesImage);
                            if ($validatorImage->fails()) {
                                $validationImageFailedMessages = AdminHelper::validationMessageBeautifier($validatorImage->messages()->getMessages());
                                $this->generateToastMessage('error', $validationImageFailedMessages, false);
                                return redirect()->back()->withInput();
                            }

                            $originalFileName = $image->getClientOriginalName();
                            $extension   = pathinfo($originalFileName, PATHINFO_EXTENSION);
                            $fileName    = 'footer_logo_'.strtotime(date('Y-m-d H:i:s')).'.'.$extension;
                            $imageResize = Image::make($image->getRealPath());
                            $imageResize->save(public_path('images/uploads/cms/' . $fileName));
                            $imageResize->resize(AdminHelper::ADMIN_FOOTER_THUMB_IMAGE_WIDTH, AdminHelper::ADMIN_FOOTER_THUMB_IMAGE_HEIGHT, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $imageResize->save(public_path('images/uploads/cms/thumbs/' . $fileName));
                            
                            $largeImage = public_path().'/images/uploads/cms/'.$siteSettings->footer_logo;
                            @unlink($largeImage);
                            $thumbImage = public_path().'/images/uploads/cms/thumbs/'.$siteSettings->footer_logo;
                            @unlink($thumbImage);
                        }

                        $fileNameLMV = $siteSettings->learn_more_video;
                        $imageLMV = $request->file('learn_more_video');
                        if ($imageLMV != '') {
                            $validationConditionLMV = array(
                                'learn_more_video'  => 'mimes:mp4,ogg,webm|max:'.AdminHelper::VIDEO_MAX_UPLOAD_SIZE,
                            );
                            $validationMessagesLMV = array(
                                'learn_more_video.mimes' => trans('custom_admin.error_learn_more_video'),
                            );
                            $validatorLMV = \Validator::make($request->all(), $validationConditionLMV, $validationMessagesLMV);
                            if ($validatorLMV->fails()) {
                                $validationImageFailedMessagesLMV = AdminHelper::validationMessageBeautifier($validatorLMV->messages()->getMessages());
                                $this->generateToastMessage('error', $validationImageFailedMessagesLMV, false);
                                return redirect()->back()->withInput();
                            }

                            $destinationPath = public_path().'/images/uploads/cms/';
                            $fileNameLMV = 'learn_more_video_'.strtotime(date('Y-m-d H:i:s')).".".$imageLMV->getClientOriginalExtension();
                            $imageLMV->move($destinationPath, $fileNameLMV);

                            $largeLMV = public_path().'/images/uploads/cms/'.$siteSettings->learn_more_video;
                            @unlink($largeLMV);
                        }

                        $updateData = array(
                            'from_email'        => $request->from_email,
                            'to_email'          => $request->to_email,
                            'website_title'     => $request->website_title,
                            'website_link'      => $request->website_link,
                            'facebook_link'     => $request->facebook_link,
                            'linkedin_link'     => $request->linkedin_link,
                            'youtube_link'      => $request->youtube_link,
                            'googleplus_link'   => $request->googleplus_link,
                            'twitter_link'      => $request->twitter_link,
                            'rss_link'          => $request->rss_link,
                            'pinterest_link'    => $request->pinterest_link,
                            'instagram_link'    => $request->instagram_link,
                            'dribbble_link'     => $request->dribbble_link,
                            'tumblr_link'       => $request->tumblr_link,
                            'address'           => $request->address,
                            'phone_no'          => $request->phone_no,
                            'footer_text'       => $request->footer_text,
                            'footer_logo'       => $fileName,
                            'copyright_text'    => $request->copyright_text,
                            'tag_line'          => $request->tag_line,
                            'learn_more_video_short_title' => $request->learn_more_video_short_title,
                            'learn_more_video'  => $fileNameLMV,
                        );
                        $save = SiteSetting::where('id', $siteSettings->id)->update($updateData);

                        $this->generateToastMessage('success', trans('custom_admin.success_data_updated_successfully'), false);
                        return redirect()->back();
                    }
                }
            }
            $data = [
                'pageTitle'                 => trans('custom_admin.label_site_settings'),
                'panelTitle'                => trans('custom_admin.label_site_settings'),
                'from_email'                => '',
                'to_email'                  => '',
                'website_title'             => '',
                'website_link'              => '',
                'facebook_link'             => '',
                'linkedin_link'             => '',
                'youtube_link'              => '',
                'googleplus_link'           => '',
                'twitter_link'              => '',
                'rss_link'                  => '',
                'pinterest_link'            => '',
                'instagram_link'            => '',
                'dribbble_link'             => '',
                'tumblr_link'               => '',
                'address'                   => '',
                'phone_no'                  => '',
                'footer_text'               => '',
                'copyright_text'            => '',
                'tag_line'                  => '',
                'learn_more_video_short_title' => '',
                'footer_logo'               => '',
                'learn_more_video'          => '',
            ];

            $siteSettings = SiteSetting::first();
            if ($siteSettings != null) {
                $data['from_email']         = $siteSettings->from_email;
                $data['to_email']           = $siteSettings->to_email;
                $data['website_title']      = $siteSettings->website_title;
                $data['website_link']       = $siteSettings->website_link;
                $data['facebook_link']      = $siteSettings->facebook_link;
                $data['linkedin_link']      = $siteSettings->linkedin_link;
                $data['youtube_link']       = $siteSettings->youtube_link;
                $data['googleplus_link']    = $siteSettings->googleplus_link;
                $data['twitter_link']       = $siteSettings->twitter_link;
                $data['rss_link']           = $siteSettings->rss_link;
                $data['pinterest_link']     = $siteSettings->pinterest_link;
                $data['instagram_link']     = $siteSettings->instagram_link;
                $data['dribbble_link']      = $siteSettings->dribbble_link;
                $data['tumblr_link']        = $siteSettings->tumblr_link;
                $data['address']            = $siteSettings->address;
                $data['phone_no']           = $siteSettings->phone_no;
                $data['footer_text']        = $siteSettings->footer_text;
                $data['copyright_text']     = $siteSettings->copyright_text;
                $data['tag_line']           = $siteSettings->tag_line;
                $data['learn_more_video_short_title'] = $siteSettings->learn_more_video_short_title;
                $data['footer_logo']        = $siteSettings->footer_logo;
                $data['learn_more_video']   = $siteSettings->learn_more_video;
            }
            
            return view('admin.account.site_settings', $data)->with(['siteSettings' => $siteSettings]);
        } catch (Exception $e) {
            return redirect()->route('admin.'.\App::getLocale().'.site-settings')->with('error', $e->getMessage());
        }
    }
}