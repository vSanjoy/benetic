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
                                        'route' => ['admin.edit-profile'],
                                        'name'  => 'updateProfileForm',
                                        'id'    => 'updateProfileForm',
                                        'files' => true,
                                        'novalidate' => true)) }}

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_full_name')<span class="red_star">*</span></label>
                                            {{ Form::text('full_name', $adminDetail->full_name, array(
                                                                'id' => 'full_name',
                                                                'placeholder' => '',
                                                                'class' => 'form-control text-sm',
                                                                'required' => 'required'
                                                                )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_phone_number')<span class="red_star">*</span></label>
                                            {{ Form::text('phone_no', $adminDetail->phone_no, array(
                                                                'id' => 'phone_no',
                                                                'placeholder' => '',
                                                                'class' => 'form-control text-sm',
                                                                'required' => 'required'
                                                                )) }}
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-footer">                                
                                <a href="{{ route('admin.dashboard') }}" class="btn bg-gradient-secondary">
                                    <i class="icon fas fa-ban" aria-hidden="true"></i> @lang('custom_admin.btn_cancel')
                                </a>
                                &nbsp;
                                <button type="submit" class="btn bg-gradient-success float-right">
                                    <i class="fas fa-save" aria-hidden="true"></i> @lang('custom_admin.btn_update')
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