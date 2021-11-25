<?php
/*****************************************************/
# Page/Class name   : SubAdminsController
/*****************************************************/
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Auth;
use Mail;
use Config;
use App\Model\Role;
use App\Model\User;
use App\Model\UserRole;
use DataTables;
use AdminHelper;

class SubAdminsController extends Controller
{
    /*****************************************************/
    # Function name : list
    # Params        : Request $request
    /*****************************************************/
    public function list(Request $request)
    {
        $data['pageTitle'] = trans('custom_admin.label_sub_admin_list');
        $data['panelTitle']= trans('custom_admin.label_sub_admin_list');

        try {
            $data['userDropdown'] = User::where('type','A')
                                        ->where('id','<>', '1')
                                        ->select('id','email','phone_no')
                                        ->orderBy('email', 'asc')
                                        ->get();
            $data['roleList'] = Role::where('id', '<>', '1')
                                        ->where("is_admin","1")
                                        ->select('id','name','slug','is_admin')
                                        ->get();

            // Start :: Manage restriction
            $data['isAllow'] = false;
            $restrictions   = AdminHelper::checkingAllowRouteToUser('subAdmin.');
            if ($restrictions['is_super_admin']) {
                $data['isAllow'] = true;
            }
            $data['allowedRoutes']  = $restrictions['allow_routes'];
            // End :: Manage restriction

            return view('admin.sub_admin.list', $data);
        } catch (Exception $e) {
            $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return redirect()->route('admin.dashboard');
        } catch (\Throwable $e) {
            $this->generateToastMessage('error', $e->getMessage(), false);
            return redirect()->route('admin.dashboard');
        }
    }

    /*****************************************************/
    # Function name : listRequest
    # Params        :
    /*****************************************************/
    public function listRequest(Request $request)
    {
        try {
            if ($request->ajax()) {

                $query = User::where('id','<>','1')->where(['type' => 'A'])->whereNull('deleted_at');

                // Search section
                $phoneNo    = isset($request->phone_no) ? $request->phone_no : '';
                $email      = isset($request->email) ? $request->email : '';
                $roleIds    = isset($request->roleIds) ? $request->roleIds : [];
                
                if ($phoneNo || $email || $roleIds) {
                    if ($phoneNo) {
                        $query->where(function ($subQuery) use ($phoneNo) {
                            $subQuery->where('phone_no', $phoneNo);
                        });
                    }
                    if ($email) {
                        $query->where(function ($subQuery) use ($email) {
                            $subQuery->where('email', 'LIKE', '%' . $email . '%');
                        });
                    }
                    if ($roleIds) {
                        $query->whereHas('userRoles' , function ($subQuery) use ($roleIds) {
                            $subQuery->whereIn('role_id', $roleIds);
                        });
                    }
                }
                $data = $query->get();

                // Start :: Manage restriction
                $isAllow = false;
                $restrictions   = AdminHelper::checkingAllowRouteToUser('subAdmin.');
                if ($restrictions['is_super_admin']) {
                    $isAllow = true;
                }
                $allowedRoutes  = $restrictions['allow_routes'];
                // End :: Manage restriction

                return Datatables::of($data, $isAllow, $allowedRoutes)
                        ->addIndexColumn()
                        ->addColumn('roles', function($row) {
                            $roles = '';
                            if ($row->userRoles) {
							    foreach ($row->userRoles as $role) {
								    $roles .= ' <span class="badge badge-info">'.$role->name.'</span>';
                                }
						    }
                            return $roles;
                        })
                        ->addColumn('status', function ($row) use ($isAllow, $allowedRoutes) {
                            if ($isAllow || in_array('subAdmin.change-status', $allowedRoutes)) {
                                if ($row->status == '1') {
                                    $status = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.AdminHelper::customEncryptionDecryption($row->id).'" data-action-type="inactive" class="custom_font status" title="'.trans('custom_admin.label_active').'"><span class="badge badge-success">'.trans('custom_admin.label_active').'</span></a>';
                                } else {
                                    $status = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.AdminHelper::customEncryptionDecryption($row->id).'" data-action-type="active" class="custom_font status" title="'.trans('custom_admin.label_inactive').'"><span class="badge badge-danger">'.trans('custom_admin.label_inactive').'</span></a>';
                                }
                            } else {
                                if ($row->status == '1') {
                                    $status = ' <a data-toggle="tooltip" class="custom_font" title="'.trans('custom_admin.label_active').'"><span class="badge badge-success">'.trans('custom_admin.label_active').'</span></a>';
                                } else {
                                    $status = ' <a data-toggle="tooltip" data-action-type="active" class="custom_font" title="'.trans('custom_admin.label_inactive').'"><span class="badge badge-danger">'.trans('custom_admin.label_inactive').'</span></a>';
                                }
                            }
                            return $status;
                        })
                        ->addColumn('action', function ($row) use ($isAllow, $allowedRoutes) {
                            $btn = '';
                            if ($isAllow || in_array('subAdmin.edit', $allowedRoutes)) {
                                $editLink = route('admin.subAdmin.edit', AdminHelper::customEncryptionDecryption($row->id));
                            
                                $btn .= '<a href="'.$editLink.'" data-toggle="tooltip" data-id="'.AdminHelper::customEncryptionDecryption($row->id).'" data-original-title="Edit" class="edit btn bg-info btn-sm" title="'.trans('custom_admin.label_edit').'"><i class="fas fa-edit"></i></a>';
                            }
                            if ($isAllow || in_array('subAdmin.delete', $allowedRoutes)) {
                                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.AdminHelper::customEncryptionDecryption($row->id).'" data-action-type="delete" class="btn bg-danger btn-sm delete" title="'.trans('custom_admin.label_delete').'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            }
                            return $btn;
                        })
                        ->rawColumns(['roles','status','action'])
                        ->make(true);
            }
          
            return view('admin.sub_admin.list');

        } catch (Exception $e) {
            return '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    /*****************************************************/
    # Function name : add
    # Params        :
    /*****************************************************/
    public function add(Request $request)
    {
        $data['pageTitle']  = trans('custom_admin.label_add_sub_admin');
        $data['panelTitle'] = trans('custom_admin.label_add_sub_admin');
    
        try
        {
            // Breadcrumb
            $data['breadcrumb'] = [
                                    'module_title' => trans('custom_admin.label_sub_admin_list'),
                                    'module_url' => 'admin.subAdmin.list'
                                ];

        	if ($request->isMethod('POST'))
        	{
				$validationCondition = array(
                    'first_name'    => 'required|max:255',
                    'last_name'     => 'required|max:255',
                    'email'         => 'required|regex:'.AdminHelper::VALID_EMAIL_REGEX,
				);
				$validationMessages = array(
                    'first_name.required'   => trans('custom_admin.error_first_name'),
					'first_name.max'        => trans('custom_admin.error_first_name_maximum'),
                    'last_name.required'    => trans('custom_admin.error_last_name'),
                    'last_name.max'         => trans('custom_admin.error_last_name_maximum'),
                    'email.required'        => trans('custom_admin.error_email'),
                    'email.regex'           => trans('custom_admin.error_email_valid'),
				);

				$Validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
				if ($Validator->fails()) {
					$validationFailedMessages = AdminHelper::validationMessageBeautifier($Validator->messages()->getMessages());
                    $this->generateToastMessage('error', $validationFailedMessages, false);
                    return redirect()->route('admin.subAdmin.add')->withInput();
				} else {
                    $validationFlag = false;
                    
                    // Unique Email validation for User type "Admin"
                    $userEmailExistCheck = User::where(['email' => $request->email, 'type' => 'A'])->count();
                    if ($userEmailExistCheck > 0) {
                        $validationFlag = true;
                    }
                    
                    if (!$validationFlag) {
                        $randomString = $this->getRandomPassword();
                        $password = $randomString;
                        $profileName = trim($request->first_name,' ').' '.trim($request->last_name,' ');
            
                        $userData               = new User;
                        $userData->first_name   = isset($request->first_name) ? trim($request->first_name,' ') : '';
                        $userData->last_name    = isset($request->last_name) ? trim($request->last_name,' ') : '';
                        $userData->full_name    = $profileName;
                        $userData->email        = isset($request->email) ? trim($request->email,' ') : '';
                        $userData->password     = $password;
                        $userData->phone_no     = isset($request->phone_no) ? $request->phone_no : '';
                        $userData->agree        = '1';
                        $userData->type         = 'A';
                        $userData->status       = '1';
                        $userData->save();
                        
                        if($userData->id) {
                            /*----------- Inserting data to user_roles table ----------*/
                            if ($request->role) {
                                foreach ($request->role as $valRole) {
                                    $userRoleData           = new UserRole;
                                    $userRoleData->user_id  = $userData->id;
                                    $userRoleData->role_id  = $valRole;
                                    $userRoleData->save();
                                }
                            }
                        }
                        
                        //============mail code start============//
                        $siteSetting = AdminHelper::getSiteSettings();

                        $userModel = User::findOrFail($userData->id);
                        $roleArray = [];
                        if (count($userModel->userRoles) > 0) {
                            foreach ($userModel->userRoles as $role) {
                                $roleArray[] = $role['name'];
                            }
                        }
        
                        // Email to created sub admin
                        // \Mail::send('email_templates.admin.sub_admin_user_create',
                        // [
                        //     'user'          => $userData,
                        //     'password'      => $password,
                        //     'siteSetting'   => $siteSetting,
                        //     'app_config'    => [
                        //         'appname'       => $siteSetting->website_title,
                        //         'appLink'       => AdminHelper::getBaseUrl(),
                        //         'controllerName'=> 'users',
                        //         'currentLang'=> $currentLang,
                        //     ],
                        // ], function ($m) use ($userData, $siteSetting) {
                        //     $m->to($userData->email, $userData->full_name)->subject('Sub Admin Registration - '.$siteSetting->website_title);
                        // });

                        // Mail to admin
                        // \Mail::send('email_templates.admin.sub_admin_user_create_to_super_admin',
                        // [
                        //     'user'          => $userData,
                        //     'password'      => $password,
                        //     'roleArray'     => $roleArray,
                        //     'siteSetting'   => $siteSetting,
                        //     'app_config'    => [
                        //         'appname'       => $siteSetting->website_title,
                        //         'appLink'       => AdminHelper::getBaseUrl(),
                        //         'controllerName'=> 'users',
                        //         'currentLang'=> $currentLang,
                        //     ],
                        // ], function ($m) use ($siteSetting) {
                        //     $m->to($siteSetting->to_email, $siteSetting->website_title)->subject('New Sub Admin Registration - '.$siteSetting->website_title);
                        // });
                        //============mail code end============//
                    
                        $this->generateToastMessage('success', trans('custom_admin.success_data_added_successfully'), false);
                        return redirect()->route('admin.subAdmin.list');
                    } else {
                        $this->generateToastMessage('error', trans('custom_admin.error_email_unique'), false);
                        return redirect()->back()->withInput();
                    }				
				}
            }
            $data['roleList'] = Role::where('id', '<>', '1')
                                    ->where("is_admin","1")
                                    ->select('id','name','slug','is_admin')
                                    ->get();
			return view('admin.sub_admin.add', $data);
		} catch (Exception $e) {
            $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return redirect()->route('admin.subAdmin.list');
        } catch (\Throwable $e) {
            $this->generateToastMessage('error', $e->getMessage(), false);
            return redirect()->route('admin.subAdmin.list');
        }
    }    

    /*****************************************************/
    # Function name : edit
    # Params        :
    /*****************************************************/
    public function edit(Request $request, $id = null)
    {
        $data['pageTitle'] = trans('custom_admin.label_edit_sub_admin');
        $data['panelTitle']= trans('custom_admin.label_edit_sub_admin');

        try
        {
            // Breadcrumb
            $data['breadcrumb'] = [
                                    'module_title' => trans('custom_admin.label_role_list'),
                                    'module_url' => 'admin.subAdmin.list'
                                ];

            $data['roleList'] = Role::where('id', '<>', '1')
                                    ->where("is_admin","1")
                                    ->select('id','name','slug','is_admin')
                                    ->get();
            $data['id']      = $id;
            $id              = AdminHelper::customEncryptionDecryption($id, 'decrypt');
            $data['details'] = $user = User::where(['id' => $id, 'type' => 'A'])->first();
            $roleIds = [];
            if ($data['details']->userRoles) {
                foreach ($data['details']->userRoles as $role) {
                    $roleIds[] = $role['id'];
                }
            }
            $data['roleIds'] = $roleIds;

            if ($request->isMethod('POST')) {
                if ($id == null) {
                    $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
                    return redirect()->route('admin.subAdmin.list');
                }               

                $validationCondition = array(
                    'first_name'    => 'required|max:255',
                    'last_name'     => 'required|max:255',
                    'email'         => 'required|regex:'.AdminHelper::VALID_EMAIL_REGEX,
                );
                $validationMessages = array(
                    'first_name.required'   => trans('custom_admin.error_first_name'),
                    'first_name.max'        => trans('custom_admin.error_first_name_maximum'),
                    'last_name.required'    => trans('custom_admin.error_last_name'),
                    'last_name.max'         => trans('custom_admin.error_last_name_maximum'),
                    'email.required'        => trans('custom_admin.error_email'),
                    'email.regex'           => trans('custom_admin.error_email_valid'),
                );
                $Validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($Validator->fails()) {
                    $validationFailedMessages = AdminHelper::validationMessageBeautifier($Validator->messages()->getMessages());
                    $this->generateToastMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
                } else {
                    $validationFlag = false;
                    // Unique Email validation for User type "Admin"
                    $userEmailExistCheck = User::where('id', '<>', $id)
                                                ->where(['email' => $request->email, 'type' => 'A'])
                                                ->count();
                    if ($userEmailExistCheck > 0) {
                        $validationFlag = true;
                    }
                    
                    if (!$validationFlag) {
                        $profileName        = trim($request->first_name,' ').' '.trim($request->last_name,' ');
                        $user->first_name   = isset($request->first_name) ? trim($request->first_name,' ') : '';
                        $user->last_name    = isset($request->last_name) ? trim($request->last_name,' ') : '';
                        $user->full_name    = $profileName;
                        $user->email        = trim($request->email,' ');
                        $user->phone_no     = isset($request->phone_no) ? $request->phone_no : '';
                        $user->save();
                        
                        /*----------- Deleting & Inserting data to user_roles table ----------*/
                        $deletingUserRoles = UserRole::where('user_id', $user->id)->delete();
                        if ($request->role) {
                            foreach ($request->role as $valRole) {
                                $userRoleData           = new UserRole;
                                $userRoleData->user_id  = $id;
                                $userRoleData->role_id  = $valRole;
                                $userRoleData->save();
                            }
                        }
                        $this->generateToastMessage('success', trans('custom_admin.success_data_added_successfully'), false);
                        return redirect()->route('admin.subAdmin.list');
                    } else {
                        $this->generateToastMessage('error', trans('custom_admin.error_email_unique'), false);
                        return redirect()->back()->withInput();
                    }
                }                
            }            
            return view('admin.sub_admin.edit', $data);

        } catch (Exception $e) {
            $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return redirect()->route('admin.subAdmin.list');
        } catch (\Throwable $e) {
            $this->generateToastMessage('error', $e->getMessage(), false);
            return redirect()->route('admin.subAdmin.list');
        }
    }    

    /*****************************************************/
    # Function name : status
    # Params        : Request $request, $id
    /*****************************************************/
    public function status(Request $request, $id = null)
    {
        $title      = trans('custom_admin.message_error');
        $message    = trans('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                $id = AdminHelper::customEncryptionDecryption($id, 'decrypt');
                if ($id != null) {
                    $details = User::where('id', $id)->first();
                    if ($details != null) {
                        if ($details->status == 1) {
                            $details->status = '0';
                            $details->save();
                            
                            $title      = trans('custom_admin.message_success');
                            $message    = trans('custom_admin.success_status_updated_successfully');
                            $type       = 'success';
        
                        } else if ($details->status == 0) {
                            $details->status = '1';
                            $details->save();
        
                            $title      = trans('custom_admin.message_success');
                            $message    = trans('custom_admin.success_status_updated_successfully');
                            $type       = 'success';
                        }
                    } else {
                        $message = trans('custom_admin.error_invalid');
                    }
                }
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        catch (\Throwable $e) {
            $message = $e->getMessage();
        }
        
        return response()->json(['title' => $title, 'message' => $message, 'type' => $type]);
    }

    /*****************************************************/
    # Function name : delete
    # Params        : Request $request, $id
    /*****************************************************/
    public function delete(Request $request, $id = null)
    {
        $title      = trans('custom_admin.message_error');
        $message    = trans('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                $id = AdminHelper::customEncryptionDecryption($id, 'decrypt');
                if ($id != null) {
                    $details = User::where('id', $id)->first();
                    if ($details != null) {
                        $delete = $details->delete();
                        if ($delete) {
                            // RolePermission::where('role_id',$id)->delete();
                            $title      = trans('custom_admin.message_success');
                            $message    = trans('custom_admin.success_data_deleted_successfully');
                            $type       = 'success';
                        } else {
                            $message    = trans('custom_admin.error_took_place_while_deleting');
                        }
                    } else {
                        $message = trans('custom_admin.error_invalid');
                    }
                }
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        catch (\Throwable $e) {
            $message = $e->getMessage();
        }
        
        return response()->json(['title' => $title, 'message' => $message, 'type' => $type]);
    }

    /*****************************************************/
    # Function name : bulkActions
    # Params        : Request $request
    /*****************************************************/
    public function bulkActions(Request $request)
    {
        $title      = trans('custom_admin.message_error');
        $message    = trans('custom_admin.error_something_went_wrong');
        $type       = 'error';

        try {
            if ($request->ajax()) {
                $selectedIds    = $request->selectedIds;
                $actionType     = $request->actionType;
                if (count($selectedIds) > 0) {
                    if ($actionType ==  'active') {
                        User::whereIn('id', $selectedIds)->update(['status' => '1']);
                        
                        $title      = trans('custom_admin.message_success');
                        $message    = trans('custom_admin.success_status_updated_successfully');
                        $type       = 'success';
                    } elseif ($actionType ==  'inactive') {
                        User::whereIn('id', $selectedIds)->update(['status' => '0']);

                        $title      = trans('custom_admin.message_success');
                        $message    = trans('custom_admin.success_status_updated_successfully');
                        $type       = 'success';
                    } else {
                        User::whereIn('id', $selectedIds)->delete();

                        $title      = trans('custom_admin.message_success');
                        $message    = trans('custom_admin.success_data_deleted_successfully');
                        $type       = 'success';
                    }
                } else {
                    $message = trans('custom_admin.error_invalid');
                }
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        catch (\Throwable $e) {
            $message = $e->getMessage();
        }
        
        return response()->json(['title' => $title, 'message' => $message, 'type' => $type]);
    }

}