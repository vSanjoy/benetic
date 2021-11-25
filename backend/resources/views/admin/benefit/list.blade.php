@extends('admin.layouts.app', ['title' => $panelTitle])

@section('content')

	<!-- Content Header (Page header) -->
    @include('admin.includes.breadcrumb')
  
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">				
				<div class="col-12">
			  		<div class="card card-warning">
						<div class="card-header"></div>
						
						<div class="card-body">
							<table id="list-data" class="table table-bordered table-hover">
								<thead>
								@if ($isAllow || in_array('benefit.change-status', $allowedRoutes) || in_array('benefit.delete', $allowedRoutes))
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
												@if ($isAllow || in_array('benefit.change-status', $allowedRoutes))
													<a class="dropdown-item bulkAction" data-action-type="active">
														<strong>@lang('custom_admin.label_active_selected')</strong>
													</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item bulkAction" data-action-type="inactive">
														<strong>@lang('custom_admin.label_inactive_selected')</strong>
													</a>
												@endif
												@if ($isAllow || (in_array('benefit.change-status', $allowedRoutes) && in_array('benefit.delete', $allowedRoutes)))
													<div class="dropdown-divider"></div>
												@endif
												@if ($isAllow || in_array('benefit.delete', $allowedRoutes))
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
									<th>@lang('custom_admin.label_title')</th>
									<th>@lang('custom_admin.label_page')</th>
									<th class="row_status">@lang('custom_admin.label_status')</th>
								@if ($isAllow || in_array('benefit.change-status', $allowedRoutes) || in_array('benefit.edit', $allowedRoutes) || in_array('benefit.delete', $allowedRoutes))
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
@include('admin.benefit.scripts')
@endpush