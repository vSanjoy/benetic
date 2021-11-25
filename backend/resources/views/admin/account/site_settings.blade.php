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
                                        'route' => ['admin.site-settings'],
                                        'name'  => 'updateSiteSettingsForm',
                                        'id'    => 'updateSiteSettingsForm',
                                        'files' => true,
                                        'novalidate' => true)) }}

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_from_email')<span class="red_star">*</span></label>
                                            {{ Form::text('from_email', $from_email, array(
                                                                'id' => 'from_email',
                                                                'class' => 'form-control text-sm',
                                                                'placeholder' => '',
                                                                'required' => 'required' )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_to_email')<span class="red_star">*</span></label>
                                            {{ Form::text('to_email', $to_email, array(
                                                                'id' => 'to_email',
                                                                'class' => 'form-control text-sm',
                                                                'placeholder' => '',
                                                                'required' => 'required' )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_website_email')<span class="red_star">*</span></label>
                                            {{ Form::text('website_title', $website_title, array(
                                                                        'id' => 'website_title',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => '',
                                                                        'required' => 'required' )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_website_link')<span class="red_star">*</span></label>
                                            {{ Form::text('website_link', $website_link, array(
                                                                        'id' => 'website_link',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => '',
                                                                        'required' => 'required' )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                            
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_facebook_link')</label>
                                            {{ Form::text('facebook_link', $facebook_link, array(
                                                                        'id' => 'facebook_link',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => '')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="LinkedInLink">@lang('custom_admin.label_linkedin_link')</label>
                                            {{ Form::text('linkedin_link', $linkedin_link, array(
                                                                        'id' => 'linkedin_link',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                            
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="YouTubeLink">@lang('custom_admin.label_youtube_link')</label>
                                            {{ Form::text('youtube_link', $youtube_link, array(
                                                                        'id' => 'youtube_link',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="GooglePlusLink">@lang('custom_admin.label_gplus_link')</label>
                                            {{ Form::text('googleplus_link', $googleplus_link, array(
                                                                        'id' => 'googleplus_link',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="TwitterLink">@lang('custom_admin.label_twitter_link')</label>
                                            {{ Form::text('twitter_link', $twitter_link, array(
                                                                        'id' => 'twitter_link',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_instagram_link')</label>
                                            {{ Form::text('instagram_link', $instagram_link, array(
                                                                        'id' => 'instagram_link',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_pinterest_link')</label>
                                            {{ Form::text('pinterest_link', $pinterest_link, array(
                                                                        'id' => 'pinterest_link',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_rss_link')</label>
                                            {{ Form::text('rss_link', $rss_link, array(
                                                                        'id' => 'rss_link',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_dribbble_link')</label>
                                            {{ Form::text('dribbble_link', $dribbble_link, array(
                                                                        'id' => 'dribbble_link',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_tumblr_link')</label>
                                            {{ Form::text('tumblr_link', $tumblr_link, array(
                                                                        'id' => 'tumblr_link',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_phone_number')</label>
                                            {{ Form::text('phone_no', $phone_no, array(
                                                                        'id' => 'phone_no',
                                                                        'class' => 'form-control text-sm',
                                                                        'rows' => 4,
                                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_address')</label>
                                            {{ Form::textarea('address', $address, array(
                                                                        'id' => 'address',
                                                                        'class' => 'form-control text-sm',
                                                                        'rows' => 4,
                                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_footer_logo')<span class="red_star">*</span></label>
                                            {{ Form::file('image', array(
                                                                        'id' => 'image',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => 'Upload Image' )) }}
                                        </div>
                                        <img id="list" style="display: none;" />
                                        @if ($footer_logo != null)
                                        <div class="form-group image_background_logo">
                                            @if(file_exists(public_path('/images/uploads/cms/'.$footer_logo))) 
                                                <embed src="{{ asset('images/uploads/cms/thumbs/'.$footer_logo) }}" height=50 />
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_footer_text')<span class="red_star">*</span></label>
                                            {{ Form::textarea('footer_text', $footer_text, array(
                                                        'id' => 'footer_text',
                                                        'class' => 'form-control text-sm',
                                                        'rows' => 4,
                                                        'cols' => 4,
                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_copyright_text')<span class="red_star">*</span></label>
                                            {{ Form::text('copyright_text', $copyright_text, array(
                                                        'id' => 'copyright_text',
                                                        'class' => 'form-control text-sm',
                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_tag_line')</label>
                                            {{ Form::textarea('tag_line', $tag_line, array(
                                                        'id' => 'tag_line',
                                                        'class' => 'form-control text-sm',
                                                        'placeholder' => '',
                                                        'rows' => 4,
                                                        'cols' => 4 )) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PhoneNumber">@lang('custom_admin.label_learn_more_video_short_title')</label>
                                            {{ Form::text('learn_more_video_short_title', $learn_more_video_short_title, array(
                                                        'id' => 'learn_more_video_short_title',
                                                        'class' => 'form-control text-sm',
                                                        'placeholder' => '' )) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('custom_admin.label_learn_more_video')<span class="red_star">*</span></label>
                                            {{ Form::file('learn_more_video', array(
                                                                        'id' => 'learn_more_video',
                                                                        'class' => 'form-control text-sm',
                                                                        'placeholder' => 'Upload video' )) }}
                                            <span><small>@lang('custom_admin.label_video_file_types')</small></span>
                                        </div>
                                        @if ($learn_more_video != null)
                                        <div class="form-group">
                                            <a href="{{asset('images/uploads/cms/'.$learn_more_video)}}" download target="_blank"><i class="fa fa-video-camera" aria-hidden="true"></i></a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('admin.dashboard') }}" class="btn bg-gradient-secondary">
                                    <i class="icon fas fa-ban"></i> @lang('custom_admin.btn_cancel')
                                </a>
                                &nbsp;
                                <button type="submit" class="btn bg-gradient-success float-right">
                                    <i class="fas fa-save"></i> @lang('custom_admin.btn_update')
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