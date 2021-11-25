<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $pageTitle }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">@lang('custom_admin.label_home')</a></li>
				@if (isset($breadcrumb) && count($breadcrumb) > 0)
					<li class="breadcrumb-item"><a href="{{route($breadcrumb['module_url'])}}">{{$breadcrumb['module_title']}}</a></li>
				@endif
					<li class="breadcrumb-item active">{{ $pageTitle }}</li>
				</ol>
            </div>
        </div>
    </div>
</section>