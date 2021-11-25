<?php
/*****************************************************/
# Page/Class name   : RolesController
/*****************************************************/
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Model\Role;
use App\Model\RolePage;
use App\Model\RolePermission;
use App\Model\User;
use App\Model\UserRole;
use DataTables;
use AdminHelper;

class RolesController extends Controller
{
    /*****************************************************/
    # Function name : list
    # Params        :
    /*****************************************************/
    public function list(Request $request)
    {
        $data['pageTitle'] = trans('custom_admin.label_role_list');
        $data['panelTitle']= trans('custom_admin.label_role_list');
        
        try {
            // Start :: Manage restriction
            $data['isAllow'] = false;
            $restrictions   = AdminHelper::checkingAllowRouteToUser('role.');
            if ($restrictions['is_super_admin']) {
                $data['isAllow'] = true;
            }
            $data['allowedRoutes']  = $restrictions['allow_routes'];
            // End :: Manage restriction

            return view('admin.roles.list', $data);
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
                $data = Role::where('id', '!=', '1')->whereNull('deleted_at')->get();

                // Start :: Manage restriction
                $isAllow = false;
                $restrictions   = AdminHelper::checkingAllowRouteToUser('role.');
                if ($restrictions['is_super_admin']) {
                    $isAllow = true;
                }
                $allowedRoutes  = $restrictions['allow_routes'];
                // End :: Manage restriction

                return Datatables::of($data, $isAllow, $allowedRoutes)
                        ->addIndexColumn()
                        ->addColumn('action', function($row) use ($isAllow, $allowedRoutes) {
                            $btn = '';
                            if ($isAllow || in_array('role.edit', $allowedRoutes)) {
                                $editLink = route('admin.role.edit', AdminHelper::customEncryptionDecryption($row->id));

                                $btn .= '<a href="'.$editLink.'" data-toggle="tooltip" data-id="'.AdminHelper::customEncryptionDecryption($row->id).'" data-original-title="Edit" class="edit btn bg-info btn-sm" title="'.trans('custom_admin.label_edit').'"><i class="fas fa-edit"></i></a>';
                            }
                            if ($isAllow || in_array('role.delete', $allowedRoutes)) {
                                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.AdminHelper::customEncryptionDecryption($row->id).'" data-action-type="delete" class="btn bg-danger btn-sm delete" title="'.trans('custom_admin.label_delete').'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            }
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }
          
            return view('admin.roles.list');

        } catch (Exception $e) {
            return '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    /*****************************************************/
    # Function name : create
    # Params        :
    /*****************************************************/
    public function add(Request $request)
    {
        $data['pageTitle']     = trans('custom_admin.label_add_role');
        $data['panelTitle']    = trans('custom_admin.label_add_role');

        try
        {
            // Breadcrumb
            $data['breadcrumb'] = [
                                    'module_title' => trans('custom_admin.label_role_list'),
                                    'module_url' => 'admin.role.list'
                                ];

            if ($request->isMethod('POST'))
        	{
				$validationCondition = array(
                    'name'  => 'required|max:255|unique:'.(new Role)->getTable().',name,NULL,id,deleted_at,NULL',
				);
				$validationMessages = array(
                    'name.required' => trans('custom_admin.error_role'),
                    'name.max'      => trans('custom_admin.error_maximum_character'),
                    'name.unique'   => trans('custom_admin.error_role_unique'),
				);
				$Validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
				if ($Validator->fails()) {
                    $validationFailedMessages = AdminHelper::validationMessageBeautifier($Validator->messages()->getMessages());
                    $this->generateToastMessage('error', $validationFailedMessages, false);
                    return redirect()->route('admin.role.add')->withInput();
				} else {
                    $roleName = $request->name;
                    $newSlug = AdminHelper::generateUniqueSlug(new Role(), $roleName);

                    $role = new Role();
                    $role->name     = $roleName;
                    $role->slug     = $newSlug;
                    $role->is_admin = '1';
                    if ($role->save()) {
                        // Inserting role_page_id into role_permission table
                        if (isset($request->role_page_ids)) {
                            foreach ($request->role_page_ids as $keyRolePageId => $rolePageId) {                    
                                $rolePermission[$keyRolePageId]['role_id'] = $role->id;
                                $rolePermission[$keyRolePageId]['page_id'] = $rolePageId;
                            }
                            RolePermission::insert($rolePermission);
                        }

                        $this->generateToastMessage('success', trans('custom_admin.success_data_added_successfully'), false);
                        return redirect()->route('admin.role.list');
                        
					} else {
                        $this->generateToastMessage('error', trans('custom_admin.error_took_place_while_adding'), false);
                        return redirect()->back()->withInput();
					}
				}
			}
            $routeCollection        = self::getRoutes();
            $data['routeCollection']= $routeCollection;

            return view('admin.roles.add', $data);
		} catch (Exception $e) {
            $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return redirect()->route('admin.role.list');
        } catch (\Throwable $e) {
            $this->generateToastMessage('error', $e->getMessage(), false);
            return redirect()->route('admin.role.list');
        }
    }

    /*****************************************************/
    # Function name : edit
    # Params        :
    /*****************************************************/
    public function edit(Request $request, $id = null)
    {
        $data['pageTitle']  = trans('custom_admin.label_edit_role');
        $data['panelTitle'] = trans('custom_admin.label_edit_role');

        try
        {   
            // Breadcrumb
            $data['breadcrumb'] = [
                                    'module_title' => trans('custom_admin.label_role_list'),
                                    'module_url' => 'admin.role.list'
                                ];

            $data['id']      = $id;
            $id              = AdminHelper::customEncryptionDecryption($id, 'decrypt');
            $data['details'] = $details = Role::where('id', $id)->with(['permissions'])->first();
            $routeCollection = self::getRoutes();

            if ($request->isMethod('POST')) {
                if ($id == null) {
                    $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
                    return redirect()->route('admin.role.list');
                }
                $validationCondition = array(
                    'name' => 'required|max:255|unique:' .(new Role)->getTable().',name,'.$id.',id,deleted_at,NULL',
                );
                $validationMessages = array(
                    'name.required' => trans('custom_admin.error_role'),
                    'name.max'      => trans('custom_admin.error_maximum_character'),
                    'name.unique'   => trans('custom_admin.error_role_unique'),
                );                
                $Validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($Validator->fails()) {
                    $validationFailedMessages = AdminHelper::validationMessageBeautifier($Validator->messages()->getMessages());                        
                    $this->generateToastMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
                } else {
                    $roleName       = trim($request->name, ' ');
                    $details->name  = $roleName;
                    $details->slug  = AdminHelper::generateUniqueSlug(new Role(), $roleName, $id);

                    if ($details->save()) {
                        // Deleting and Inserting role_page_id into role_permission table
                        $deleteRolePermissions = RolePermission::where('role_id',$details->id)->delete();
                        if (isset($request->role_page_ids)) {
                            foreach ($request->role_page_ids as $keyRolePageId => $rolePageId) {
                                $rolePermission[$keyRolePageId]['role_id'] = $details->id;
                                $rolePermission[$keyRolePageId]['page_id'] = $rolePageId;
                            }
                            RolePermission::insert($rolePermission);
                        }
                        $this->generateToastMessage('success', trans('custom_admin.success_data_updated_successfully'), false);
                        return redirect()->route('admin.role.list');
                    } else {
                        $this->generateToastMessage('error', trans('custom_admin.error_took_place_while_updating'), false);
                        return redirect()->back()->withInput();
                    }
                }
            }

            $existingPermission = [];
            if (count($details->permissions) > 0) {
                foreach ($details->permissions as $permission) {
                    $existingPermission[] = $permission['page_id'];
                }
            }
            $data['routeCollection']    = $routeCollection;
            $data['existingPermission'] = $existingPermission;
            
            return view('admin.roles.edit', $data);
        } catch (Exception $e) {
            $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return redirect()->route('admin.role.list');
        } catch (\Throwable $e) {
            $this->generateToastMessage('error', $e->getMessage(), false);
            return redirect()->route('admin.role.list');
        }
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
                    $isExistUserWithTheRole = UserRole::where('role_id', $id)->count();
                    if ($isExistUserWithTheRole > 0) {
                        $message = trans('custom_admin.error_role_user');
                    } else {
                        $deleteRole = Role::find($id)->delete();
                        if ($deleteRole) {
                            RolePermission::where('role_id',$id)->delete();
                            $title      = trans('custom_admin.message_success');
                            $message    = trans('custom_admin.success_data_deleted_successfully');
                            $type       = 'success';
                        } else {
                            $message    = trans('custom_admin.error_took_place_while_deleting');
                        }
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
                    if ($actionType ==  'delete') {
                        $partialActionStatus = false;

                        foreach ($selectedIds as $key => $val) {
                            $isExistUserWithTheRole = UserRole::where('role_id', $val)->count();

                            if ($isExistUserWithTheRole > 0) {
                                $partialActionStatus = true;
                            } else {
                                $deleteRole = Role::find($val)->delete();
                                RolePermission::where('role_id',$val)->delete();
                            }
                        }
                        if ($partialActionStatus) {
                            $title      = trans('custom_admin.message_warning');
                            $message    = trans('custom_admin.error_role_user');
                            $type       = 'warning';
                        } else {
                            $title      = trans('custom_admin.message_success');
                            $message    = trans('custom_admin.success_data_deleted_successfully');
                            $type       = 'success';
                        }
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

    /*****************************************************/
    # Function name : getRoutes
    # Params        : 
    /*****************************************************/
    public function getRoutes()
    {
        $routeCollection = \Route::getRoutes();
        // dd($routeCollection);

        // echo "<table style='width:100%'>";
        //     echo "<tr>";
        //         echo "<td width='10%'><h4>Serial</h4></td>";
        //         echo "<td width='10%'><h4>HTTP Method</h4></td>";
        //         echo "<td width='10%'><h4>Route</h4></td>";
        //         echo "<td width='10%'><h4>Name</h4></td>";
        //         echo "<td width='70%'><h4>Corresponding Action</h4></td>";
        //     echo "</tr>";
        //     $k = 1;
        //     foreach ($routeCollection as $route) {
        //         $namespace = $route->uri();
        //         if (!in_array("POST", $route->methods)  && strstr($namespace,'adminpanel/') != '' && strstr($route->getName(),'admin') != '') {
        //             echo "<tr>";
        //                 echo "<td>" . $k . "</td>";
        //                 echo "<td>" . $route->methods[0] . "</td>";
        //                 echo "<td>" . $route->uri() . "</td>";
        //                 echo "<td>" . $route->getName() . "</td>";
        //                 echo "<td>" . $route->getActionName() . "</td>";
        //             echo "</tr>";
        //             $k++;
        //         }                
        //     }
        // echo "</table>";

        // die('here');

        $list = [];
        $excludedSections = ['forgot','profile','update','reset','role','subAdmin'];
        
        foreach($routeCollection as $route) {
            $namespace = $route->uri();
            
            if (!in_array("POST", $route->methods)  && strstr($namespace,'adminpanel/') != '' && strstr($route->getName(),'admin') != '') {
                $group = str_replace("admin.", "", $route->getName());
                $group = strstr($group, ".", true);
                if ($group) {
                    if (!in_array($group, $excludedSections)) {
                        $pagePath       = explode('admin.',$route->getName());
                        $getPagePath    = $pagePath[1];
                        
                        //Checking route exist in role_pages table or not, if not then insert and get the id
                        $rolePageDetails = RolePage::where('routeName', '=', $getPagePath)->first();
                        if ($rolePageDetails == null) {
                            $rolePageDetails = new RolePage();
                            $rolePageDetails->routeName = $getPagePath;
                            $rolePageDetails->save();
                        }

                        if (!array_key_exists($group, $list)) {
                            $list[$group] = [];
                        }
                        array_push($list[$group], [
                            "method" => $route->methods[0],
                            "uri" => $route->uri(),
                            "path" => $getPagePath,
                            "role_page_id" => $rolePageDetails->id,
                            "group_name" => ($group) ? $group : '',
                            "middleware"=>$route->middleware()
                        ]);
                    }
                }
            }
        }
        return $list;
    }

}
