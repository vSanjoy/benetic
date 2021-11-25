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
                                        'route' => ['admin.teamMember.edit-submit', $id],
                                        'name'  => 'updateTeamMemberForm',
                                        'id'    => 'updateTeamMemberForm',
                                        'files' => true,
                                        'autocomplete' => 'off',
                                        'novalidate' => true)) }}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_name')<span class="red_star">*</span></label>
                                            {{ Form::text('name', $details->name, array(
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
                                            {{ Form::text('designation', $details->designation, array(
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
                                            {{ Form::textarea('short_description', $details->short_description, array(
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
                                            {{ Form::text('linkedin_link', $details->linkedin_link, array(
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
                                            <label for="">@lang('custom_admin.label_image')</label>
                                            {{ Form::file('image', array(
                                                                    'id' => 'image',
                                                                    'class' => 'form-control text-sm',
                                                                    'placeholder' => 'Upload Image',
                                                                     )) }}
                                        </div>
                                        @if ($details->image != null)
                                        <div class="form-group">
                                            @if(file_exists(public_path('/images/uploads/team_member/thumbs/'.$details->image)))
                                                <embed src="{{ asset('images/uploads/team_member/thumbs/'.$details->image) }}" height=80 />
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                    <img id="list" style="display: none;" />
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('admin.teamMember.list') }}" class="btn bg-gradient-secondary">
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

@push('scripts')
@include('admin.includes.image_preview')
@endpush