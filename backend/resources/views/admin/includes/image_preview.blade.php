<script type="text/javascript">
var _URL = window.URL || window.webkitURL;
$("#image").change(function (e) {
    var file, img;
	var fuData = document.getElementById('image');
    var FileUploadPath1 = fuData.value;
    if (FileUploadPath1 == '') {
        toastr.error("@lang('custom_admin.error_image')", "@lang('custom_admin.message_error')!");
    } else {
      	var Extension = FileUploadPath1.substring(FileUploadPath1.lastIndexOf('.') + 1).toLowerCase();
      	if (Extension == "gif" || Extension == "png" || Extension == "bmp" || Extension == "jpeg" || Extension == "jpg"){
        	if ((file = this.files[0])) {
          		img = new Image();
          		img.onload = function () {            
            		// if(this.width < '1064' || this.height < '342') {
            		//   alert('Minimum upload image size 1065px X 343px');
					//   document.getElementById('image').value="";
					//   document.getElementById('list').src="";
					//   $('#list').hide();
					//   return false;
					// }
					// else{
					$('#list').show();
					var output = document.getElementById('list');
					output.src = URL.createObjectURL(e.target.files[0]);
					document.getElementById('list').style.width = "200px";
					return true;
					//}
          		};
          		img.src = _URL.createObjectURL(file);
        	}
      	} else {
			document.getElementById('image').value="";
			document.getElementById('list').src="";
			$('#list').hide();
        	toastr.error("@lang('custom_admin.error_image')", "@lang('custom_admin.message_error')!");
      	}
    }
});
</script>