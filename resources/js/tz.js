var $modal = $('#modal');
var image = document.getElementById('sample_image');
var fileInput = $('#upload_image');
var cropper;
fileInput.change(function(event){
    var files = event.target.files;
    var ext = this.value.match(/\.(.+)$/)[1];
    var done = function (url) {
        image.src = url;
            switch (ext) {
                case 'jpg':
                case 'JPG':
                case 'jpeg':
                case 'png':
                    $modal.modal('show');
                    break;
                default:
                    $(".file-invalid").removeClass('d-none'); 
                    $(".image_area").addClass('photo-invalid'); 
            }   
    };
    if (files && files.length > 0){
            reader = new FileReader();
            reader.onload = function (event) {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
    }
    //check invalid text and remove this text
    if (this.value != ""){
        $(document).find('[name="image"]').parents('label').children('small.text-danger').remove();
    }
});
$(".remove-img").click((index)=>{
    const input = document.getElementById('upload_image');
    const fileListArr = Array.from(input.files);
    fileListArr.splice(index, 1);
    base64data.splice(index,1);
                
    $("#uploaded_image").attr('src','');
    $(".remove-img").hide();
    $(".icon-text").show();
});
$modal.on('shown.bs.modal', function() {
    cropper = new Cropper(image, {
        aspectRatio: 4.8,
        viewMode: 1,
        preview: '.preview'
    });
}).on('hidden.bs.modal', function() {
    cropper.destroy();
    cropper = null;
});

$("#crop").click(function(){
    canvas = cropper.getCroppedCanvas({
        width: 1920,
        height: 400,
    });
    canvas.toBlob(function(blob) {
        // url = URL.createObjectURL(blob);
        var reader = new FileReader();
        
        reader.readAsDataURL(blob); 
        reader.onloadend = function() {
            base64data.push(reader.result);  
            $('#uploaded_image').attr('src', base64data);
            $(".icon-text").hide(); 
        }
    });
    $modal.modal('hide');
});

$('#uploaded_image').hover(function(){
    $('.remove-img').show();
});

$('.select2').select2();

//Date and time picker
$('#start').datetimepicker({ 
    icons: { 
        time: 'far fa-clock',
    },
    format: 'DD-MM-YYYY hh:mm A'
});
$('#end').datetimepicker({ icons: { time: 'far fa-clock' }, format: 'DD-MM-YYYY hh:mm A' });

