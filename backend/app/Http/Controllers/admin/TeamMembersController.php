<?php
/*****************************************************/
# Page/Class name   : TeamMembersController
/*****************************************************/

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use Config;
use Image;
use App\Model\TeamMember;
use DataTables;
use AdminHelper;

class TeamMembersController extends Controller
{
    /*****************************************************/
    # Function name : list
    # Params        : Request $request
    /*****************************************************/
    public function list(Request $request)
    {
        $data['pageTitle'] = trans('custom_admin.label_team_member_list');
        $data['panelTitle']= trans('custom_admin.label_team_member_list');

        try {
            // Start :: Manage restriction
            $data['isAllow'] = false;
            $restrictions   = AdminHelper::checkingAllowRouteToUser('teamMember.');
            if ($restrictions['is_super_admin']) {
                $data['isAllow'] = true;
            }
            $data['allowedRoutes']  = $restrictions['allow_routes'];
            // End :: Manage restriction

            return view('admin.team_member.list', $data);
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

                $query = TeamMember::whereNull('deleted_at');
                $data = $query->get();

                // Start :: Manage restriction
                $isAllow = false;
                $restrictions   = AdminHelper::checkingAllowRouteToUser('teamMember.');
                if ($restrictions['is_super_admin']) {
                    $isAllow = true;
                }
                $allowedRoutes  = $restrictions['allow_routes'];
                // End :: Manage restriction

                return Datatables::of($data, $isAllow, $allowedRoutes)
                        ->addIndexColumn()
                        ->addColumn('image', function ($row) use ($isAllow, $allowedRoutes) {
                            $image = asset("images/admin/".AdminHelper::NO_IMAGE);
                            if (file_exists(public_path('images/uploads/team_member/thumbs/'.$row->image))) {
                                $image = asset("images/uploads/team_member/thumbs/".$row->image);
                            }
                            return $image;
                        })
                        ->addColumn('status', function ($row) use ($isAllow, $allowedRoutes) {
                            if ($isAllow || in_array('teamMember.change-status', $allowedRoutes)) {
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
                            if ($isAllow || in_array('teamMember.edit', $allowedRoutes)) {
                                $editLink = route('admin.teamMember.edit', AdminHelper::customEncryptionDecryption($row->id));                            
                                $btn .= '<a href="'.$editLink.'" data-toggle="tooltip" data-id="'.AdminHelper::customEncryptionDecryption($row->id).'" data-original-title="Edit" class="edit btn bg-info btn-sm" title="'.trans('custom_admin.label_edit').'"><i class="fas fa-edit"></i></a>';
                            }
                            if ($isAllow || in_array('teamMember.delete', $allowedRoutes)) {
                                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.AdminHelper::customEncryptionDecryption($row->id).'" data-action-type="delete" class="btn bg-danger btn-sm delete" title="'.trans('custom_admin.label_delete').'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            }
                            return $btn;
                        })
                        ->rawColumns(['status','action'])
                        ->make(true);
            }
          
            return view('admin.team_member.list');

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
        $data['pageTitle']  = trans('custom_admin.label_add_team_member');
        $data['panelTitle'] = trans('custom_admin.label_add_team_member');
    
        try
        {
            // Breadcrumb
            $data['breadcrumb'] = [
                                    'module_title' => trans('custom_admin.label_team_member_list'),
                                    'module_url' => 'admin.teamMember.list'
                                ];
        	if ($request->isMethod('POST'))
        	{
				$validationCondition = array(
                    'name'              => 'required',
                    'designation'       => 'required',
                    'short_description' => 'required',
                    // 'linkedin_link'     => 'required',
                    'image'             => 'required|mimes:jpeg,jpg,png,svg|max:'.AdminHelper::IMAGE_MAX_UPLOAD_SIZE,
				);
				$validationMessages = array(
                    'name.required'             => trans('custom_admin.error_name'),
                    'designation.required'      => trans('custom_admin.error_designation'),
                    'short_description.required'=> trans('custom_admin.error_short_description'),
                    // 'linkedin_link.required'    => trans('custom_admin.error_linkedin_link'),
                    'image.required'            => trans('custom_admin.error_image'),
                    'image.mimes'               => trans('custom_admin.error_image_types'),
				);

				$validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
				if ($validator->fails()) {
					$validationFailedMessages = AdminHelper::validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateToastMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
				} else {
                    $fileName = null;
                    $image = $request->file('image');
                    if ($image != '') {
                        $originalFileNameCat = $image->getClientOriginalName();
                        $extension      = pathinfo($originalFileNameCat, PATHINFO_EXTENSION);
                        $fileName       = 'team_member_'.strtotime(date('Y-m-d H:i:s')).'.'.$extension;                        
                        $imageResize    = Image::make($image->getRealPath());
                        $imageResize->save(public_path('images/uploads/team_member/' . $fileName));
                        $imageResize->resize(AdminHelper::ADMIN_TEAM_MEMBER_THUMB_IMAGE_WIDTH, AdminHelper::ADMIN_TEAM_MEMBER_THUMB_IMAGE_HEIGHT, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $imageResize->save(public_path('images/uploads/team_member/thumbs/' . $fileName));
                    }
                    $details                = new TeamMember;
                    $details->name          = isset($request->name) ? trim($request->name,' ') : null;
                    $details->designation   = isset($request->designation) ? trim($request->designation,' ') : null;
                    $details->short_description = isset($request->short_description) ? trim($request->short_description,' ') : null;
                    $details->linkedin_link = isset($request->linkedin_link) ? trim($request->linkedin_link,' ') : null;
                    $details->image         = $fileName;
                    $details->sort          = AdminHelper::generateSortNumber(new TeamMember());
                    if ($details->save()) {
                        $this->generateToastMessage('success', trans('custom_admin.success_data_added_successfully'), false);
                        return redirect()->route('admin.teamMember.list');
                    } else {
                        $this->generateToastMessage('error', trans('custom_admin.error_took_place_while_adding'), false);
                        return redirect()->back()->withInput();
                    }
				}
            }            
			return view('admin.team_member.add', $data);
		} catch (Exception $e) {
            $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return redirect()->route('admin.teamMember.list');
        } catch (\Throwable $e) {
            $this->generateToastMessage('error', $e->getMessage(), false);
            return redirect()->route('admin.teamMember.list');
        }
    }

    /*****************************************************/
    # Function name : edit
    # Params        :
    /*****************************************************/
    public function edit(Request $request, $id = null)
    {
        $data['pageTitle'] = trans('custom_admin.label_edit_team_member');
        $data['panelTitle']= trans('custom_admin.label_edit_team_member');

        try
        {
            // Breadcrumb
            $data['breadcrumb'] = [
                                    'module_title' => trans('custom_admin.label_team_member_list'),
                                    'module_url' => 'admin.teamMember.list'
                                ];
            $data['id']      = $id;
            $id              = AdminHelper::customEncryptionDecryption($id, 'decrypt');
            $data['details'] = $details = TeamMember::where(['id' => $id])->first();
            
            if ($request->isMethod('POST')) {
                if ($id == null) {
                    $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
                    return redirect()->route('admin.teamMember.list');
                }

                $validationCondition = array(
                    'name'              => 'required',
                    'designation'       => 'required',
                    'short_description' => 'required',
                    // 'linkedin_link'     => 'required',
				);
				$validationMessages = array(
                    'name.required'             => trans('custom_admin.error_name'),
                    'designation.required'      => trans('custom_admin.error_designation'),
                    'short_description.required'=> trans('custom_admin.error_short_description'),
                    // 'linkedin_link.required'    => trans('custom_admin.error_linkedin_link'),
				);

                $validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
				if ($validator->fails()) {
					$validationFailedMessages = AdminHelper::validationMessageBeautifier($validator->messages()->getMessages());
                    $this->generateToastMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
				} else {
                    $image = $request->file('image');
                    if ($image != '') {
                        $validationConditionImage = array(
                            'image' => 'mimes:jpeg,jpg,png,svg|max:'.AdminHelper::IMAGE_MAX_UPLOAD_SIZE,
                        );
                        $validationMessagesImage = array(
                            'image.mimes' => trans('custom_admin.error_image_types'),
                        );
                        $validatorImage = \Validator::make($request->all(), $validationConditionImage, $validationMessagesImage);
                        if ($validatorImage->fails()) {
                            $validationImageFailedMessages = AdminHelper::validationMessageBeautifier($validatorImage->messages()->getMessages());
                            $this->generateToastMessage('error', $validationImageFailedMessages, false);
                            return redirect()->back()->withInput();
                        }

                        $originalFileName = $image->getClientOriginalName();
                        $extension   = pathinfo($originalFileName, PATHINFO_EXTENSION);
                        $fileName    = 'team_member_'.strtotime(date('Y-m-d H:i:s')).'.'.$extension;
                        $imageResize = Image::make($image->getRealPath());
                        $imageResize->save(public_path('images/uploads/team_member/' . $fileName));
                        $imageResize->resize(AdminHelper::ADMIN_TEAM_MEMBER_THUMB_IMAGE_WIDTH, AdminHelper::ADMIN_TEAM_MEMBER_THUMB_IMAGE_HEIGHT, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $imageResize->save(public_path('images/uploads/team_member/thumbs/' . $fileName));
                        
                        $largeImage = public_path().'/images/uploads/team_member/'.$details->image;
                        $thumbImage = public_path().'/images/uploads/team_member/thumbs/'.$details->image;
                        @unlink($largeImage); @unlink($thumbImage);
                        
                        $details->image = $fileName;
                    }
                    $details->name          = isset($request->name) ? trim($request->name,' ') : null;
                    $details->designation   = isset($request->designation) ? trim($request->designation,' ') : null;
                    $details->short_description = isset($request->short_description) ? trim($request->short_description,' ') : null;
                    $details->linkedin_link = isset($request->linkedin_link) ? trim($request->linkedin_link,' ') : null;
                    if ($details->save()) {
                        $this->generateToastMessage('success', trans('custom_admin.success_data_updated_successfully'), false);
                        return redirect()->route('admin.teamMember.list');
                    } else {
                        $this->generateToastMessage('error', trans('custom_admin.error_took_place_while_updating'), false);
                        return redirect()->back()->withInput();
                    }
                }
            }
            return view('admin.team_member.edit', $data);

        } catch (Exception $e) {
            $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return redirect()->route('admin.teamMember.list');
        } catch (\Throwable $e) {
            $this->generateToastMessage('error', $e->getMessage(), false);
            return redirect()->route('admin.teamMember.list');
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
                    $details = TeamMember::where('id', $id)->first();
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
                    $details = TeamMember::where('id', $id)->first();
                    if ($details != null) {
                        $delete = $details->delete();
                        if ($delete) {
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
                        TeamMember::whereIn('id', $selectedIds)->update(['status' => '1']);
                        
                        $title      = trans('custom_admin.message_success');
                        $message    = trans('custom_admin.success_status_updated_successfully');
                        $type       = 'success';
                    } elseif ($actionType ==  'inactive') {
                        TeamMember::whereIn('id', $selectedIds)->update(['status' => '0']);

                        $title      = trans('custom_admin.message_success');
                        $message    = trans('custom_admin.success_status_updated_successfully');
                        $type       = 'success';
                    } else {
                        TeamMember::whereIn('id', $selectedIds)->delete();

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
