<script type="text/javascript">
$(document).ready(function() {
	@if (Route::currentRouteName() == 'admin.role.list')
	// Get list page data
	var getListDataUrl = "{{route('admin.role.list-request')}}";
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
			data: {},
		},
		columns: [
		@if ($isAllow || in_array('role.delete', $allowedRoutes))
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
			{data: 'name', name: 'name'},
		@if ($isAllow || in_array('role.edit', $allowedRoutes) || in_array('role.delete', $allowedRoutes))
			{data: 'action', name: 'action', orderable: false, searchable: false},
		@endif
		],
		columnDefs: [
			{
			@if ($isAllow || in_array('role.delete', $allowedRoutes))
				targets: [ 1 ],
			@else
				targets: [ 0 ],
			@endif
				visible: false,
				searchable: false,
			},
		],
		order: [
		@if ($isAllow || in_array('role.delete', $allowedRoutes))
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

	// Delete section
	$(document).on('click', '.delete', function() {
		var id = $(this).data('id');
		var actionType 	= $(this).data('action-type');
		listActions('role', 'delete', id, actionType, dTable);
	});

	// Bulk Action
	$('.bulkAction').on('click', function() {
		var selectedIds = [];
		$("input:checkbox[class=delete_checkbox]:checked").each(function () {
			selectedIds.push($(this).val());
		});		
		if(selectedIds.length > 0) {
			var actionType = $(this).data('action-type');
			bulkActions('role', 'bulk-actions', selectedIds, actionType, dTable);
		} else {
			toastr.error("@lang('custom_admin.error_no_checkbox_checked')", "@lang('custom_admin.message_error')!");
		}
	});
	@endif

	// Total checkbox count (For Add & Edit page)
	var totalCheckboxCount = $('input[type=checkbox]').length;
	totalCheckboxCount = totalCheckboxCount - 1;
	
	//Top checkbox to select / deselect all "Check" boxes
	$('.mainSelectDeselectAll').click(function(){
		if ($(this).prop('checked') == true) {
			$(".selectDeselectAll").prop('checked', true);
		} else {
			$(".selectDeselectAll").prop('checked', false);
		}
	});

	//Individual section select / deselect
	$('.select_deselect').click(function(){
		var parentRoute = $(this).data('parentroute');
		if ($(this).prop('checked') == true) {
			$("."+parentRoute).prop('checked', true);

			//If total checkbox (except top checkbox) == all checked checkbox then "Check" the Top checkbox
			var totalCheckedCheckbox = $('input[type=checkbox]:checked').length;
			if (totalCheckedCheckbox == totalCheckboxCount) {
				$('.mainSelectDeselectAll').prop('checked', true);
			}
		} else {
			$("."+parentRoute).prop('checked', false);

			//Top checkbox un-check
			$('.mainSelectDeselectAll').prop('checked', false);
		}
	});

	//Particular child checkbox select / deselect
	$(".setPermission").click(function() {
		var routeClass = $(this).data('class');
		var listIndex = $(this).data('listindex');
		var individualSectionCheckboxCount = $('.'+routeClass).length;
		
		if ($(this).prop('checked') == true) {
			//List/Index checkbox "Check"
			$(this).parents('div.section_class').find('input[type=checkbox]:eq(0)').prop('checked', true);

			var childCheckedCheckboxCount = $('.'+routeClass+':checked').length;
			
			//If child checked checkbox count = total checkbox count under individual section
			if (childCheckedCheckboxCount === individualSectionCheckboxCount) {
				//Individual section checkbox "Check"
				$(this).parents('div.individual_section').find('input[type=checkbox]:eq(0)').prop('checked', true);
			}

			//If Total checkbox count == Total checked checkbox count then "Check" the Top checkbox
			if ( ($('input[type=checkbox]').length - 1) == $('input[type=checkbox]:checked').length) {
				$('.mainSelectDeselectAll').prop('checked', true);
			}
		} else {
			//List/index checkbox un-check then "un-check" all child checkbox
			if (listIndex == routeClass+'_list_index') {
				$('.'+routeClass).prop('checked', false);                
			}
			
			//Individual section checkbox "un-check"
			$(this).parents('div.individual_section').find('input[type=checkbox]:eq(0)').prop('checked', false);

			//Top checkbox "un-check"
			$('.mainSelectDeselectAll').prop('checked', false);
		}
	});

});
</script>