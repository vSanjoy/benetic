<script type="text/javascript">
$(document).ready(function() {
	@if (Route::currentRouteName() == 'admin.user.list')
	// Get list page data
	var getListDataUrl = "{{route('admin.user.list-request',$userType)}}";
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
				data: function(data) {					
				},
	        },
	        columns: [
				{data: 'id', name: 'id'},
	            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
	            {data: 'full_name', name: 'full_name'},
				{data: 'email', name: 'email'},
				// {data: 'phone_no', name: 'phone_no'},
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
			],
			pageLength: 25,
			lengthMenu: [[10, 25, 50, 100, 250], [10, 25, 50, 100, 250]],
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