$(window).on('load', function () {
  var container = $('.container');
  var w = $(window).width();
  if (w >= 768) {
    $('.interesting-facts .articles-vertical').mCustomScrollbar();
  } else {
    container.find('.interesting-facts article').each(function (i) {
      console.log(i);
      if (i > 2) {
        $(this).css('display', 'none')
      }
    })
  }
});
