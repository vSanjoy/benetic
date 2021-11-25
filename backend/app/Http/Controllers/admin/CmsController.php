<?php
/*****************************************************/
# Page/Class name   : CmsController
/*****************************************************/
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Model\Cms;
use DataTables;
use AdminHelper;
use Image;

class CmsController extends Controller
{
    /*****************************************************/
    # Function name : list
    # Params        : Request $request
    /*****************************************************/
    public function list(Request $request)
    {
        $data['pageTitle'] = trans('custom_admin.label_cms_list');
        $data['panelTitle']= trans('custom_admin.label_cms_list');

        try {
            // Start :: Manage restriction
            $data['isAllow'] = false;
            $restrictions   = AdminHelper::checkingAllowRouteToUser('cms.');
            if ($restrictions['is_super_admin']) {
                $data['isAllow'] = true;
            }
            $data['allowedRoutes']  = $restrictions['allow_routes'];
            // End :: Manage restriction

            return view('admin.cms.list', $data);
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

                $query = new Cms;

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
                $restrictions   = AdminHelper::checkingAllowRouteToUser('cms.');
                if ($restrictions['is_super_admin']) {
                    $isAllow = true;
                }
                $allowedRoutes  = $restrictions['allow_routes'];
                // End :: Manage restriction

                return Datatables::of($data, $isAllow, $allowedRoutes)
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) use ($isAllow, $allowedRoutes) {
                            $btn = '';
                            if ($isAllow || in_array('cms.edit', $allowedRoutes)) {
                                $editLink = route('admin.cms.edit', AdminHelper::customEncryptionDecryption($row->id));
                            
                                $btn .= '<a href="'.$editLink.'" data-toggle="tooltip" data-id="'.AdminHelper::customEncryptionDecryption($row->id).'" data-original-title="Edit" class="edit btn bg-info btn-sm" title="'.trans('custom_admin.label_edit').'"><i class="fas fa-edit"></i></a>';
                            }
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }
          
            return view('admin.cms.list');

        } catch (Exception $e) {
            return '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    /*****************************************************/
    # Function name : edit
    # Params        :
    /*****************************************************/
    public function edit(Request $request, $id = null)
    {
        $data['pageTitle'] = trans('custom_admin.label_edit_cms');
        $data['panelTitle']= trans('custom_admin.label_edit_cms');

        try
        {
            // Breadcrumb
            $data['breadcrumb'] = [
                                    'module_title' => trans('custom_admin.label_cms_list'),
                                    'module_url' => 'admin.cms.list'
                                ];
            
            $data['id']      = $id;
            $data['cmsId']   = $id = AdminHelper::customEncryptionDecryption($id, 'decrypt');
            $data['details'] = $details = Cms::where(['id' => $id])->first();
            
            if ($request->isMethod('POST')) {
                if ($id == null) {
                    $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
                    return redirect()->route('admin.cms.list');
                }
                $validationCondition = array(
                    'title'             => 'required',
                    // 'description'       => 'required',
                    // 'meta_title'        => 'required',
                    // 'meta_keyword'      => 'required',
                    // 'meta_description'  => 'required',
                );
                $validationMessages = array(
                    'title.required'            => trans('custom_admin.error_title'),
                    // 'description.required'      => trans('custom_admin.error_description'),
                    // 'meta_title.required'       => trans('custom_admin.error_meta_title'),
                    // 'meta_keyword.required'     => trans('custom_admin.error_meta_keyword'),
                    // 'meta_description.required' => trans('custom_admin.error_meta_description'),
                );
                $Validator = \Validator::make($request->all(), $validationCondition, $validationMessages);
                if ($Validator->fails()) {
                    $validationFailedMessages = AdminHelper::validationMessageBeautifier($Validator->messages()->getMessages());
                    $this->generateToastMessage('error', $validationFailedMessages, false);
                    return redirect()->back()->withInput();
                } else {
                    $image = $request->file('banner_image');
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

                        $originalFileName   = $image->getClientOriginalName();
                        $extension          = pathinfo($originalFileName, PATHINFO_EXTENSION);
                        $fileName           = 'cms_banner_'.strtotime(date('Y-m-d H:i:s')).'.'.$extension;
                        $imageResize        = Image::make($image->getRealPath());
                        $imageResize->save(public_path('images/uploads/cms/' . $fileName));
                        
                        $largeImage = public_path().'/images/uploads/cms/'.$details->banner_image;
                        @unlink($largeImage);
                        
                        $details->banner_image = $fileName;
                    }
                    // Home widget image
                    $homeWidgetImage = $request->file('home_widget_image');
                    if ($homeWidgetImage != '') {
                        $validationConditionImageHomeWidget = array(
                            'image' => 'mimes:jpeg,jpg,png,svg|max:'.AdminHelper::IMAGE_MAX_UPLOAD_SIZE,
                        );
                        $validationMessagesImageHomeWidget = array(
                            'image.mimes' => trans('custom_admin.error_image_types'),
                        );
                        $validatorImageHomeWidget = \Validator::make($request->all(), $validationConditionImageHomeWidget, $validationMessagesImageHomeWidget);
                        if ($validatorImageHomeWidget->fails()) {
                            $validationImageFailedMessagesHomeWidget = AdminHelper::validationMessageBeautifier($validatorImageHomeWidget->messages()->getMessages());
                            $this->generateToastMessage('error', $validationImageFailedMessagesHomeWidget, false);
                            return redirect()->back()->withInput();
                        }

                        $originalFileNameHW = $homeWidgetImage->getClientOriginalName();
                        $extensionHW        = pathinfo($originalFileNameHW, PATHINFO_EXTENSION);
                        $fileNameHW         = 'cms_banner_'.strtotime(date('Y-m-d H:i:s')).'.'.$extensionHW;
                        $imageResizeHW      = Image::make($homeWidgetImage->getRealPath());
                        $imageResizeHW->save(public_path('images/uploads/cms/' . $fileNameHW));
                        
                        $largeImageHW = public_path().'/images/uploads/cms/'.$details->home_widget_image;
                        @unlink($largeImageHW);
                        
                        $details->home_widget_image = $fileNameHW;
                    }
                    // Image 1
                    $image1 = $request->file('image1');
                    if ($image1 != '') {
                        $validationConditionImage1 = array(
                            'image' => 'mimes:jpeg,jpg,png,svg|max:'.AdminHelper::IMAGE_MAX_UPLOAD_SIZE,
                        );
                        $validationMessagesImage1 = array(
                            'image.mimes' => trans('custom_admin.error_image_types'),
                        );
                        $validatorImage1 = \Validator::make($request->all(), $validationConditionImage1, $validationMessagesImage1);
                        if ($validatorImage1->fails()) {
                            $validationImageFailedMessages1 = AdminHelper::validationMessageBeautifier($validatorImage1->messages()->getMessages());
                            $this->generateToastMessage('error', $validationImageFailedMessages1, false);
                            return redirect()->back()->withInput();
                        }

                        $originalFileName1  = $image1->getClientOriginalName();
                        $extension1         = pathinfo($originalFileName1, PATHINFO_EXTENSION);
                        $fileName1          = 'cms_other_'.strtotime(date('Y-m-d H:i:s')).'.'.$extension1;
                        $imageResize1       = Image::make($image1->getRealPath());
                        $imageResize1->save(public_path('images/uploads/cms/' . $fileName1));
                        
                        $largeImage1 = public_path().'/images/uploads/cms/'.$details->image1;
                        @unlink($largeImage1);
                        
                        $details->image1 = $fileName1;
                    }

                    $details->title                     = isset($request->title) ? trim($request->title, ' ') : null;
                    $details->short_title               = isset($request->short_title) ? $request->short_title : null;
                    $details->logo_short_title          = isset($request->logo_short_title) ? $request->logo_short_title : null;
                    $details->description               = isset($request->description) ? $request->description : null;
                    $details->short_description         = isset($request->short_description) ? $request->short_description : null;
                    $details->banner_title              = isset($request->banner_title) ? trim($request->banner_title, ' ') : null;
                    $details->banner_short_title        = isset($request->banner_short_title) ? trim($request->banner_short_title, ' ') : null;
                    $details->banner_short_description  = isset($request->banner_short_description) ? trim($request->banner_short_description, ' ') : null;
                    if ($details->save()) {
                        $this->generateToastMessage('success', trans('custom_admin.success_data_updated_successfully'), false);
                        return redirect()->route('admin.cms.list');
                    } else {
                        $this->generateToastMessage('error', trans('custom_admin.error_took_place_while_updating'), false);
                        return redirect()->back()->withInput();
                    }
                }
            }
            return view('admin.cms.edit', $data);            

        } catch (Exception $e) {
            $this->generateToastMessage('error', trans('custom_admin.error_something_went_wrong'), false);
            return redirect()->route('admin.cms.list');
        } catch (\Throwable $e) {
            $this->generateToastMessage('error', $e->getMessage(), false);
            return redirect()->route('admin.cms.list');
        }
    }

    /*****************************************************/
    # Function name : upload
    # Params        :
    /*****************************************************/
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = 'cms_'.strtotime(date('Y-m-d H:i:s')).'.'.$extension;
        
            $request->file('upload')->move(public_path('images/uploads/cms'), $fileName);
   
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/uploads/cms/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }

}