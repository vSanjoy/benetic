@extends('admin.layouts.login', ['title' => $pageTitle])

@section('content')

    {!! Form::open(array('name'=>'adminLoginForm','route' =>  ['admin.login'], 'id' => 'adminLoginForm')) !!}
        <div class="input-group mb-3">
            {{ Form::text('email', null, array('required','class' => 'form-control text-sm','id' => 'email', 'placeholder' => trans('custom_admin.label_email'))) }}
            <span class="fas fa-envelope form-control-feedback"></span>
        </div>
        <div class="input-group mb-3">
            {{ Form::password('password', array('required','class' => 'form-control text-sm','id' => 'password', 'placeholder' => trans('custom_admin.label_password'))) }}
            <span class="fas fa-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <a href="{{route('admin.forget-password')}}">@lang('custom_admin.label_forgot_password')</a>
                </div>
            </div>
            <div class="col-4">
                <button type="submit" class="btn bg-gradient-warning btn-block btn-loader">@lang('custom_admin.label_sign_in')</button>
            </div>
        </div>
    </form>

@endsection