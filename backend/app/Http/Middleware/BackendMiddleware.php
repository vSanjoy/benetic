<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;

class BackendMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::guard('admin')->user()) {
            if (isset(\Auth::guard('admin')->user()->type)) {
                if (\Auth::guard('admin')->user()->type == 'SA') {
                    return $next($request);
                } else {
                    if (\Auth::guard('admin')->user()->type == 'A') {
                        $roleIds = [];
                        $userRoles = \Auth::guard('admin')->user()->userRoles;
                        if ($userRoles) {
                            foreach ($userRoles as $role) {
                                $roleIds[] = $role['id'];
                            }
                        }

                        // If "$roleIds" not exist then it should be super admin
                        if (count($roleIds) > 0) {
                            $wholeRouteName = explode('admin.',\Route::currentRouteName());
                            // print_r($wholeRouteName);
                            // echo $currentRouteName =  \Route::currentRouteName(); die;
                            $currentRouteName =  $wholeRouteName[1];

                            // Getting data matched from role_pages (where all route listed) with current route
                            $currentPage = \App\Model\RolePage::where('routeName', $currentRouteName)->first();
                            // dd($currentPage);

                            if ($currentPage) {
                                // checking permission given or not for that route (or current page)
                                $rolePermission = \App\Model\RolePermission::where([
                                                                            'page_id' => $currentPage->id
                                                                        ])
                                                                        ->whereIn('role_id', $roleIds)
                                                                        ->count();
                                if ($rolePermission != 0) {
                                    return $next($request);    
                                } else {
                                    if (strpos($currentRouteName,'change-status') !== false || strpos($currentRouteName,'delete') !== false) {
                                        return response()->json(['title' => trans('custom_admin.message_error').'!', 'message' => trans('custom_admin.error_sufficient_permission'), 'type' => 'error']);
                                    } else {
                                        // $request->session()->flash('alert-danger', trans('custom_admin.error_sufficient_permission'));
                                        toastr()->error(trans('custom_admin.error_sufficient_permission'), trans('custom_admin.message_error').'!');
                                        return \Redirect::route('admin.dashboard');
                                    }
                                }
                            } else {
                                return $next($request);
                            }
                        } else {
                            return $next($request);
                        }
                    }
                }
            }
            toastr()->error(trans('custom_admin.error_please_login'), trans('custom_admin.message_error').'!');
            return redirect()->route('admin.login');
        } else {
            return redirect()->route('admin.login');
        }
    }
}