$(document).ready(function () {
    $('.horoscope-path').each(function () {
        var h = $(this).height();
        $(this)
            .attr('data-h', h)
            .css({'height': '161px'});
    });

    $('.span-spoiler').click(function () {
        // z = 145
        // if() планшет z = ??
        //else if мобиле z = ??

        $('.horoscope-path').css({'height': 161 + 'px'});
        var h = $(this).parents('.horoscope-description').find('.horoscope-path').attr('data-h');
        var opa = $(this).hasClass('opened');
        $('.span-spoiler.opened').removeClass('opened');

        if (!opa) {
            $(this).addClass('opened');
            $(this).parents('.horoscope-description').find('.horoscope-path').css({'height': h + 'px'});
        }
    });


    $('a[href^="#"]').click(function (event) {
        //отмена стандартной обработки клика по ссылке
        event.preventDefault();
        //идентификатор блока с атрибута href
        var id = $(this).attr('href');
        // высота окна браузера
        var heightpage = $(window).height();
        //высота от начала страницы до блока на который ссылается якорь
        var topel = $(id).offset().top;
        //высота блока, к которому должна прокручиваться страница
        var heightorder = $(id).height();
        //высота, на которую нужно прокрутить страницу
        var positionscroll = topel - heightpage / 2 + heightorder / 2;
        //анимация прокрутки
        $('body,html').animate({scrollTop: positionscroll}, 1500);
    });


    if (device.mobile() || device.tablet()) {
        $('.content-right').css("display", "none");
        $('.contents.block-centr ').addClass('mobile');
    }
});

