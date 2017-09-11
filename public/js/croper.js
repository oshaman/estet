$(function() {
/////// Cropper Options set
    var cropper;
    var options = {
        aspectRatio: 3 / 4,
        minContainerWidth: 450,
        minContainerHeight: 450,
        minCropBoxWidth: 250,
        minCropBoxHeight: 250,
        rotatable: false,
        cropBoxResizable: false,
        crop: function(e) {
            $("#cropped_value").val(parseInt(e.detail.width) + "," + parseInt(e.detail.height) + "," + parseInt(e.detail.x) + "," + parseInt(e.detail.y) + "," + parseInt(e.detail.rotate));
        }
    };
    ///// Show cropper on existing Image
    $("body").on("click", "#image_source", function() {
        var src = $("#image_source").attr("src");
        src = src.replace("/thumb", "");
        $('#image_cropper').attr('src', src);
        $('#image_edit').val("yes");
        $("#myModal").modal("show");
    });
///// Destroy Cropper on Model Hide
    $(".modal").on("hide.bs.modal", function() {
        $(this).hasClass('save') ? alert(1) : $('#cropper').val('');

        $(".cropper-container").remove();
        cropper.destroy();
    });
/// Show Cropper on Model Show
    $(".modal").on("show.bs.modal", function() {
        var image = document.getElementById('image_cropper');
        cropper = new Cropper(image, options);
    });
///// Saving Image with Ajax Call
    var prev = false;
    $("body").on("click", "#Save", function() {
        var form_data = $('#FileUpload')[0];
        $.ajax({
            url: "/profile/cropp-image", // Url to which the request is send
            type: "POST",
            mimeType: "multipart/form-data",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: new FormData(form_data), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function(data) // A function to be called if request succeeds
            {
                $("#myModal").modal('hide');
                if(!prev){$(".img-thumbnail").attr('data-oldSrc', $(".img-thumbnail").attr('src')); prev=true }
                $(".img-thumbnail").attr('src', "data:image/jpg;base64," + JSON.parse(data).success);
                $("#cropper_temp").val(JSON.parse(data).path);
            },
            error: function (data) {
                alert(data.errors);
            },
        });
    });
    $('.old-resource').click(function(e){
        e.preventDefault(e);
        $(".img-thumbnail").attr('src', $(".img-thumbnail").attr('data-oldSrc'));
        $("#cropper_temp").val('');
    })
////// When user upload image
    $( "#cropper").on("change", function() {

        var imagecheck = $(this).data('imagecheck'),
            file = this.files[0],
            imagefile = file.type,
            _URL = window.URL || window.webkitURL;
        img = new Image();
        img.src = _URL.createObjectURL(file);
        img.onload = function() {
            var match = ["image/jpeg", "image/png", "image/jpg"];
            if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                alert('Please Select A valid Image File');
                return false;
            } else {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = function() { // set image data as background of div
                    $(document).find('#image_cropper').attr('src', "");
                    $(document).find('#image_cropper').attr('src', this.result);
                    $('#image_edit').val("")
                    $("#myModal").modal("show");
                }
            }
        }
    });
});