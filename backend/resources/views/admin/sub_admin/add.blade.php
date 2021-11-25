@extends('admin.layouts.app', ['title' => $panelTitle])

@section('content')
    
    @include('admin.includes.breadcrumb')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">                
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header"></div>
                        
                        {{ Form::open(array(
                                        'method'=> 'POST',
                                        'class' => '',
                                        'route' => ['admin.subAdmin.add-submit'],
                                        'name'  => 'createSubAdminForm',
                                        'id'    => 'createSubAdminForm',
                                        'files' => true,
                                        'autocomplete' => 'off',
                                        'novalidate' => true)) }}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_first_name')<span class="red_star">*</span></label>
                                            {{ Form::text('first_name', null, array(
                                                                                'id' => 'first_name',
                                                                                'placeholder' => '',
                                                                                'class' => 'form-control text-sm',
                                                                                'required' => 'required'
                                                                                 )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_last_name')<span class="red_star">*</span></label>
                                            {{ Form::text('last_name', null, array(
                                                                                'id' => 'last_name',
                                                                                'class' => 'form-control text-sm',
                                                                                'placeholder' => '',
                                                                                'required' => 'required' )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_email')<span class="red_star">*</span></label>
                                            {{ Form::text('email', null, array(
                                                                            'id' => 'email',
                                                                            'placeholder' => '',
                                                                            'class' => 'form-control text-sm',
                                                                            'required' => 'required'
                                                                             )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="titleArabic">@lang('custom_admin.label_contact_number')</label>
                                            {{ Form::text('phone_no', null, array(
                                                                        'id' => 'phone_no',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => '',
                                                                        'required' => 'required' )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('custom_admin.label_sub_admin_role')<span class="red_star">*</span></label>
                                            <select class="form-control select2" id="role" name="role[]" multiple="multiple">
                                        @if (count($roleList) > 0)
                                            @foreach ($roleList as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        @endif                                
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('admin.subAdmin.list') }}" class="btn bg-gradient-secondary">
                                    <i class="icon fas fa-ban" aria-hidden="true"></i> @lang('custom_admin.btn_cancel')
                                </a>
                                &nbsp;
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