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
                                        'route' => ['admin.teamMember.add-submit'],
                                        'name'  => 'createTeamMemberForm',
                                        'id'    => 'createTeamMemberForm',
                                        'files' => true,
                                        'autocomplete' => 'off',
                                        'novalidate' => true)) }}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_name')<span class="red_star">*</span></label>
                                            {{ Form::text('name', null, array(
                                                                                'id' => 'name',
                                                                                'placeholder' => '',
                                                                                'class' => 'form-control text-sm',
                                                                                'required' => 'required'
                                                                                 )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_designation')<span class="red_star">*</span></label>
                                            {{ Form::text('designation', null, array(
                                                                                'id' => 'designation',
                                                                                'placeholder' => '',
                                                                                'class' => 'form-control text-sm',
                                                                                'required' => 'required'
                                                                                 )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_short_description')<span class="red_star">*</span></label>
                                            {{ Form::textarea('short_description', null, array(
                                                                                'id' => 'author_short_description',
                                                                                'placeholder' => '',
                                                                                'class' => 'form-control text-sm',
                                                                                'required' => 'required',
                                                                                'rows' => 5,
                                                                                 )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_linkedin_link')</label>
                                            {{ Form::text('linkedin_link', null, array(
                                                                                'id' => 'linkedin_link',
                                                                                'placeholder' => '',
                                                                                'class' => 'form-control text-sm'
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
                                <a href="{{ route('admin.teamMember.list') }}" class="btn bg-gradient-secondary">
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