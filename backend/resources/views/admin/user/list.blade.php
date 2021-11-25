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
						@if ($userCount)
							<div class="row">
								<div class="col-12">
								  	<div class="card">
										<div class="card-header d-flex p-0">
									  		<h3 class="card-title p-3">
												<i class="fa fa-download" aria-hidden="true"></i> @lang('custom_admin.label_export')
											</h3>
										</div>
										<div class="card-footer">
											<a href="{{route('admin.user.export',$userType)}}" target="_blank" class="btn bg-gradient-info float-left btnSearch">
												<i class="fa fa-download" aria-hidden="true"></i> @lang('custom_admin.label_export_user_as_csv')
											</a>
										  </div>
								  	</div>
								</div>
							</div>
						@endif

				  			<table id="list-data" class="table table-bordered table-hover">
								<thead>
									<th>@lang('custom_admin.label_id')</th>
									<th class="firstColumn">@lang('custom_admin.label_sr_no')</th>
									<th>@lang('custom_admin.label_full_name')</th>
									<th>@lang('custom_admin.label_email')</th>
									{{-- <th>@lang('custom_admin.label_contact_number')</th> --}}
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
@include('admin.user.scripts')
@endpush