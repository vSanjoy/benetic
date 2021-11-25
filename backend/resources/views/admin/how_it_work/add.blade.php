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
                                        'route' => ['admin.howItWork.add-submit'],
                                        'name'  => 'createHowItWorkForm',
                                        'id'    => 'createHowItWorkForm',
                                        'files' => true,
                                        'autocomplete' => 'off',
                                        'novalidate' => true)) }}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_title')<span class="red_star">*</span></label>
                                            {{ Form::text('title', null, array(
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
                                            <label for="">@lang('custom_admin.label_image')<span class="red_star">*</span></label>
                                            {{ Form::file('image', array(
                                                                        'id' => 'image',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => 'Upload Image',
                                                                        'required' => 'required' )) }}
                                        </div>
                                    </div>
                                    <img id="list" style="display: none;" />
                                </div>                                
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('admin.howItWork.list') }}" class="btn bg-gradient-secondary">
                                    <i class="icon fas ban" aria-hidden="true"></i> @lang('custom_admin.btn_cancel')
                                </a>
                                <button type="submit" class="btn bg-gradient-success float-right">
                                    <i class="fas fa-save" aria-hidden="true"></i> @lang('custom_admin.btn_submit')
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

@push('scripts')
@include('admin.includes.image_preview')
@endpush