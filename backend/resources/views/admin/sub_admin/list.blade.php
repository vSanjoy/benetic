@extends('admin.layouts.app', ['title' => $panelTitle])

@section('content')

	<!-- Content Header (Page header) -->
    @include('admin.includes.breadcrumb')
  
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">				
				<div class="col-12">
			  		<div class="card card-primary">
						<div class="card-header"></div>
						
						<div class="card-body">
							<div class="row">
								<div class="col-12">
								  	<div class="card">
										<div class="card-header d-flex p-0">
									  		<h3 class="card-title p-3">
												<i class="fa fa-filter" aria-hidden="true"></i> @lang('custom_admin.label_search_filter')
											</h3>
										</div>
										<div class="card-body">
									  		<div class="row">
												<div class="col-md-4">
													<label>@lang('custom_admin.label_contact_number')</label>
													<select class="form-control select2" name="phone_no" id="phone_no">
														<option value="">@lang('custom_admin.label_select')</option>
													@foreach($userDropdown as $user)
														<option value="{{$user->phone_no}}">{{$user->phone_no}}</option>
													@endforeach
													</select>
												</div>
												<div class="col-md-4">
													<label>@lang('custom_admin.label_email')</label>
													<select class="form-control select2" name="email" id="email">
														<option value="">@lang('custom_admin.label_select')</option>
													@foreach($userDropdown as $user)
														<option value="{{$user->email}}">{{$user->email}}</option>
													@endforeach 
													</select>
												</div>
												<div class="col-md-4">
													<label>@lang('custom_admin.label_sub_admin_role')</label>
													<select class="form-control select2" name="roleIds" id="roleIds" multiple="multiple">
													@foreach($roleList as $role)
														<option value="{{$role->id}}">{{$role->name}}</option>
													@endforeach 
													</select>
												</div>
											</div>
										</div>
										<div class="card-footer">
											<button type="submit" class="btn bg-gradient-secondary btnReset">
												<i class="fas fa-sync-alt"></i>
												@lang('custom_admin.btn_reset')
											</button>
											<button type="submit" class="btn bg-gradient-info float-right btnSearch">
												<i class="fa fa-search" aria-hidden="true"></i> @lang('custom_admin.btn_search')
											</button>
										  </div>
								  	</div>
								</div>
							</div>

				  			<table id="list-data" class="table table-bordered table-hover">
								<thead>
								@if ($isAllow || in_array('subAdmin.change-status', $allowedRoutes) || in_array('subAdmin.delete', $allowedRoutes))
									<th class="firstColumn">
										<div class="btn-group">
											<button type="button" class="btn btn-default btn-bulkAction">
												<div class="icheck-info d-inline">
													<input type="checkbox" class="checkAll" id="checkboxInfo">
													<label for="checkboxInfo"></label>
												</div>
											</button>
											<button type="button" class="btn btn-default dropdown-toggle dropdown-icon custom-padding0" data-toggle="dropdown">
												<div class="dropdown-menu" role="menu">
												@if ($isAllow || in_array('subAdmin.change-status', $allowedRoutes))
													<a class="dropdown-item bulkAction" data-action-type="active">
														<strong>@lang('custom_admin.label_active_selected')</strong>
													</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item bulkAction" data-action-type="inactive">
														<strong>@lang('custom_admin.label_inactive_selected')</strong>
													</a>
												@endif
												@if ($isAllow || (in_array('subAdmin.change-status', $allowedRoutes) && in_array('subAdmin.delete', $allowedRoutes)))
													<div class="dropdown-divider"></div>
												@endif
												@if ($isAllow || in_array('subAdmin.delete', $allowedRoutes))
													<a class="dropdown-item bulkAction" data-action-type="delete">
														<strong>@lang('custom_admin.label_delete_selected')</strong>
													</a>
												@endif
												</div>
											</button>
										</div>
									</th>
								@endif
									<th>@lang('custom_admin.label_id')</th>
									<th class="firstColumn">@lang('custom_admin.label_sr_no')</th>
									<th>@lang('custom_admin.label_first_name')</th>
									<th>@lang('custom_admin.label_last_name')</th>
									<th>@lang('custom_admin.label_email')</th>
									<th>@lang('custom_admin.label_contact_number')</th>
									<th>@lang('custom_admin.label_sub_admin_role')</th>
									<th class="row_status">@lang('custom_admin.label_status')</th>
								@if ($isAllow || in_array('subAdmin.change-status', $allowedRoutes) || in_array('subAdmin.edit', $allowedRoutes) || in_array('subAdmin.delete', $allowedRoutes))
									<th class="actions">@lang('custom_admin.label_action')</th>
								@endif
								</thead>								
				  			</table>
						</div>
			  		</div>
				</div>
		  	</div>
		</div>
	</section>

@endsection

@push('scripts')
@include('admin.sub_admin.scripts')
@endpush