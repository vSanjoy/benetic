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
                                        'route' => ['admin.benefit.edit-submit', $id],
                                        'name'  => 'updateBenefitForm',
                                        'id'    => 'updateBenefitForm',
                                        'files' => true,
                                        'autocomplete' => 'off',
                                        'novalidate' => true)) }}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_page')<span class="red_star">*</span></label>
                                            <select name="cms_page_id" id="cms_page_id" class="form-control select2">
                                            @if ($cmsPages->count())
                                                @foreach ($cmsPages as $page)
                                                <option value="{{$page->id}}" @if($page->id == $details->cms_page_id)selected @endif>{{$page->title}}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
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
                                            <label for="">@lang('custom_admin.label_image')</label>
                                            {{ Form::file('image', array(
                                                                    'id' => 'image',
                                                                    'class' => 'form-control text-sm',
                                                                    'placeholder' => 'Upload Image',
                                                                     )) }}
                                        </div>
                                        @if ($details->image != null)
                                        <div class="form-group">
                                            @if(file_exists(public_path('/images/uploads/benefit/'.$details->image))) 
                                                <embed src="{{ asset('images/uploads/benefit/'.$details->image) }}" width=120 />
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                    <img id="list" style="display: none;" />
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('admin.benefit.list') }}" class="btn bg-gradient-secondary">
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