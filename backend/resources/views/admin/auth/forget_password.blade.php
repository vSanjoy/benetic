@extends('admin.layouts.login', ['title' => $pageTitle])

@section('content')

    {!! Form::open(array('name'=>'adminForgotPasswordForm','route' =>  ['admin.forget-password'], 'id' => 'adminForgotPasswordForm')) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::text('email', null, array('required','class' => 'form-control text-sm','id' => 'email', 'placeholder' => trans('custom_admin.label_email'))) }}
                </div>
            </div>
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