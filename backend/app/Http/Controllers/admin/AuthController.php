<?php
/*****************************************************/
# Page/Class name   : AuthController
# Purpose           : Admin Login Management
/*****************************************************/
namespace App\Http\Controllers\admin;

use App;
use App\Http\Controllers\Controller;
use App\Model\User;
use Auth;
use Illuminate\Http\Request;
use Redirect;
use Validator;
use AdminHelper;
use View;

class AuthController extends Controller
{
    /*****************************************************/
    # Function name : login
    # Params        : Request $request
    /*****************************************************/
    public function login(Request $request)
    {
        $data['pageTitle']  = trans('custom_admin.label_login');
        $data['panelTitle'] = trans('custom_admin.label_login');

        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        } else {
            try // Try block of try-catch exception starts
            {
                if ($request->isMethod('POST')) {
                    $validationCondition = array(
                        'email'     => 'required|regex:'.AdminHelper::VALID_EMAIL_REGEX,
                        'password'  => 'required',
                    );
                    $validationMessages = array(
                        'email.required'    => trans('custom_admin.error_enter_email'),
                        'email.regex'       => trans('custom_admin.error_enter_valid_email'),
                        'password.required' => trans('custom_admin.error_enter_password'),
                    );
                    $Validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                    if ($Validator->fails()) {
                        $validationFailedMessages = AdminHelper::validationMessageBeautifier($Validator->messages()->getMessages());                        
                        
                        $this->generateToastMessage('error', $validationFailedMessages, false);
                        return redirect()->route('admin.login')->withInput();

                    } else {
                        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'SA', 'status' => '1'])) {
                            if (Auth::guard('admin')->user()->checkRolePermission == null) {
                                Auth::guard('admin')->logout();

                                $this->generateToastMessage('error', trans('custom_admin.error_permission_denied'), false);
                                return redirect()->route('admin.login')->withInput();

                            } else {
                                $user  = \Auth::guard('admin')->user();
                                $user->lastlogintime = strtotime(date('Y-m-d H:i:s'));
                                $user->save();
                                return redirect()->route('admin.dashboard');
                            }
                        } else if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'A', 'status' => '1'])) {
                            $user  = \Auth::guard('admin')->user();
                            $user->lastlogintime = strtotime(date('Y-m-d H:i:s'));
                            $user->save();
                            return redirect()->route('admin.dashboard');                            
                        } else {
                            $this->generateToastMessage('error', trans('custom_admin.error_invalid_credentials_inactive_user'), false);
                            return redirect()->route('admin.login')->withInput();
                        }
                    }
                }
                // If admin is not logged in, show the login form //
                return view('admin.auth.login', $data);

            } catch (Exception $e) {
                $this->generateToastMessage('error', trans('custom_admin.error_invalid_credentials'), false);
                return redirect()->route('admin.login')->withInput();
            } catch (\Throwable $e) {
                // $e->getMessage()
                $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
                return redirect()->route('admin.login')->withInput();
            }
        }
    }

    /*****************************************************/
    # Function name : logout
    # Params        : Request $request
    /*****************************************************/
    public function logout()
    {
        if (Auth::guard('admin')->logout()) {
            return redirect()->route('admin.login'); // if logout is successful, proceed to login page
        } else {
            return redirect()->route('admin.dashboard'); // if logout fails, redirect tyo dashboard
        }
    }

    /*****************************************************/
    # Function name : forgetPassword
    # Params        : Request $request
    /*****************************************************/
    public function forgetPassword(Request $request)
    {
        $data['pageTitle']  = trans('custom_admin.label_forgot_password_title');
        $data['panelTitle'] = trans('custom_admin.label_forgot_password_title');

        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        } else {
            try // Try block of try-catch exception starts
            {
                if ($request->isMethod('POST')) {
                    $validationCondition = array(
                        'email'     => 'required|regex:'.AdminHelper::VALID_EMAIL_REGEX,
                    );
                    $validationMessages = array(
                        'email.required'    => trans('custom_admin.error_enter_email'),
                        'email.regex'       => trans('custom_admin.error_enter_valid_email'),
                    );
                    $Validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                    if ($Validator->fails()) {
                        $validationFailedMessages = AdminHelper::validationMessageBeautifier($Validator->messages()->getMessages());                        
                        
                        $this->generateToastMessage('error', $validationFailedMessages, false);
                        return redirect()->route('admin.login')->withInput();

                    } else {
                        $user = User::where(['email' => $request->email, 'status' => '1'])->first();
                        if ($user) {
                            if ($user->type == 'SA') {
                                $encryptedString = AdminHelper::customEncryptionDecryption($user->id.'~'.$user->email);
                                $user->auth_token = $encryptedString;
                                if ($user->save()) {
                                    $siteSetting = AdminHelper::getSiteSettings();                                    
                                    // Mail
                                    \Mail::send('emails.admin.reset_password_link',
                                    [
                                        'user'              => $user,
                                        'encryptedString'   => $encryptedString,
                                        'siteSetting'       => $siteSetting,
                                    ], function ($m) use ($user, $siteSetting) {
                                        $m->from($siteSetting->from_email, $siteSetting->website_title);
                                        $m->to($user->email, $user->full_name)->subject('Reset Password Link - '.$siteSetting->website_title);
                                    });                                    
                                    $this->generateToastMessage('success', trans('custom_admin.message_reset_password_text'), false);
                                    return redirect()->route('admin.forget-password')->withInput();
                                }
                            } else {
                                $this->generateToastMessage('error', trans('custom_admin.error_sufficient_permission'), false);
                                return redirect()->route('admin.forget-password')->withInput();
                            }
                        } else {
                            $this->generateToastMessage('error', trans('custom_admin.error_not_registered_with_us'), false);
                            return redirect()->route('admin.forget-password')->withInput();
                        }
                    }
                }
                return view('admin.auth.forget_password', $data);

            } catch (Exception $e) {
                $this->generateToastMessage('error', trans('custom_admin.error_invalid_credentials'), false);
                return redirect()->route('admin.login')->withInput();
            } catch (\Throwable $e) {
                // $e->getMessage()
                $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
                return redirect()->route('admin.login')->withInput();
            }
        }
    }

    /*****************************************************/
    # Function name : resetPassword
    # Params        : Request $request, $token = null
    /*****************************************************/
    public function resetPassword(Request $request, $token = null)
    {
        $data['pageTitle']  = trans('custom_admin.label_reset_password');
        $data['panelTitle'] = trans('custom_admin.label_reset_password');

        try {
            if (Auth::guard('admin')->check()) {
                return redirect()->route('admin.dashboard');
            }

            if ($token == null) {
                return redirect()->route('admin.login');
                $this->generateToastMessage('error', trans('custom_admin.error_invalid_url'), false);
            }
            
            $data['token'] = $token;

            if ($request->isMethod('POST')) {
                $validationCondition = array(
                    'password'          => 'required|regex:'.AdminHelper::VALID_PASSWORD_REGEX,
                    'confirm_password'  => 'required|regex:'.AdminHelper::VALID_PASSWORD_REGEX.'|same:password',
                ); 
                $validationMessages = array(
                    'password.required'         => trans('custom_admin.error_enter_password'),
                    'password.regex'            => trans('custom_admin.error_enter_password_regex'),
                    'confirm_password.required' => trans('custom_admin.error_enter_confirm_password'),
                    'confirm_password.regex'    => trans('custom_admin.error_enter_password_regex'),
                    'confirm_password.same'     => trans('custom_admin.error_same_password'),
                );

                $validator = \Validator::make($request->all(), $validationCondition,$validationMessages);
                if ($validator->fails()) {
                    $validationFailedMessages = AdminHelper::validationMessageBeautifier($validator->messages()->getMessages());                        
                        
                    $this->generateToastMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
                } else {
                    if ($token) {
                        $decryptToken = AdminHelper::customEncryptionDecryption($token, 'decrypt');
                        $explodedToken = explode('~',$decryptToken);
                        $checkingUserData = User::where(['id' => $explodedToken[0], 'email' => $explodedToken[1], 'auth_token' => $token, 'type' => 'SA'])->whereNotNull('auth_token')->first();
                        if ($checkingUserData != null) {
                            $checkingUserData->password = $request->password;
                            $checkingUserData->auth_token = null;
                            if ($checkingUserData->save()) {
                                $this->generateToastMessage('success', trans('custom_admin.message_password_changed_success'), false);
                                return redirect()->route('admin.login')->withInput();
                            }
                        } else {
                            $this->generateToastMessage('error', trans('custom_admin.error_invalid_url'), false);
                            return redirect()->back()->withInput();
                        }
                    } else {
                        abort(404);
                    }
                }
            }            
            return view('admin.auth.reset_password', $data);

        } catch (Exception $e) {
            $this->generateToastMessage('error', trans('custom.error_please_try_again'), false);
            return redirect()->route('admin.login');
        } catch (\Throwable $e) {
            $this->generateToastMessage('error', $e->getMessage(), false);
            return redirect()->route('admin.login');
        }
    }
    
}