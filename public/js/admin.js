/* adding edinamiic element*/
$('.add-new').click(function(e){
    e.preventDefault(e);
    blockHTML = $('.shablon').find('div').html();
    $('<div/>').html(blockHTML)
        .appendTo($('.block-to-add'))
    $('.remove-this').unbind('click');
    $('.remove-this').bind('click',removeEl);
})
$('.remove-this').bind('click',removeEl);
function removeEl(){
    $(this).parent().remove();
}

/* removing edinamiic element*/

$('.remove-slider').bind('click',removeEl);
function removeEl(){
    var uri;
    if($(this).parent().hasClass('thumbnail')){
        uri = '/admin/events/slider'
    }
    if($(this).parent().hasClass('thumbnail')){
        _this = $(this);
        ids = _this.parent().attr('data-id');
        $.ajax({
            type: "POST",
            data: {'slider_id':ids},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: uri,
            success: function(data){
                if(data.success) {
                    alert("Слайдер обновлен");
                    _this.parent().remove();
                } else if (data.error) {
                    alert(data.error);
                }
            },
            error: function (data) {
                alert(data);
            }
        })
    }else {
        $(this).parent().remove();
    }
}
/* Filter Cities by Country */
$('#country').change(function(){
    country = $(this).val();
    $('#city option').each(function(){
        thisCountry =  $(this).attr('data-country');
        $(this).removeAttr('hidden');
        if(country != 0 && country != thisCountry) {
            $(this).attr('hidden','hidden');
        }
    })
})