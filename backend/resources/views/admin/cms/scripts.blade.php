<script type="text/javascript">
$(document).ready(function() {
	@if (Route::currentRouteName() == 'admin.cms.list')
	// Get list page data
	var getListDataUrl = "{{route('admin.cms.list-request')}}";
	// $('#dataTableLoading').show();
	var dTable = $('#list-data').on('init.dt', function () {$('#dataTableLoading').hide();}).DataTable({
			destroy: true,
			autoWidth: false,
	        responsive: true,
			processing: true,
			language: {processing: '<img src="{{asset("images/admin/".AdminHelper::LOADER)}}">'},
			serverSide: true,
			ajax: {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
	        	url: getListDataUrl,
				type: 'POST',
				data: function(data) {},
	        },
	        columns: [			
				{data: 'id', name: 'id'},
	            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
	            {data: 'name', name: 'name'},
			@if ($isAllow || in_array('cms.edit', $allowedRoutes))
				{data: 'action', name: 'action', orderable: false, searchable: false},
			@endif
	        ],
			columnDefs: [
				{
					targets: [ 0 ],
					visible: false,
					searchable: false,
            	},
			],
	        order: [
				[0, 'desc']
			]
	});	
	// Prevent alert box from datatable & console error message
	$.fn.dataTable.ext.errMode = 'none';
	$('#list-data').on('error.dt', function (e, settings, techNote, message) {
		$('#dataTableLoading').hide();
		toastr.error(message, "@lang('custom_admin.message_error')");
    });
	@endif

});
</script>