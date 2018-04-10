/*
 * Google Maps Widget
 * (c) Web factory Ltd, 2012 - 2018
 */


jQuery(function($) {
  if (gmw_data.colorbox_css) {
    $('head').append('<link id="gmw-colorbox" rel="stylesheet" href="' + gmw_data.colorbox_css + '" type="text/css" media="all">');
  }

  // click map to open lightbox
  $('a.gmw-thumbnail-map.gmw-lightbox-enabled').click(function(e) {
    e.preventDefault();

    dialog = $($(this).attr('href'));
    map_width = dialog.data('map-width');
    map_height = dialog.data('map-height');
    map_url = dialog.data('map-iframe-url');
    map_title = dialog.attr('title');
    map_skin = dialog.data('map-skin');
    close_button = Boolean(dialog.data('close-button'));
    show_title = Boolean(dialog.data('show-title'));
    measure_title = parseInt(dialog.data('measure-title'), 10);
    close_overlay = Boolean(dialog.data('close-overlay'));
    close_esc = Boolean(dialog.data('close-esc'));

    // adjust map size if screen is too small
    if (map_width !== '100%' && map_height !== '100%') {
      screen_width = $(window).width() - 75;
      if (screen_width < map_width) {
        map_width = screen_width;
        map_height *= screen_width / map_width;
      }
      screen_height = $(window).height() - 75;
      if (screen_height < map_height) {
        map_height = screen_height;
        map_width *= screen_height / map_height;
      }
      
      map_height += 'px';
      map_width += 'px';
    } // if !fullscreen
    
    if (!show_title) {
      map_title = '';
    }

    content = $(dialog.html());
    content.filter('.gmw-map').html('<iframe data-measure-title="' + measure_title + '" width="100%" height="100%" src="' + map_url + '" allowfullscreen></iframe>');

    $.colorbox({ html: content,
                 title: map_title,
                 width: map_width,
                 height: map_height,
                 scrolling: false,
                 preloading: false,
                 arrowKey: false,
                 className: 'gmw-' + map_skin,
                 closeButton: close_button,
                 overlayClose: close_overlay,
                 escKey: close_esc });

    return false;
  }); // click map to open lightbox
  
  
  // click map to replace img with interactive map
  $('a.gmw-thumbnail-map.gmw-replace-enabled').click(function(e) {
    e.preventDefault();

    dialog = $($(this).attr('href'));
    map_width = dialog.data('map-width');
    map_height = dialog.data('map-height');
    map_url = dialog.data('map-iframe-url');
   
    // adjust map size if screen is too small
    screen_width = $(window).width() - 50;
    if (screen_width < map_width) {
      map_width = screen_width;
      map_height *= screen_width / map_width;
    }
    screen_height = $(window).height() - 50;
    if (screen_height < map_height) {
      map_height = screen_height;
      map_width *= screen_height / map_height;
    }
    
    content = $(dialog.html());
    content.filter('.gmw-map').html('<iframe width="' + map_width + 'px" height="' +  map_height + 'px" src="' + map_url + '" allowfullscreen></iframe>');
    
    $(this).parent('p').prev('p').hide();
    $(this).parent('p').next('p, span.gmw-powered-by').hide();
    $(this).parent('p').replaceWith(content);

    return false;
  }); // click map to replace img with interactive map


  // fix lightbox height when header/footer are used
  $(document).bind('cbox_complete', function(e){
    // test if this is a GMW colorbox
    colorbox = e.currentTarget.activeElement;
    if ($('div[class^="gmw-"]', colorbox).length === 0) {
      return;
    }
    
    measure_title = $('iframe', colorbox).data('measure-title');
    
    if ($('#cboxTitle', colorbox).html() === '') {
      $('#cboxTitle').hide();
      title_height = 0;
    } else {
      title_height = measure_title * parseInt(0 + $('#cboxTitle', colorbox).outerHeight(true), 10);
    }

    // adjust iframe size
    container = parseInt(0 + $('#cboxLoadedContent').height(), 10);
    header = parseInt(0 + $('#cboxLoadedContent div.gmw-header').outerHeight(true), 10);
    footer = parseInt(0 + $('#cboxLoadedContent div.gmw-header').outerHeight(true), 10);
    $('.gmw-map iframe').height((container - header - footer - title_height) + 'px');
  });
}); // onload
