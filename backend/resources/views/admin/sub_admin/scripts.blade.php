<script type="text/javascript">
$(document).ready(function() {
	@if (Route::currentRouteName() == 'admin.subAdmin.list')
	// Get list page data
	var getListDataUrl = "{{route('admin.subAdmin.list-request')}}";
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
					data.phone_no = $('#phone_no').val();
					data.email = $('#email').val();
					data.roleIds = $('#roleIds').val();
				},
	        },
	        columns: [
			@if ($isAllow || in_array('subAdmin.change-status', $allowedRoutes) || in_array('subAdmin.delete', $allowedRoutes))
	            {
					data: 'id',
					orderable: false,
					searchable: false,
					render: function ( data, type, row ) {
						if ( type === 'display' ) {
							return '<div class="icheck-primary d-inline"><input type="checkbox" class="delete_checkbox" id="checkboxInfo_'+row.id+'" value="'+row.id+'"><label for="checkboxInfo_'+row.id+'"></label></div>';
						}
						return data;
					},
				},
			@endif
				{data: 'id', name: 'id'},
	            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
	            {data: 'first_name', name: 'first_name'},
				{data: 'last_name', name: 'last_name'},
				{data: 'email', name: 'email'},
				{data: 'phone_no', name: 'phone_no'},
				{data: 'roles', name: 'roles', orderable: false, searchable: false},
				{data: 'status', name: 'status'},
			@if ($isAllow || in_array('subAdmin.edit', $allowedRoutes) || in_array('subAdmin.delete', $allowedRoutes))
				{data: 'action', name: 'action', orderable: false, searchable: false},
			@endif
	        ],
			columnDefs: [
				{
				@if ($isAllow || in_array('subAdmin.change-status', $allowedRoutes) || in_array('subAdmin.delete', $allowedRoutes))
					targets: [ 1 ],
				@else
					targets: [ 0 ],
				@endif
					visible: false,
					searchable: false,
            	},
			],
	        order: [
			@if ($isAllow || in_array('subAdmin.change-status', $allowedRoutes) || in_array('subAdmin.delete', $allowedRoutes))
				[1, 'desc']
			@else
				[0, 'desc']
			@endif
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

	// Status section
	$(document).on('click', '.status', function() {
		var id 			= $(this).data('id');
		var actionType 	= $(this).data('action-type');
		listActions('subAdmin', 'status', id, actionType, dTable);
	});
	
	// Delete section
	$(document).on('click', '.delete', function() {
		var id = $(this).data('id');
		var actionType 	= $(this).data('action-type');
		listActions('subAdmin', 'delete', id, actionType, dTable);
	});

	// Bulk Action
	$('.bulkAction').on('click', function() {
		var selectedIds = [];
		$("input:checkbox[class=delete_checkbox]:checked").each(function () {
			selectedIds.push($(this).val());
		});		
		if(selectedIds.length > 0) {
			var actionType = $(this).data('action-type');
			bulkActions('subAdmin', 'bulk-actions', selectedIds, actionType, dTable);
		} else {
			toastr.error("@lang('custom_admin.error_no_checkbox_checked')", "@lang('custom_admin.message_error')!");
		}
	});

	// Reset
	$(document).on('click', '.btnReset', function() {
		$('.select2').val('').trigger('change');
    	dTable.search('').draw();
	});
	
	// Search / Filter
	$(document).on('click', '.btnSearch', function() {
		if ($('#phone_no').val() != '' || $('#email').val() != '' || $('#roleIds').val() != '') {
			dTable.draw();
		}
	});

	@endif

});
</script>