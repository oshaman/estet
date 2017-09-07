/**
 * Created by Админ on 05.09.2017.
 */

/*init lines on scroll*/
function linesOnScroll() {
    $('.line-container').each(function () {
        w_h = $(window).height();
        winTop = $(window).scrollTop();
        elOffTop = $(this).offset().top;
        line = $(this).find('.vertical-line');
        elOffTop < winTop + w_h - 300 ? ($(this).addClass('active'), line.css({height: line.attr('data-height') + 'px'})) : ($(this).removeClass('active'), line.css({height: 0 + 'px'}));
    });
};

/* lines and words params */
function wordLinePosition() {
    $('.line-container').each(function () {
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
    });
};

setTimeout(function () {
    $(window).scroll(function () {
        linesOnScroll();
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

/* s;ider main page */
function sliderMain() {
    slider = $('.slider');
    slides = $('.slider article');
    curr = 0;
    canGo = true;

    function sliderRemote() {
        dots = '';
        for (i = 0; i < slides.length; i++) {
            dots += i == 0 ? '<div class="dot active" data-id="' + i + '"></div>' : '<div class="dot" data-id="' + i + '"></div>';
        }

        $('<div />')
            .addClass('slider-nav')
            .appendTo(slider);
        $('.slider-nav').html('<div class="arr-slider prev-slide"></div><div class="dots">' + dots + '</div><div class="arr-slider next-slide"></div>')
        sliderEvents();
        autoslide(0);

    };sliderRemote();


    function sliderEvents() {
        var stopAuto;
        $('.arr-slider').click(function () {
            $(this).hasClass('prev-slide') ? (curr -= 1, curr < 0 ? curr = slides.length - 1 : '') : (curr += 1, curr == slides.length ? curr = 0 : '');
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
        curr >= slides.length ? curr = 0 : '';

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

};sliderMain();

/* switch patient */

function switchSites() {
    $('.doctor,.checkbox-label').click(function () {
        $('#checkbox1').removeClass('active');
        $('.wrap-pop').addClass('active');
    });
    $('.close-pop, .pop-bg').click(function () {
        $('#checkbox1').addClass('active');
        $('.wrap-pop').removeClass('active');
    });
};switchSites();

