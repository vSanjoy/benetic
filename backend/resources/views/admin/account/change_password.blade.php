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
                                        'route' => ['admin.change-password'],
                                        'name'  => 'updateAdminPassword',
                                        'id'    => 'updateAdminPassword',
                                        'files' => true,
                                        'novalidate' => true)) }}

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_current_password')<span class="red_star">*</span></label>
                                            {{ Form::password('current_password', array(
                                                                'id' => 'current_password',
                                                                'class' => 'form-control text-sm',
                                                                'placeholder' => '',
                                                                'required' => 'required' )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_new_password')<span class="red_star">*</span></label>
                                            {{ Form::password('password', array(
                                                                'id' => 'password',
                                                                'class' => 'form-control text-sm',
                                                                'placeholder' => '',
                                                                'required' => 'required' )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_confirm_password')<span class="red_star">*</span></label>
                                            {{ Form::password('confirm_password', array(
                                                                'id' => 'confirm_password',
                                                                'class' => 'form-control text-sm',
                                                                'placeholder' => '',
                                                                'required' => 'required' )) }}
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