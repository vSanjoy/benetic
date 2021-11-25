@extends('admin.layouts.app', ['title' => $panelTitle])

@section('content')
    
    @include('admin.includes.breadcrumb')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">                
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header"></div>
                        
                        {{ Form::open(array(
                                        'method'=> 'POST',
                                        'class' => '',
                                        'route' => ['admin.cms.edit-submit', $id],
                                        'name'  => 'updateCmsForm',
                                        'id'    => 'updateCmsForm',
                                        'files' => true,
                                        'autocomplete' => 'off',
                                        'novalidate' => true)) }}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_page_name')<span class="red_star">*</span></label>
                                            {{ Form::text('name', $details['name'], array(
                                                                                'id' => 'title',
                                                                                'placeholder' => '',
                                                                                'class' => 'form-control text-sm',
                                                                                'required' => 'required',
                                                                                'readonly' => true,
                                                                                'disabled' => true,
                                                                                 )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_title')<span class="red_star">*</span></label>
                                            {{ Form::text('title', $details->title, array(
                                                                                'id' => 'title',
                                                                                'placeholder' => '',
                                                                                'class' => 'form-control text-sm',
                                                                                'required' => 'required'
                                                                                 )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_short_title')</label>
                                            {{ Form::textarea('short_title', $details['short_title'], array(
                                                                                'id' => 'short_title',
                                                                                'placeholder' => '',
                                                                                'class' => 'form-control text-sm',
                                                                                'rows' => 4
                                                                                 )) }}
                                        </div>
                                    </div>                                    
                                </div>
                                @if ($cmsId == 1)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_logo_short_title')</label>
                                            {{ Form::textarea('logo_short_title', $details['logo_short_title'], array(
                                                                                'id' => 'logo_short_title',
                                                                                'placeholder' => '',
                                                                                'class' => 'form-control text-sm',
                                                                                'rows' => 4
                                                                                 )) }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_short_description')</label>
                                            {{ Form::textarea('short_description', $details->short_description, array(
                                                                    'id'=>'short_description',
                                                                    'class' => 'form-control' )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_description')</label>
                                            {{ Form::textarea('description', $details->description, array(
                                                                    'id'=>'description',
                                                                    'class' => 'form-control' )) }}
                                        </div>
                                    </div>
                                </div>                                

                            @if ($cmsId != 1 && $cmsId != 6 && $cmsId != 7 && $cmsId != 8)
                                <!-- Start :: Banner section -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="card-header"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_banner_title') @lang('custom_admin.label_title')</label>
                                            {{ Form::text('banner_title', $details->banner_title, array(
                                                                            'id'=>'banner_title',
                                                                            'class' => 'form-control text-sm' )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_banner_title') @lang('custom_admin.label_short_title')</label>
                                            {{ Form::text('banner_short_title', $details->banner_short_title, array(
                                                                                'id' => 'banner_short_title',
                                                                                'placeholder' => '',
                                                                                'class' => 'form-control text-sm'
                                                                                 )) }}
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_banner_title') @lang('custom_admin.label_short_description')</label>
                                            {{ Form::textarea('banner_short_description', $details->banner_short_description, array(
                                                                                'id' => 'banner_short_description',
                                                                                'placeholder' => '',
                                                                                'class' => 'form-control text-sm',
                                                                                'rows' => 4
                                                                                 )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_banner_image')</label>
                                            {{ Form::file('banner_image', array(
                                                                    'id' => 'banner_image',
                                                                    'class' => 'form-control text-sm',
                                                                    'placeholder' => 'Upload Image',
                                                                     )) }}
                                        </div>
                                        @if ($details->banner_image != null)
                                        <div class="form-group">
                                            @if(file_exists(public_path('/images/uploads/cms/'.$details->banner_image))) 
                                                <embed src="{{ asset('images/uploads/cms/'.$details->banner_image) }}"  width=120 />
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                @if ($cmsId == 3 || $cmsId == 4 || $cmsId == 5)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_home_widget_image')</label>
                                            {{ Form::file('home_widget_image', array(
                                                                    'id' => 'home_widget_image',
                                                                    'class' => 'form-control text-sm',
                                                                    'placeholder' => 'Upload Image',
                                                                     )) }}
                                        </div>
                                        @if ($details->home_widget_image != null)
                                        <div class="form-group image_background_logo">
                                            @if(file_exists(public_path('/images/uploads/cms/'.$details->home_widget_image))) 
                                                <embed src="{{ asset('images/uploads/cms/'.$details->home_widget_image) }}"  width=120 />
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                             <div class="card-header"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End :: Banner section -->
                            @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_image')</label>
                                            {{ Form::file('image1', array(
                                                                    'id' => 'image1',
                                                                    'class' => 'form-control text-sm',
                                                                    'placeholder' => 'Upload Image',
                                                                    )) }}
                                        </div>
                                        @if ($details->image1 != null)
                                        <div class="form-group">
                                            @if(file_exists(public_path('/images/uploads/cms/'.$details->image1))) 
                                                <embed src="{{ asset('images/uploads/cms/'.$details->image1) }}"  width=120 />
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <a href="{{ route('admin.cms.list') }}" class="btn bg-gradient-secondary">
                                    <i class="icon fas fa-ban"></i> @lang('custom_admin.btn_cancel')
                                </a>
                                &nbsp;
                                <button type="submit" class="btn bg-gradient-success float-right">
                                    <i class="fas fa-save"></i> @lang('custom_admin.btn_update')
                                </button>
                            </div>
                        {{Form::close()}}
                    </div>
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </div>
    </section>

@endsection