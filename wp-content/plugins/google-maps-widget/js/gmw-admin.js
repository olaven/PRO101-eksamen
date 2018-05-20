/*
 * Google Maps Widget
 * (c) Web factory Ltd, 2012 - 2018
 */


jQuery(function($) {
  if (typeof gmw === 'undefined') {
    return;
  }


  // init tabs on settings
  $('#gmw-settings-tabs').tabs({ active: gmw_get_active_tab('gmw-settings-tabs'),
                                 activate: function(event, ui) { gmw_save_active_tab(this); }
  });


  // open promo dialog on settings and address dialog
  $(document).on('click', '.settings_page_gmw_options .open_promo_dialog, .gmw-map-dialog a.open_promo_dialog, .widget .open_promo_dialog', function(e) {
    e.preventDefault();

    gmw_open_promo_dialog($(this).data('target-screen'));

    return false;
  }); // open promo dialog


  // init variables
  if (typeof google != 'undefined') {
    gmw.geocoder = new google.maps.Geocoder();
  }
  gmw.map = gmw.marker = false;


  // init JS for each active widget
  $(".widget-liquid-right [id*='" + gmw.id_base + "-'].widget, .inactive-sidebar [id*='" + gmw.id_base + "'].widget").each(function (i, widget) {
    gmw_init_widget_ui(widget);
  }); // foreach GMW active widget


  // re-init JS on widget update and add
  $(document).on('widget-updated', function(event, widget) {
    id = $(widget).attr('id');
    if (id.indexOf(gmw.id_base) != -1) {
      gmw_init_widget_ui(widget);
    }
  });
  $(document).on('widget-added', function(event, widget) {
    id = $(widget).attr('id');
    if (id.indexOf(gmw.id_base) != -1) {
      gmw_init_widget_ui(widget);
    }
  }); // refresh GUI on widget add/update


  // init JS UI for an individual GMW
  function gmw_init_widget_ui(widget) {
    $('.gmw-select2', widget).select2({ minimumResultsForSearch: 100, width: '331px' });

    // init tabs
    $('.gmw-tabs', widget).tabs({ active: gmw_get_active_tab($('.gmw-tabs', widget).attr('id')),
                 activate: function(event, ui) { gmw_save_active_tab(this); }
    });

    // promo options in dropdown
    $('select', widget).on('change', function(event) {
      gmw_promo_option_change(widget, event);
    });

    // handle dropdown fields that have dependant fields
    $('.gmw_thumb_pin_type', widget).on('change', function(e) {
      gmw_change_pin_type(widget);
    });
    $('.gmw_thumb_link_type', widget).on('change', function(e) {
      gmw_change_link_type(widget);
    });
    gmw_change_pin_type(widget);
    gmw_change_link_type(widget);

    // open address picking map dialog
    $('a.gmw-pick-address', widget).on('click', function(e) {
      e.preventDefault();

      if (typeof wp !== 'undefined' && wp.customize) {
        alert(gmw.customizer_address_picker);
        return false;
      }

      gmw_open_map_dialog($(this).parents('div.widget'), $(this).data('target'));

      return false;
    }); // open address picking map dialog

    // auto-expand textarea
    $('textarea', widget).on('focus', function(e) {
      e.preventDefault();

      $(this).attr('rows', '3');

      return false;
    });
    $('textarea', widget).on('focusout', function(e) {
      e.preventDefault();

      $(this).attr('rows', '1');

      return false;
    });

    // show help when field is focused
    $('input[type="text"], input[type="number"], input[type="url"], select, textarea', widget).on('focus', function(e) {
      gmw_show_pointer(this, widget, true);

    }).on('focusout', function(e) {
      gmw_show_pointer(this, widget, false);
    });
    $('.gmw-select2', widget).on('select2:open', function(e) { gmw_show_pointer(this, widget, true); });
    $('.gmw-select2', widget).on('select2:close', function(e) { gmw_show_pointer(this, widget, false); });
  } // gmw_init_widget_ui


  // display help text when element is in focus
  function gmw_show_pointer(element, widget, show) {
    if (show) {
      help_text = $(element).data('tooltip');

      // skip fields that don't have any help text
      if (!help_text) {
        return;
      }

      help_text = help_text.replace(/(?:\r\n|\r|\n)/g, '<br />');
      help_text = help_text.replace(/_([\w\W][^_]*)_/gi, '<i>$1</i>');
      help_text = help_text.replace(/\*([\w\W][^\*]*)\*/gi, '<b>$1</b>');

      title = $(element).data('title') || $(element).prev('label').html() || gmw.plugin_name;
      title = title.replace(':', '');

      try {
        $(gmw_pointer).pointer('close');
      } catch(err) {}

      if (help_text.indexOf('</a>') != -1) {
        show_dismiss = ' show_dismiss';
      } else {
        show_dismiss = '';
      }

      gmw_pointer = $(element).pointer({
          content: '<h3>' + title + '</h3><p>' + help_text + '</p>',
          position: {
              edge: 'bottom',
              align: 'left'
          },
          width: 400,
          pointerClass: 'wp_pointer gmw_pointer' + show_dismiss
        }).pointer('open');
    } else {
      // hide pointer
      if (help_text.indexOf('</a>') != -1) {
        return;
      }
      try {
        $(gmw_pointer).pointer('close');
      } catch(err) {}
    }
  } // gmw_show_pointer


  // get active tab index from cookie
  function gmw_get_active_tab(el_id) {
    id = parseInt(0 + $.cookie(el_id), 10);
    if (isNaN(id) === true) {
      id = 0;
    }

    return id;
  } // get_active_tab


  // save active tab index to cookie
  function gmw_save_active_tab(elem) {
    $.cookie($(elem).attr('id'), $(elem).tabs('option', 'active'), { expires: 180 });
  } // save_active_tab


  // show/hide custom link field based on user's link type choice
  function gmw_change_link_type(widget) {
    if ($('.gmw_thumb_link_type', widget).val() == 'custom' || $('.gmw_thumb_link_type', widget).val() == 'custom_blank') {
      $('.gmw_thumb_link_section', widget).show();
    } else {
      $('.gmw_thumb_link_section', widget).hide();
    }
  } // link_type


  // show/hide custom pin URL field based on user's pin type choice
  function gmw_change_pin_type(widget) {
    type = $('.gmw_thumb_pin_type', widget).val();
    type = type.replace('-', '_');

    $('p[class^="gmw_thumb_pin_type_"]', widget).hide();
    $('p.gmw_thumb_pin_type_' + type, widget).show();
  } // pin_type


  // open promo dialog on load
  if (window.location.search.search('gmw_open_promo_dialog') != -1) {
    gmw_open_promo_dialog();
  }


  // opens promo dialog when special value is selected in widget's options
  function gmw_promo_option_change(widget, event) {
    if (($(event.target).val()) == '-1') {
      event.stopPropagation();
      event.preventDefault();

      $(event.target).find('option').attr('selected', '');
      $(event.target).find('option:first').attr('selected', 'selected');
      gmw_open_promo_dialog();
    }
  } // promo_option_change


  // on hover for pricing table
  $('#gmw-pricing-table td').hover(
    function() {
      $table = $(this).closest('table');
      $('td', $table).removeClass('hover');
      index = $(this).index();
      $table.find('tr').each(function() {
        $(this).find('td').eq(index).addClass('hover');
      });
    }, function() {
      $table = $(this).closest('table');
      $('td', $table).removeClass('hover');
      $table.find('tr').each(function() {
        $(this).find('td').eq(1).addClass('hover');
      });
    }
  ); // on hover for pricing table


  // buy pro click
  $('div.gmw_goto_activation').on('click', function(e) {
    url = $(this).find('a').attr('href');
    win = window.open(url, '_blank');
    win.focus();

    $('.gmw_promo_dialog_screen').hide();
    $('#gmw_dialog_activate').show();

    return false;
  }); // buy pro click


  // already have a key button click in dialog
  $('.header a.gmw_goto_activation, .gmw-footer-intro a.gmw_goto_activation, .footer a.gmw_goto_activation').on('click', function(e) {
    e.preventDefault();

    $('.gmw_promo_dialog_screen').hide();
    $('#gmw_dialog_activate').show();

    return false;
  }); // already have a key click


  // go to intro button in dialog
  $('.gmw_goto_intro').on('click', function(e) {
    e.preventDefault();

    $('.gmw_promo_dialog_screen').hide();
    $('#gmw_dialog_intro').show();

    return false;
  }); // go to intro click


  // go to PRO features button in dialog
  $('.gmw_goto_pro').on('click', function(e) {
    e.preventDefault();

    $('.gmw_promo_dialog_screen').hide();
    $('#gmw_dialog_pro_features').show();

    return false;
  }); // go to PRO features click


  // go to trial button in dialog
  $('.gmw_goto_trial').on('click', function(e) {
    e.preventDefault();

    $('.gmw_promo_dialog_screen').hide();
    $('#gmw_dialog_trial').show();

    return false;
  }); // go to trial click


  // enter is pressed in license key field
  $('#gmw_code').on('keypress', function(e) {
    if (e.which === 13) {
      e.preventDefault();
      $('#gmw_activate').trigger('click');
      return false;
    }
  }); // enter press


  // check code and activate button in dialog
  $('#gmw_activate').on('click', function(e) {
    e.preventDefault();

    $('#gmw_dialog_activate input.error').removeClass('error');
    $('#gmw_dialog_activate span.error').hide();
    $('#gmw_dialog_activate input').addClass('gmw_spinner').addClass('gmw_disabled');
    $('#gmw_activate').addClass('gmw_disabled');

    $.post(ajaxurl, { 'action': 'gmw_activate', 'code': $('#gmw_code').val(), '_ajax_nonce': gmw.nonce_activate_license_key},
      function(response) {
        if (typeof response != 'object') {
          alert(gmw.undocumented_error);
        } else if (response.success === true) {
          $('.before_activate').hide();
          $('.after_activate').show();
        } else {
          $('#gmw_dialog_activate input').addClass('error');
          $('#gmw_dialog_activate span.error.gmw_code').html(response.data).show();
          $('#gmw_code').focus().select();
        }
      }, 'json')
    .fail(function() {
      alert(gmw.undocumented_error);
    })
    .always(function() {
      $('#gmw_dialog_activate input').removeClass('gmw_spinner').removeClass('gmw_disabled');
      $('#gmw_activate').removeClass('gmw_disabled');
    });

    return false;
  }); // activate button click


  // get trial click
  $('#gmw_start_trial').on('click', function(e) {
    e.preventDefault();

    err = false;
    $('#gmw_dialog_trial input.error').removeClass('error');
    $('#gmw_dialog_trial span.error').hide();
    $('#gmw_dialog_trial input').addClass('gmw_disabled').addClass('gmw_spinner');
    $('#gmw_start_trial').addClass('gmw_disabled');

    if ($('#gmw_name').val().length < 3) {
      $('#gmw_name').addClass('error');
      $('#gmw_dialog_trial span.error.name').show();
      $('#gmw_name').focus().select();

      err = true;
    } // check name

    re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!re.test($('#gmw_email').val())) {
      $('#gmw_email').addClass('error');
      $('#gmw_dialog_trial span.error.email').show();
      $('#gmw_email').focus().select();
      return false;
    }

    if (err) {
      return false;
    }

    $.post(ajaxurl, { 'action': 'gmw_get_trial',
                      'name': $('#gmw_name').val(),
                      'email': $('#gmw_email').val(),
                      '_ajax_nonce': gmw.nonce_get_trial},
      function(response) {
        if (response && response.success == true) {
          $('.before_trial').hide();
          $('.after_trial').show();
        } else if (response && response.success == false && response.data) {
          alert(response.data);
        } else {
          alert(gmw.undocumented_error);
        }
      }, 'json')
    .fail(function() {
      alert(gmw.undocumented_error);
    })
    .always(function() {
      $('#gmw_dialog_trial input').removeClass('gmw_disabled').removeClass('gmw_spinner');
      $('#gmw_start_trial').removeClass('gmw_disabled');
    });

    return false;
  }); // get trial click


  // open promo/activation dialog
  function gmw_open_promo_dialog(target_screen) {
    if (typeof wp !== 'undefined' && wp.customize) {
      alert(gmw.customizer_pro_dialog);
      return false;
    }

    // close address picker
    if ($('#gmw_map_dialog').is(':ui-dialog')) {
      $('#gmw_map_dialog').dialog('close');
    }

    $('.gmw_promo_dialog_screen').hide();
    $('#gmw_dialog_intro').show();

    $('#gmw_promo_dialog').dialog({
        'dialogClass' : 'wp-dialog gmw-dialog',
        'modal' : true,
        'resizable': false,
        'width': 880,
        'title': gmw.plugin_name,
        'autoOpen': false,
        'closeOnEscape': false,
        open: function(event, ui) {
          $(this).siblings().find('span.ui-dialog-title').html(gmw.dialog_promo_title);
          $('.ui-widget-overlay').bind('click', function () { $(this).siblings('.ui-dialog').find('.ui-dialog-content').dialog('close'); });
          $('.gmw_goto_pro').blur();
        },
        close: function(event, ui) {
          // remove open dialog string from URL
          if (window.location.search.search('gmw_open_promo_dialog') != -1) {
            new_url = window.location.href.replace('gmw_open_promo_dialog', '');
            new_url = new_url.replace(/&$/, '');
            window.history.pushState({}, '', new_url);
          }
        }
    }).dialog('open');

    // open specific screen in dialog
    if (target_screen) {
      $('.gmw_promo_dialog_screen').hide();
      $('#' + target_screen).show();
    }
  } // open_promo_dialog


  // recenter dialogs when window resizes
  $(window).resize(function(e) {
    if ($('.ui-dialog #gmw_promo_dialog').is(':visible')) {
      $('#gmw_promo_dialog').dialog('option', 'position', {my: 'center', at: 'center', of: window});
    }
    if ($('.ui-dialog #gmw_map_dialog').is(':visible')) {
      $('#gmw_map_dialog').dialog('option', 'position', {my: 'center', at: 'center', of: window});
    }

    return true;
  }); // recenter dialogs


  // open address picking map dialog
  function gmw_open_map_dialog(widget, target) {
    $('#gmw_map_dialog').dialog({
        'dialogClass' : 'wp-dialog gmw-map-dialog',
        'modal' : true,
        'width': 880,
        'minWidth': 500,
        'minHeight': 500,
        'resizable': true,
        'title': gmw.dialog_map_title,
        'autoOpen': false,
        'closeOnEscape': true,
        open: function(event, ui) {
          $('.ui-widget-overlay').bind('click', function () { $(this).siblings('.ui-dialog').find('.ui-dialog-content').dialog('close'); });
          gmw_init_map($('input[id$="-' + target + '"]', widget).val());
          $('#gmw_map_dialog').data('widget-id', $(widget).attr('id'));
          $('#gmw_map_dialog').data('target', target);
        },
        resizeStop: function(event, ui) {
          $('#gmw_map_dialog').dialog('option', 'position', {my: 'center', at: 'center', of: window});
          $('#gmw_map_canvas').height($('#gmw_map_dialog').dialog('option', 'height') - $('#gmw_map_dialog_footer').height() - 120);
          google.maps.event.trigger(gmw.map, 'resize');
        },
        close: function(event, ui) {}
    }).dialog('open');
  } // open_map_dialog


  function gmw_init_map(address) {
    if (!address) {
      address = 'New York, USA';
    }
    gmw_put_pin(address);
  } // gmw_init_map


  function gmw_put_pin(address) {
    gmw.geocoder.geocode({'address': address}, function(results, status) {
      if (status === google.maps.GeocoderStatus.OK) {
        point = results[0].geometry.location;
        $('#gmw_map_pin_coordinates').val(results[0].geometry.location.lat().toFixed(5) + ', ' + results[0].geometry.location.lng().toFixed(5));
        $('#gmw_map_pin_address').val(results[0].formatted_address);
        gmw.map = new google.maps.Map(document.getElementById('gmw_map_canvas'), {
          zoom: 15,
          center: point,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        gmw.marker = new google.maps.Marker({
          position: point,
          title: 'Drag and drop pin to change the address',
          map: gmw.map,
          draggable: true
        });
        google.maps.event.addListener(gmw.marker, 'dragend', function(e) {
          $('#gmw_map_pin_coordinates').val(e.latLng.lat().toFixed(5) + ', ' + e.latLng.lng().toFixed(5));
          gmw_update_address_by_pos(gmw.marker.getPosition());
        });
        google.maps.event.addListener(gmw.marker, 'drag', function(e) {
          $('#gmw_map_pin_coordinates').val(e.latLng.lat().toFixed(5) + ', ' + e.latLng.lng().toFixed(5));
          $('#gmw_map_pin_address').val('Searching for the closest address ...');
        });
      } else {
        alert('Geocoder was unable to process the address; ' + status);
      }
    });
  } // gmw_put_pin


  // get address from coordinates
  function gmw_update_address_by_pos(point) {
    $('#gmw_map_dialog_address').val('Processing coordinates ...');
    gmw.geocoder.geocode({
      latLng: point
    }, function(responses) {
      if (responses && responses.length > 0) {
        $('#gmw_map_pin_address').val(responses[0].formatted_address);
      } else {
        $('#gmw_map_pin_address').val('Can\'t determine address at this location.');
      }
    });
  } // gmw_update_address_by_pos


  // just close the map dialog
  $('#gmw_close_map_dialog').on('click', function(e) {
    e.preventDefault();

    $('#gmw_map_dialog').dialog('close');

    return false;
  }); // close dialog


  // test API key
  $('.gmw-test-api-key').on('click', function(e) {
    e.preventDefault();
    var button = this;

    api_key = $('#api_key').val();
    if (api_key.length < 30) {
      alert(gmw.bad_api_key);
      return false;
    }

    $(button).addClass('gmw_spinner').addClass('gmw_disabled');

    $.get(ajaxurl, {'action': 'gmw_test_api_key', 'api_key': api_key, '_ajax_nonce': gmw.nonce_test_api_key},
          function(response) {
            if (typeof response == 'object') {
              alert(response.data);
            } else {
              alert(gmw.undocumented_error);
            }
          }, 'json'
    ).fail(function(response) {
      alert(gmw.undocumented_error);
    }).always(function(response) {
      $(button).removeClass('gmw_spinner').removeClass('gmw_disabled');
    });

    return false;
  }); // test api key


}); // onload

if (!Date.now) {
    Date.now = function() { return new Date().getTime(); }
}

function gmw_update_timer() {
  out = '';
  timer = jQuery('.gmw-countdown');

  if (timer.length == 0) {
    clearInterval(gmw_countdown_interval);
  }

  now = Math.round(new Date().getTime()/1000);
  timer_end = jQuery(timer).data('endtime');
  delta = timer_end - now;
  seconds = Math.floor( (delta) % 60 );
  minutes = Math.floor( (delta/60) % 60 );
  hours = Math.floor( (delta/(60*60)) % 24 );

  if (delta <= 0) {
    clearInterval(gmw_countdown_interval);
  }

  if (hours) {
    out += hours + 'h ';
  }
  if (minutes || out) {
    out += minutes + 'min ';
  }
  if (seconds || out) {
    out += seconds + 'sec';
  }
  if (delta <= 0 || !out) {
    out = 'discount is no longer available';
  }

  jQuery(timer).html(out);

  return true;
} // gmw_update_timer

if (jQuery('.gmw-countdown').length) {
  gmw_countdown_interval = setInterval(gmw_update_timer, 1000);
}


/*!
 * jQuery Cookie Plugin v1.3.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as anonymous module.
        define(['jquery'], factory);
    } else {
        // Browser globals.
        factory(jQuery);
    }
}(function ($) {

    var pluses = /\+/g;

    function raw(s) {
        return s;
    }

    function decoded(s) {
        return decodeURIComponent(s.replace(pluses, ' '));
    }

    function converted(s) {
        if (s.indexOf('"') === 0) {
            // This is a quoted cookie as according to RFC2068, unescape
            s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
        }
        try {
            return config.json ? JSON.parse(s) : s;
        } catch(er) {}
    }

    var config = $.cookie = function (key, value, options) {

        // write
        if (value !== undefined) {
            options = $.extend({}, config.defaults, options);

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setDate(t.getDate() + days);
            }

            value = config.json ? JSON.stringify(value) : String(value);

            return (document.cookie = [
                config.raw ? key : encodeURIComponent(key),
                '=',
                config.raw ? value : encodeURIComponent(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path    ? '; path=' + options.path : '',
                options.domain  ? '; domain=' + options.domain : '',
                options.secure  ? '; secure' : ''
            ].join(''));
        }

        // read
        var decode = config.raw ? raw : decoded;
        var cookies = document.cookie.split('; ');
        var result = key ? undefined : {};
        for (var i = 0, l = cookies.length; i < l; i++) {
            var parts = cookies[i].split('=');
            var name = decode(parts.shift());
            var cookie = decode(parts.join('='));

            if (key && key === name) {
                result = converted(cookie);
                break;
            }

            if (!key) {
                result[name] = converted(cookie);
            }
        }

        return result;
    };

    config.defaults = {};

    $.removeCookie = function (key, options) {
        if ($.cookie(key) !== undefined) {
            // Must not alter options, thus extending a fresh object...
            $.cookie(key, '', $.extend({}, options, { expires: -1 }));
            return true;
        }
        return false;
    };

}));