@php
$getAllRoles = AdminHelper::getUserRoleSpecificRoutes();
$isSuperAdmin = false;
if (\Auth::guard('admin')->user()->id == 1 && \Auth::guard('admin')->user()->type == 'SA') {
    $isSuperAdmin = true;
}
// echo '<pre>'; print_r($getAllRoles); die;

$currentPageMergeRoute = explode('admin.', Route::currentRouteName());
if (count($currentPageMergeRoute) > 0) {
    $currentPage = $currentPageMergeRoute[1];
} else {
    $currentPage = Route::currentRouteName();
}
$currentRouteParams = Route::current()->parameters();
@endphp

<aside class="main-sidebar sidebar-dark-warning elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link">
      	<img src="{{asset('images/admin/logo.png')}}" alt="Logo" class="brand-image">
      	<!-- <span class="brand-text font-weight-light">Benetic</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      	<!-- Sidebar user panel (optional) -->
      	<div class="user-panel mt-3 pb-3 mb-3 d-flex">
        	<div class="image">
          		<img src="{{asset('images/admin/dist/img/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
        	</div>
        	<div class="info">
          		<a class="d-block">Admin</a>
        	</div>
      	</div>

      	<!-- Sidebar Menu -->
      	<nav class="mt-2">
        	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item has-treeview @if ($currentPage == 'dashboard')menu-open @endif">
            		<a href="{{ route('admin.dashboard') }}" class="nav-link @if ($currentPage == 'dashboard')active @endif">
              			<i class="nav-icon fas fa-home"></i>
              			<p>@lang('custom_admin.label_dashboard')</p>
            		</a>
				</li>

				<!-- Banner management Start -->
				@php
				$bannerRoutes = ['banner.list','banner.add','banner.edit'];
				@endphp
				@if ( ($isSuperAdmin) || (in_array('banner.list', $getAllRoles)) )
					<li class="nav-item has-treeview @if (in_array($currentPage, $bannerRoutes)) menu-open @endif">
						<a href="#" class="nav-link @if (in_array($currentPage, $bannerRoutes)) active @endif">
							<i class="nav-icon fas fa-images"></i>
							<p>
								@lang('custom_admin.label_banner_management')
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview @if (in_array($currentPage, $bannerRoutes))active @endif">
						@if ( ($isSuperAdmin) || (in_array('banner.list', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $bannerRoutes))active @endif">
								<a href="{{ route('admin.banner.list') }}" class="nav-link @if ($currentPage == 'banner.list')active @endif">
									<i class="far fa-circle nav-icon text-warning"></i>
									<p>@lang('custom_admin.label_list')</p>
								</a>
							</li>
						@endif
						@if ( ($isSuperAdmin) || (in_array('banner.add', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $bannerRoutes))active @endif">
								<a href="{{ route('admin.banner.add') }}" class="nav-link @if ($currentPage == 'banner.add')active @endif">
									<i class="far fa-circle nav-icon text-info"></i>
									<p>@lang('custom_admin.label_add')</p>
								</a>
							</li>
						@endif
						</ul>
					</li>
				@endif
				<!-- Banner management End -->

				<!-- Logo management Start -->
				@php
				$logoRoutes = ['logo.list','logo.add','logo.edit'];
				@endphp
				@if ( ($isSuperAdmin) || (in_array('logo.list', $getAllRoles)) )
					<li class="nav-item has-treeview @if (in_array($currentPage, $logoRoutes)) menu-open @endif">
						<a href="#" class="nav-link @if (in_array($currentPage, $logoRoutes)) active @endif">
							<i class="nav-icon fas fa-tree"></i>
							<p>
								@lang('custom_admin.label_logo_management')
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview @if (in_array($currentPage, $logoRoutes))active @endif">
						@if ( ($isSuperAdmin) || (in_array('logo.list', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $logoRoutes))active @endif">
								<a href="{{ route('admin.logo.list') }}" class="nav-link @if ($currentPage == 'logo.list')active @endif">
									<i class="far fa-circle nav-icon text-warning"></i>
									<p>@lang('custom_admin.label_list')</p>
								</a>
							</li>
						@endif
						@if ( ($isSuperAdmin) || (in_array('logo.add', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $logoRoutes))active @endif">
								<a href="{{ route('admin.logo.add') }}" class="nav-link @if ($currentPage == 'logo.add')active @endif">
									<i class="far fa-circle nav-icon text-info"></i>
									<p>@lang('custom_admin.label_add')</p>
								</a>
							</li>
						@endif
						</ul>
					</li>
				@endif
				<!-- Logo management End -->

				<!-- Benetic turns management Start -->
				@php
				$beneticTurnRoutes = ['beneticTurn.list','beneticTurn.add','beneticTurn.edit'];
				@endphp
				@if ( ($isSuperAdmin) || (in_array('beneticTurn.list', $getAllRoles)) )
					<li class="nav-item has-treeview @if (in_array($currentPage, $beneticTurnRoutes)) menu-open @endif">
						<a href="#" class="nav-link @if (in_array($currentPage, $beneticTurnRoutes)) active @endif">
							<i class="nav-icon fas fa-globe"></i>
							<p>
								@lang('custom_admin.label_benetic_turns_management')
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview @if (in_array($currentPage, $beneticTurnRoutes))active @endif">
						@if ( ($isSuperAdmin) || (in_array('beneticTurn.list', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $beneticTurnRoutes))active @endif">
								<a href="{{ route('admin.beneticTurn.list') }}" class="nav-link @if ($currentPage == 'beneticTurn.list')active @endif">
									<i class="far fa-circle nav-icon text-warning"></i>
									<p>@lang('custom_admin.label_list')</p>
								</a>
							</li>
						@endif
						</ul>
					</li>
				@endif
				<!-- Benetic turns management End -->

				<!-- Benefit management Start -->
				@php
				$benefitRoutes = ['benefit.list','benefit.add','benefit.edit'];
				@endphp
				@if ( ($isSuperAdmin) || (in_array('benefit.list', $getAllRoles)) )
					<li class="nav-item has-treeview @if (in_array($currentPage, $benefitRoutes)) menu-open @endif">
						<a href="#" class="nav-link @if (in_array($currentPage, $benefitRoutes)) active @endif">
							<i class="nav-icon fas fa-star"></i>
							<p>
								@lang('custom_admin.label_benefit_management')
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview @if (in_array($currentPage, $benefitRoutes))active @endif">
						@if ( ($isSuperAdmin) || (in_array('benefit.list', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $benefitRoutes))active @endif">
								<a href="{{ route('admin.benefit.list') }}" class="nav-link @if ($currentPage == 'benefit.list')active @endif">
									<i class="far fa-circle nav-icon text-warning"></i>
									<p>@lang('custom_admin.label_list')</p>
								</a>
							</li>
						@endif
						@if ( ($isSuperAdmin) || (in_array('benefit.add', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $benefitRoutes))active @endif">
								<a href="{{ route('admin.benefit.add') }}" class="nav-link @if ($currentPage == 'benefit.add')active @endif">
									<i class="far fa-circle nav-icon text-info"></i>
									<p>@lang('custom_admin.label_add')</p>
								</a>
							</li>
						@endif
						</ul>
					</li>
				@endif
				<!-- Benefit management End -->

				<!-- How it work management Start -->
				@php
				$howItWorkRoutes = ['howItWork.list','howItWork.add','howItWork.edit'];
				@endphp
				@if ( ($isSuperAdmin) || (in_array('howItWork.list', $getAllRoles)) )
					<li class="nav-item has-treeview @if (in_array($currentPage, $howItWorkRoutes)) menu-open @endif">
						<a href="#" class="nav-link @if (in_array($currentPage, $howItWorkRoutes)) active @endif">
							<i class="nav-icon fas fa-question-circle"></i>
							<p>
								@lang('custom_admin.label_how_it_work_management')
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview @if (in_array($currentPage, $howItWorkRoutes))active @endif">
						@if ( ($isSuperAdmin) || (in_array('howItWork.list', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $howItWorkRoutes))active @endif">
								<a href="{{ route('admin.howItWork.list') }}" class="nav-link @if ($currentPage == 'howItWork.list')active @endif">
									<i class="far fa-circle nav-icon text-warning"></i>
									<p>@lang('custom_admin.label_list')</p>
								</a>
							</li>
						@endif
						</ul>
					</li>
				@endif
				<!-- How it work management End -->

				<!-- Team management Start -->
				@php
				$teamMemberRoutes = ['teamMember.list','teamMember.add','teamMember.edit'];
				@endphp
				@if ( ($isSuperAdmin) || (in_array('team.list', $getAllRoles)) )
					<li class="nav-item has-treeview @if (in_array($currentPage, $teamMemberRoutes)) menu-open @endif">
						<a href="#" class="nav-link @if (in_array($currentPage, $teamMemberRoutes)) active @endif">
							<i class="nav-icon fas fa-user-friends"></i>
							<p>
								@lang('custom_admin.label_team_member_management')
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview @if (in_array($currentPage, $teamMemberRoutes))active @endif">
						@if ( ($isSuperAdmin) || (in_array('teamMember.list', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $teamMemberRoutes))active @endif">
								<a href="{{ route('admin.teamMember.list') }}" class="nav-link @if ($currentPage == 'teamMember.list')active @endif">
									<i class="far fa-circle nav-icon text-warning"></i>
									<p>@lang('custom_admin.label_list')</p>
								</a>
							</li>
						@endif
						@if ( ($isSuperAdmin) || (in_array('teamMember.add', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $teamMemberRoutes))active @endif">
								<a href="{{ route('admin.teamMember.add') }}" class="nav-link @if ($currentPage == 'teamMember.add')active @endif">
									<i class="far fa-circle nav-icon text-info"></i>
									<p>@lang('custom_admin.label_add')</p>
								</a>
							</li>
						@endif
						</ul>
					</li>
				@endif
				<!-- Team management End -->

				<!-- Users management Start -->
				{{-- @php
				$userRoutes = ['user.list'];
				@endphp
				@if ( ($isSuperAdmin) || (in_array('user.list', $getAllRoles)) )
					<li class="nav-item has-treeview @if (in_array($currentPage, $userRoutes)) menu-open @endif">
						<a href="#" class="nav-link @if (in_array($currentPage, $userRoutes)) active @endif">
							<i class="nav-icon fas fa-users"></i>
							<p>
								@lang('custom_admin.label_user_management')
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview @if (in_array($currentPage, $userRoutes))active @endif">
						@if ( ($isSuperAdmin) || (in_array('user.list', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $userRoutes))active @endif">
								<a href="{{ route('admin.user.list','D') }}" class="nav-link @if (isset($currentRouteParams['type']) && $currentRouteParams['type'] == 'D')active @endif">
									<i class="far fa-circle nav-icon text-warning"></i>
									<p>@lang('custom_admin.label_demo_user')</p>
								</a>
							</li>
						@endif
						@if ( ($isSuperAdmin) || (in_array('user.add', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $userRoutes))active @endif">
								<a href="{{ route('admin.user.list','C') }}" class="nav-link @if (isset($currentRouteParams['type']) && $currentRouteParams['type'] == 'C')active @endif">
									<i class="far fa-circle nav-icon text-info"></i>
									<p>@lang('custom_admin.label_sign_up_user')</p>
								</a>
							</li>
						@endif
						</ul>
					</li>
				@endif --}}
				<!-- Users management End -->

				<!-- Sub admin management Start -->
				{{-- @php
				$subAdminRoutes = ['subAdmin.list','subAdmin.add','subAdmin.edit'];
				@endphp
				@if ( ($isSuperAdmin) || (in_array('subAdmin.list', $getAllRoles)) )
					<li class="nav-item has-treeview @if (in_array($currentPage, $subAdminRoutes)) menu-open @endif">
						<a href="#" class="nav-link @if (in_array($currentPage, $subAdminRoutes)) active @endif">
							<i class="nav-icon fa fa-user-plus"></i>
							<p>
								@lang('custom_admin.label_sub_admin_management')
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview @if (in_array($currentPage, $subAdminRoutes))active @endif">
						@if ( ($isSuperAdmin) || (in_array('subAdmin.list', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $subAdminRoutes))active @endif">
								<a href="{{ route('admin.subAdmin.list') }}" class="nav-link @if ($currentPage == 'subAdmin.list')active @endif">
									<i class="far fa-circle nav-icon text-warning"></i>
									<p>@lang('custom_admin.label_list')</p>
								</a>
							</li>
						@endif
						@if ( ($isSuperAdmin) || (in_array('subAdmin.add', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $subAdminRoutes))active @endif">
								<a href="{{ route('admin.subAdmin.add') }}" class="nav-link @if ($currentPage == 'subAdmin.add')active @endif">
									<i class="far fa-circle nav-icon text-info"></i>
									<p>@lang('custom_admin.label_add')</p>
								</a>
							</li>
						@endif
						</ul>
					</li>
				@endif --}}
				<!-- Sub admin management End -->

				<!-- Role management Start -->
				{{-- @php
				$roleRoutes = ['role.list','role.add','role.edit'];
				@endphp
				@if ( ($isSuperAdmin) || (in_array('role.list', $getAllRoles)) )
					<li class="nav-item has-treeview @if (in_array($currentPage, $roleRoutes)) menu-open @endif">
						<a href="#" class="nav-link @if (in_array($currentPage, $roleRoutes))active @endif">
							<i class="nav-icon fa fa-lock"></i>
							<p>
								@lang('custom_admin.label_role_management')
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview @if (in_array($currentPage, $roleRoutes))active @endif">
						@if ( ($isSuperAdmin) || (in_array('role.list', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $roleRoutes))active @endif">
								<a href="{{ route('admin.role.list') }}" class="nav-link @if ($currentPage == 'role.list')active @endif">
									<i class="far fa-circle nav-icon text-warning"></i>
									<p>@lang('custom_admin.label_list')</p>
								</a>
							</li>
						@endif
						@if ( ($isSuperAdmin) || (in_array('role.add', $getAllRoles)) )
							<li class="nav-item @if (in_array($currentPage, $roleRoutes))active @endif">
								<a href="{{ route('admin.role.add') }}" class="nav-link @if ($currentPage == 'role.add')active @endif">
									<i class="far fa-circle nav-icon text-info"></i>
									<p>@lang('custom_admin.label_add')</p>
								</a>
							</li>
						@endif
						</ul>
					</li>
				@endif --}}
				<!-- Role management End -->

			@php
			$siteSettingRoutes = ['site-settings'];
			$cmsRoutes = ['cms.list','cms.edit'];
			@endphp
			@if ( ($isSuperAdmin) || in_array('site-settings', $getAllRoles) || in_array('cms.list', $getAllRoles))
				<li class="nav-header">@lang('custom_admin.label_miscellaneous')</li>
				@if ( ($isSuperAdmin) || in_array('site-settings', $getAllRoles))
				<li class="nav-item @if (in_array($currentPage, $siteSettingRoutes))active @endif">
					<a href="{{ route('admin.site-settings') }}" class="nav-link @if ($currentPage == 'site-settings')active @endif">
						<i class="nav-icon fa fa-cog text-primary"></i>
						<p class="text">@lang('custom_admin.label_site_settings')</p>
					</a>
				</li>
				@endif
				@if ( ($isSuperAdmin) || in_array('cms.list', $getAllRoles))				
					<li class="nav-item @if (in_array($currentPage, $cmsRoutes))active @endif">
						<a href="{{ route('admin.cms.list') }}" class="nav-link @if ($currentPage == 'cms.list' || $currentPage == 'cms.edit')active @endif">
							<i class="nav-icon fa fa-database text-info"></i>
							<p>@lang('custom_admin.label_cms')</p>
						</a>
					</li>
				@endif
			@endif

			</ul>
		</nav>
	</div>
</aside>