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
									<th>@lang('custom_admin.label_id')</th>
									<th class="firstColumn">@lang('custom_admin.label_sr_no')</th>
									<th>@lang('custom_admin.label_page_name')</th>
								@if ($isAllow || in_array('subAdmin.edit', $allowedRoutes))
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
@include('admin.cms.scripts')
@endpush