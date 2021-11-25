<nav class="main-header navbar navbar-expand navbar-dark navbar-gray-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('admin.dashboard')}}" class="nav-link">@lang('custom_admin.label_home')</a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block">
            <a href="{{url('/')}}" target="_blank" class="nav-link">@lang('custom_admin.label_website') <i class="fa fa-external-link" aria-hidden="true"></i></a>
        </li> --}}
    </ul>

    <ul class="navbar-nav ml-auto">
        <!-- User Account -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-power-off" aria-hidden="true"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right user-dropdown-section">
                <div class="card-widget widget-user">              
                    <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username">Super Admin</h3>
                        <h5 class="widget-user-desc">&nbsp;</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="{{asset('images/admin/dist/img/avatar5.png')}}" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        <a href="{{ route('admin.edit-profile') }}" class="btn btn-block btn-primary">@lang('custom_admin.label_profile')</a>
                                    </h5>
                                </div>                            
                            </div>                  
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        <a href="{{ route('admin.change-password') }}" class="custom-anchor btn bg-gradient-secondary">
                                            <i class="fa fa-key" aria-hidden="true"></i>
                                            {{-- @lang('custom_admin.label_change_password') --}}
                                        </a>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        <a href="{{ route('admin.logout') }}" class="btn btn-block bg-gradient-danger">@lang('custom_admin.label_signout')</a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</nav>