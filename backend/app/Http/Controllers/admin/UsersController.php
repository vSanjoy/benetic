<?php
/*****************************************************/
# Page/Class name   : UsersController
/*****************************************************/
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Auth;
use Mail;
use Config;
use App\Model\User;
use DataTables;
use AdminHelper;

class UsersController extends Controller
{
    /*****************************************************/
    # Function name : list
    # Params        : Request $request
    /*****************************************************/
    public function list(Request $request, $type = 'D')
    {
        $data['pageTitle'] = trans('custom_admin.label_user_list');
        $data['panelTitle']= trans('custom_admin.label_user_list');

        try {
            // Start :: Manage restriction
            $data['isAllow'] = false;
            $restrictions   = AdminHelper::checkingAllowRouteToUser('users.');
            if ($restrictions['is_super_admin']) {
                $data['isAllow'] = true;
            }
            $data['allowedRoutes']  = $restrictions['allow_routes'];
            // End :: Manage restriction

            $data['userType'] = $type;
            $query = User::where('id','<>','1')->where(['type' => $type])->whereNull('deleted_at');
            $data['userCount'] = $query->count();

            return view('admin.user.list', $data);
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
    public function listRequest(Request $request, $type = 'D')
    {
        try {
            if ($request->ajax()) {

                $query = User::where('id','<>','1')->where(['type' => $type])->whereNull('deleted_at');
                $data = $query->get();

                // Start :: Manage restriction
                $isAllow = false;
                $restrictions   = AdminHelper::checkingAllowRouteToUser('users.');
                if ($restrictions['is_super_admin']) {
                    $isAllow = true;
                }
                $allowedRoutes  = $restrictions['allow_routes'];
                // End :: Manage restriction

                return Datatables::of($data, $isAllow, $allowedRoutes)
                        ->addIndexColumn()
                        ->make(true);
            }
          
            return view('admin.user.list');

        } catch (Exception $e) {
            return '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    /*****************************************************/
    # Function name : exportAsCsv
    # Params        :
    /*****************************************************/
    public function exportAsCsv(Request $request, $type = 'D')
    {
        try {
            if ($type == 'D') {$userFile = 'demo';} else {$userFile = 'signup';}
            $fileName = 'demo_users_'.time().'.csv';

            $query = User::where('id','<>','1')->where(['type' => $type])->whereNull('deleted_at');
            $data = $query->get();

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            $columns = array('Full Name', 'Email');
            $callback = function() use($data, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
    
                foreach ($data as $user) {
                    $row['Full Name']       = $user->full_name;
                    $row['Email']           = $user->email;
                    
                    fputcsv($file, array($row['Full Name'], $row['Email']));
                }
                
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);

        } catch (Exception $e) {
            return '';
        } catch (\Throwable $e) {
            return '';
        }
    }

}