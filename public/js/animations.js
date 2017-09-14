/**
 * Created by Админ on 05.09.2017.
 */
/* scroll elements */
$(function(){
    if(window.location.hash) {
        scrollBody(1000);
    };
});
$('.Top-link').click(function(e){
    e.preventDefault(e);
    scrollBody(1000);
});
function scrollBody(tim) {
    $('body,html').animate({
        scrollTop: $(window.location.hash).offset().top - 150 + 'px'
    },tim);
};

/*init lines on scroll*/
function linesOnScroll() {
    $('.line-container').each(function(){
        if(!$(this).parents('aside').hasClass('aside') && !$(this).parent().hasClass('aside-block')){
            w_h = $(window).height();
            winTop = $(window).scrollTop();
            elOffTop = $(this).offset().top;
            line = $(this).find('.vertical-line');
            elOffTop < winTop + w_h - 300 ? ($(this).addClass('active'),line.css({height: line.attr('data-height') + 'px'})) : ($(this).removeClass('active'),line.css({height: 0 + 'px'}));
        }
    });
};
/* lines and words params */
function wordLinePosition(){
    $('.line-container').each(function(){
        if(!$(this).parents('aside').hasClass('aside') && !$(this).parent().hasClass('aside-block')) {
            line = $(this).find('.vertical-line');
            word = $(this).find('h2');
            wordInner = word.html();
            wordFuture = '';
            tran = .1 * wordInner.length;
            for (i = 0; i < wordInner.length; i++) {
                wordFuture += '<span style="right:' + 100 + 'px;  ">' + wordInner[i] + '</span>';
            }
            word.html(wordFuture);
            line.attr('data-height', ($(this).height() - word.width() - 15));
        }
    });
};

setTimeout(function () {
    $(window).scroll(function () {
        linesOnScroll();
        btnToTop();
    });
    wordLinePosition();
    linesOnScroll();
}, 2000);

/*video block lines main page */
$('.video .button-block a').hover(function () {
    $(this).parent().addClass('active');
    $(this).parent().siblings('.articles-horizontal').addClass('active');
}).mouseleave(function () {
    $(this).parent().removeClass('active');
    $(this).parent().siblings('.articles-horizontal').removeClass('active');
});

$('.content .button-block a').hover(function () {
    $(this).parent().addClass('active');
    $(this).parents('.content').addClass('active');
}).mouseleave(function () {
    $(this).parent().removeClass('active');
    $(this).parents('.content').removeClass('active');
});
if ($('.slider').length) {
    k = new SliderMain($('.slider'), $('.slider article'));
}
if ($('.slide-meropryyatyya').length) {
    k = new SliderMain($('.slide-meropryyatyya'), $('.slide-meropryyatyya img'));
}
/* s;ider main page */
function SliderMain(slider, slides) {
    el = slider
    el.slider = slider;
    el.slides = slides;
    el.sliderRemote = sliderRemote
    el.sliderEvents = sliderEvents
    el.autoslide = autoslide
    el.sliderGo = sliderGo


    curr = 0;
    canGo = true;

    function sliderRemote() {
        dots = '';
        for (i = 0; i < el.slides.length; i++) {
            dots += i == 0 ? '<div class="dot active" data-id="' + i + '"></div>' : '<div class="dot" data-id="' + i + '"></div>';
        }

        $('<div />')
            .addClass('slider-nav')
            .appendTo(this.slider);
        $('.slider-nav').html('<div class="arr-slider prev-slide"><</div><div class="dots">' + dots + '</div><div class="arr-slider next-slide">></<div>')
        sliderEvents();
        autoslide(0);

    }

    el.sliderRemote();


    function sliderEvents() {
        var stopAuto;
        $('.arr-slider').click(function () {
            $(this).hasClass('prev-slide') ? (curr -= 1, curr < 0 ? curr = el.slides.length - 1 : '') : (curr += 1, curr == el.slides.length ? curr = 0 : '');
            canGo = false;
            clearTimeout(stopAuto);
            stopAuto = setTimeout(function () {
                canGo = true;
                autoslide(1);
            }, 4000);

            sliderGo();
        });
        $('.dot').click(function () {
            curr = $(this).attr('data-id');
            canGo = false;
            clearTimeout(stopAuto);
            stopAuto = setTimeout(function () {
                canGo = true;
                autoslide(1);
            }, 4000);
            sliderGo();
        });
    };

    function autoslide(int) {
        if (!canGo) {
            window.cancelAnimationFrame(autoslide);
            return true
        }
        ;
        int ? curr += 1 : '';
        curr >= el.slides.length ? curr = 0 : '';

        setTimeout(function () {
            window.requestAnimationFrame(autoslide)
        }, 4000);
        sliderGo();
    }
    function sliderGo() {
        slides.removeClass('active');
        slides.eq(curr).addClass('active');
        $('.dot').removeClass('active');
        $('.dot').eq(curr).addClass('active');
    };

};

/* switch patient */

function switchSites() {
    $('.doctor,.checkbox-label').click(function () {
        $('#checkbox1').removeClass('active');
        $('.wrap-pop').addClass('active');
        $('#checkbox1').prop('checked', 'bff ');
    });
    $('.close-pop, .pop-bg').click(function () {
        $('#checkbox1').addClass('active');
        $('.wrap-pop').removeClass('active');
    });
};switchSites();

/* Capture */
$('.reload').click(function () {
    $.ajax({
        url: 'http://39.j2landing.com/captcha',
        success: function (data) {
            img = document.getElementById("captcha");
            img.src = "http://39.j2landing.com/captcha";
        }
    });

});

/* to top */
function btnToTop() {
    if ($('body').scrollTop() > window.innerHeight) {
        $('.wrap-top-top').css({'opacity': 1, 'height': 'auto', 'width': 'auto'})
    } else {
        $('.wrap-top-top').css({'opacity': 0, 'height': '0', 'width': '0'});
    }
};btnToTop();
$('.wrap-top-top').click(function () {
    $('body,html').animate({scrollTop: 0 + 'px'}, 500);
});

/* raiting */
$('.top-rating span').click(function () {
    ind = ($(this).index() - 5) * (-1);
    dataId = $(this).parent().attr('data-id');
    dataSource = $(this).parent().attr('data-source');
    token = $(this).parent().attr('data-token');
    $.ajax({
        url: '/ratio',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        data: ({
            data_id: dataId,
            source_id: dataSource,
            ratio: ind
        }),
        success: function (data) {

            if (data['success']) {
                avg = data['success'][0]['avg'];
                count = data['success'][0]['count'];
                str = avg + '/' + count + '- (голосов - ' + count + ')';
                $('.rating p').html(str)
            }
        }
    });
});
