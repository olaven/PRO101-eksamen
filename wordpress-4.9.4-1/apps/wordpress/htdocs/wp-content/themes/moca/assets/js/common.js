(function($) {
$(function() {
  $(window).on( 'scroll', function(){
    if( $(this).scrollTop() > 150 ){
      $('.page_top_btn').addClass('is_show');
    } else {
      $('.page_top_btn').removeClass('is_show');
    }
  } );

  $('.page_top_btn').on('click',function(){
    $( 'body,html' ).stop(true, true).animate({ scrollTop: 0 }, 600);
  });

  $('.g_navi_button').on('click',function(){
    $(this).toggleClass('is_active');
    if( $(this).hasClass('is_active') ){
      $('.fa', this).removeClass('fa-bars').addClass('fa-times');
      $('.g_navi').fadeIn();
    } else {
      $('.g_navi').fadeOut();
      $('.fa', this).removeClass('fa-times').addClass('fa-bars');
    }

  });

  $('.g_navi').on('click',function(){
    $('.g_navi').fadeOut();
    $('.g_navi_button').removeClass('is_active');
    $('.g_navi_button .fa').removeClass('fa-times').addClass('fa-bars');
  });

  $('.widget_recent_entries li:first-child').each(
    function(){
      var $post_date = $(this).find('.post-date');
      if( !$post_date.length ){
        $(this).parent('ul').addClass('no_date');
      }
    }
  );
})
})(jQuery);
