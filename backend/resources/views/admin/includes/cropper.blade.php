<script type="text/javascript">
var resize = $('#image-preview').croppie({
    enableExif: true,
    enableOrientation: true,    
    viewport: { // Default { width: 100, height: 100, type: 'square' } 
        width: {{$imageThumbWidth}},
        height: {{$imageThumbHeight}},
        type: 'square' //square
    },
    boundary: {
        width: '100%',
        height: {{$imageContainer}}
    }
});

$('#upload_image').on('change', function () { 
  	var reader = new FileReader();
    reader.onload = function (e) {
      	resize.croppie('bind',{
        	url: e.target.result
      	}).then(function(){
        	console.log('ok');
      	});
    }
    reader.readAsDataURL(this.files[0]);
});

$('.crop_image').on('click', function (ev) {
  	resize.croppie('result', {
    	type: 'canvas',
    	size: 'viewport'
  	}).then(function (img) {
		html = '<img src="' + img + '" />';
		$("#preview-crop-image").html(html);

		// set to uplaod as base64
		$('#image-code-after-crop').val(img);
  	});
});
</script>