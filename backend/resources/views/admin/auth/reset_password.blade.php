@extends('admin.layouts.login', ['title' => $pageTitle])

@section('content')

    {!! Form::open(array('name'=>'adminResetPasswordForm','route' =>  ['admin.reset-password', $token], 'id' => 'adminResetPasswordForm')) !!}
        <div class="input-group mb-3">
            {{ Form::password('password', array('required','class' => 'form-control text-sm','id' => 'password', 'placeholder' => trans('custom_admin.label_password'))) }}
            <span class="fas fa-lock form-control-feedback"></span>
        </div>
        <div class="input-group mb-3">
            {{ Form::password('confirm_password', array('required','class' => 'form-control text-sm','id' => 'confirm_password', 'placeholder' => trans('custom_admin.label_confirm_password'))) }}
            <span class="fas fa-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <a href="{{route('admin.login')}}">@lang('custom_admin.label_back_to_login')</a>
                </div>
            </div>
            <div class="col-4">
                <button type="submit" class="btn bg-gradient-warning btn-block btn-loader">@lang('custom_admin.btn_submit')</button>
            </div>
        </div>
    {!! Form::close() !!}

@endsection