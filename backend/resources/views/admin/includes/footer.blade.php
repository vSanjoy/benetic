<input type="hidden" name="admin_url" id="admin_url" value="{{ url('/adminpanel') }}" />

<div id="loading">
    <img id="loading-image" src="{{asset('images/admin/'.AdminHelper::LOADER)}}" alt="">
</div>
<div id="dataTableLoading">
    <img id="loading-image" src="{{asset('images/admin/'.AdminHelper::LOADER)}}" alt="">
</div>

<footer class="main-footer">
    <strong>@lang('custom_admin.message_copyright') &copy; {{date('Y')}} <a href="javascript: void(0);">Benetic</a>.</strong> @lang('custom_admin.message_reserved').
    <div class="float-right d-none d-sm-inline-block"></div>
</footer>