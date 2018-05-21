<?php

/*
Plugin Name: Google Language Translator
Plugin URI: http://wp-studio.net/
Version: 5.0.48
Description: The MOST SIMPLE Google Translator plugin.  This plugin adds Google Translator to your website by using a single shortcode, [google-translator]. Settings include: layout style, hide/show specific languages, hide/show Google toolbar, and hide/show Google branding. Add the shortcode to pages, posts, and widgets.
Author: Rob Myrick
Author URI: http://wp-studio.net/
*/

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include( plugin_dir_path( __FILE__ ) . 'widget.php');

class google_language_translator {

  public $languages_array;

  public function __construct() {

    $this->languages_array = array (
      'af' => 'Afrikaans',
      'sq' => 'Albanian',
      'am' => 'Amharic',
      'ar' => 'Arabic',
      'hy' => 'Armenian',
      'az' => 'Azerbaijani',
      'eu' => 'Basque',
      'be' => 'Belarusian',
      'bn' => 'Bengali',
      'bs' => 'Bosnian',
      'bg' => 'Bulgarian',
      'ca' => 'Catalan',
      'ceb' => 'Cebuano',
      'ny' => 'Chichewa',
      'zh-CN' => 'Chinese (Simplified)',
      'zh-TW' => 'Chinese (Traditional)',
      'co' => 'Corsican',
      'hr' => 'Croatian',
      'cs' => 'Czech',
      'da' => 'Danish',
      'nl' => 'Dutch',
      'en' => 'English',
      'eo' => 'Esperanto',
      'et' => 'Estonian',
      'tl' => 'Filipino',
      'fi' => 'Finnish',
      'fr' => 'French',
      'fy' => 'Frisian',
      'gl' => 'Galician',
      'ka' => 'Georgian',
      'de' => 'German',
      'el' => 'Greek',
      'gu' => 'Gujarati',
      'ht' => 'Haitian',
      'ha' => 'Hausa',
      'haw' => 'Hawaiian',
      'iw' => 'Hebrew',
      'hi' => 'Hindi',
      'hmn' => 'Hmong',
      'hu' => 'Hungarian',
      'is' => 'Icelandic',
      'ig' => 'Igbo',
      'id' => 'Indonesian',
      'ga' => 'Irish',
      'it' => 'Italian',
      'ja' => 'Japanese',
      'jw' => 'Javanese',
      'kn' => 'Kannada',
      'kk' => 'Kazakh',
      'km' => 'Khmer',
      'ko' => 'Korean',
      'ku' => 'Kurdish',
      'ky' => 'Kyrgyz',
      'lo' => 'Lao',
      'la' => 'Latin',
      'lv' => 'Latvian',
      'lt' => 'Lithuanian',
      'lb' => 'Luxembourgish',
      'mk' => 'Macedonian',
      'mg' => 'Malagasy',
      'ml' => 'Malayalam',
      'ms' => 'Malay',
      'mt' => 'Maltese',
      'mi' => 'Maori',
      'mr' => 'Marathi',
      'mn' => 'Mongolian',
      'my' => 'Myanmar (Burmese)',
      'ne' => 'Nepali',
      'no' => 'Norwegian',
      'ps' => 'Pashto',
      'fa' => 'Persian',
      'pl' => 'Polish',
      'pt' => 'Portuguese',
      'pa' => 'Punjabi',
      'ro' => 'Romanian',
      'ru' => 'Russian',
      'sr' => 'Serbian',
      'sn' => 'Shona',
      'st' => 'Sesotho',
      'sd' => 'Sindhi',
      'si' => 'Sinhala',
      'sk' => 'Slovak',
      'sl' => 'Slovenian',
      'sm' => 'Samoan',
      'gd' => 'Scots Gaelic',
      'so' => 'Somali',
      'es' => 'Spanish',
      'su' => 'Sundanese',
      'sw' => 'Swahili',
      'sv' => 'Swedish',
      'tg' => 'Tajik',
      'ta' => 'Tamil',
      'te' => 'Telugu',
      'th' => 'Thai',
      'tr' => 'Turkish',
      'uk' => 'Ukrainian',
      'ur' => 'Urdu',
      'uz' => 'Uzbek',
      'vi' => 'Vietnamese',
      'cy' => 'Welsh',
      'xh' => 'Xhosa',
      'yi' => 'Yiddish',
      'yo' => 'Yoruba',
      'zu' => 'Zulu',
    );
	  
	$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
    define('PLUGIN_VER', $plugin_data['Version']);

    register_activation_hook( __FILE__, array(&$this,'glt_activate'));
    register_deactivation_hook( __FILE__, array(&$this,'glt_deactivate'));

    add_action( 'admin_menu', array( &$this, 'add_my_admin_menus'));
    add_action('admin_init',array(&$this, 'initialize_settings'));
    add_action('wp_head',array(&$this, 'load_css'));
    add_action('wp_footer',array(&$this, 'footer_script'));
    add_shortcode( 'google-translator',array(&$this, 'google_translator_shortcode'));
    add_shortcode( 'glt', array(&$this, 'google_translator_menu_language'));
    add_filter('widget_text','do_shortcode');
    add_filter('walker_nav_menu_start_el', array(&$this,'menu_shortcodes') , 10 , 2);
    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'glt_settings_link') );

    if (!is_admin()) {
      add_action('wp_enqueue_scripts',array(&$this, 'flags'));
    }
  }

  public function glt_activate() {
    add_option('googlelanguagetranslator_active', 1);
    add_option('googlelanguagetranslator_language','en');
    add_option('googlelanguagetranslator_flags', 1);
    add_option('language_display_settings',array ('en' => 1));
    add_option('googlelanguagetranslator_translatebox','yes');
    add_option('googlelanguagetranslator_display','Vertical');
    add_option('googlelanguagetranslator_toolbar','Yes');
    add_option('googlelanguagetranslator_showbranding','Yes');
    add_option('googlelanguagetranslator_flags_alignment','flags_left');
    add_option('googlelanguagetranslator_analytics', 0);
    add_option('googlelanguagetranslator_analytics_id','');
    add_option('googlelanguagetranslator_css','');
    add_option('googlelanguagetranslator_multilanguage',0);
    add_option('googlelanguagetranslator_floating_widget','yes');
    add_option('googlelanguagetranslator_flag_size','18');
    add_option('googlelanguagetranslator_flags_order','');
    add_option('googlelanguagetranslator_english_flag_choice','');
    add_option('googlelanguagetranslator_spanish_flag_choice','');
    add_option('googlelanguagetranslator_portuguese_flag_choice','');
    add_option('googlelanguagetranslator_floating_widget_text', 'Translate &raquo;');
    add_option('googlelanguagetranslator_floating_widget_text_allow_translation', 0);
    delete_option('googlelanguagetranslator_manage_translations',0);
    delete_option('flag_display_settings');
  }

  public function glt_deactivate() {
    delete_option('flag_display_settings');
    delete_option('googlelanguagetranslator_language_option');
  }

  public function glt_settings_link ( $links ) {
    $settings_link = array(
      '<a href="' . admin_url( 'options-general.php?page=google_language_translator' ) . '">Settings</a>',
    );
   return array_merge( $links, $settings_link );
  }

  public function add_my_admin_menus(){
    $p = add_options_page('Google Language Translator', 'Google Language Translator', 'manage_options', 'google_language_translator', array(&$this, 'page_layout_cb'));

    add_action( 'load-' . $p, array(&$this, 'load_admin_js' ));
  }

  public function load_admin_js(){
    add_action( 'admin_enqueue_scripts', array(&$this, 'enqueue_admin_js' ));
    add_action('admin_footer',array(&$this, 'footer_script'));
  }

  public function enqueue_admin_js(){
	wp_enqueue_script( 'jquery-ui-core');
    wp_enqueue_script( 'jquery-ui-sortable');
	wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'scripts-admin', plugins_url('js/scripts-admin.js',__FILE__), array('jquery', 'wp-color-picker'), PLUGIN_VER, true);
	wp_enqueue_script( 'scripts', plugins_url('js/scripts.js',__FILE__), array('jquery', 'wp-color-picker'), PLUGIN_VER, true);
	wp_enqueue_script( 'scripts-google', '//translate.google.com/translate_a/element.js?cb=GoogleLanguageTranslatorInit', array('jquery'), null, true);
	  
	wp_enqueue_style( 'style.css', plugins_url('css/style.css', __FILE__),'', PLUGIN_VER,'');

    if (get_option ('googlelanguagetranslator_floating_widget') == 'yes') {
      wp_enqueue_style( 'glt-toolbar-styles', plugins_url('css/toolbar.css', __FILE__),'', PLUGIN_VER,'' );
    }
  }

  public function flags() {
    wp_enqueue_script( 'scripts', plugins_url('js/scripts.js',__FILE__), array('jquery'), PLUGIN_VER, true);
	wp_enqueue_script( 'scripts-google', '//translate.google.com/translate_a/element.js?cb=GoogleLanguageTranslatorInit', array('jquery'), null, true);
	wp_enqueue_style( 'google-language-translator', plugins_url('css/style.css', __FILE__), '', PLUGIN_VER, '');

    if (get_option ('googlelanguagetranslator_floating_widget') == 'yes') {
      wp_enqueue_style( 'glt-toolbar-styles', plugins_url('css/toolbar.css', __FILE__), '', PLUGIN_VER, '');
    }
  }

  public function load_css() {
    include( plugin_dir_path( __FILE__ ) . '/css/style.php');
  }

  public function google_translator_shortcode() {

    if (get_option('googlelanguagetranslator_display')=='Vertical' || get_option('googlelanguagetranslator_display')=='SIMPLE'){
        return $this->googlelanguagetranslator_vertical();
    }
    elseif(get_option('googlelanguagetranslator_display')=='Horizontal'){
        return $this->googlelanguagetranslator_horizontal();
    }
  }

  public function googlelanguagetranslator_included_languages() {
	$get_language_choices = get_option ('language_display_settings');

	foreach ($get_language_choices as $key=>$value):
      if ($value == 1):
        $items[] = $key;
	  endif;
	endforeach;

	$comma_separated = implode(",",array_values($items));
    $lang = ", includedLanguages:'".$comma_separated."'";
	return $lang;
  }

  public function analytics() {
    if ( get_option('googlelanguagetranslator_analytics') == 1 ) {
	  $analytics_id = get_option('googlelanguagetranslator_analytics_id');
	  $analytics = "gaTrack: true, gaId: '".$analytics_id."'";

          if (!empty ($analytics_id) ):
	    return ', '.$analytics;
          endif;
    }
  }

  public function menu_shortcodes( $item_output,$item ) {
    if ( !empty($item->description)) {
      $output = do_shortcode($item->description);

      if ( $output != $item->description )
        $item_output = $output;
      }
    return $item_output;
  }

  public function google_translator_menu_language($atts, $content = '') {
    extract(shortcode_atts(array(
      "language" => 'Spanish',
      "label" => 'Spanish',
      "image" => 'no',
      "text" => 'yes',
      "image_size" => '24',
      "label" => 'Espa&ntilde;ol'
    ), $atts));

    $default_language = get_option('googlelanguagetranslator_language');
    $english_flag_choice = get_option('googlelanguagetranslator_english_flag_choice');
    $spanish_flag_choice = get_option('googlelanguagetranslator_spanish_flag_choice');
    $portuguese_flag_choice = get_option('googlelanguagetranslator_portuguese_flag_choice');
    $language_code = array_search($language,$this->languages_array);
    $language_name = $language;
    $language_name_flag = $language_name;

    if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
	  $language_name_flag = 'canada';
	}
	if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
          $language_name_flag = 'united-states';
	}
	if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
	  $language_name_flag = 'mexico';
	}
	if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
	  $language_name_flag = 'brazil';
	}

    return "<a class='nturl notranslate ".$language_code." ".$language_name_flag." single-language flag' title='".$language."'>".($image=='yes' ? "<span class='flag size".$image_size."'></span>" : '') .($text=='yes' ? $label : '')."</a>";
  }

  public function footer_script() {
	global $vertical;
	global $horizontal;
    global $shortcode_started;
	$layout = get_option('googlelanguagetranslator_display');
    $default_language = get_option('googlelanguagetranslator_language');
    $language_choices = $this->googlelanguagetranslator_included_languages();
    $new_languages_array_string = get_option('googlelanguagetranslator_flags_order');
    $new_languages_array = explode(",",$new_languages_array_string);
    $new_languages_array_codes = array_values($new_languages_array);
    $new_languages_array_count = count($new_languages_array);
    $english_flag_choice = get_option('googlelanguagetranslator_english_flag_choice');
    $spanish_flag_choice = get_option('googlelanguagetranslator_spanish_flag_choice');
    $portuguese_flag_choice = get_option('googlelanguagetranslator_portuguese_flag_choice');
	$show_flags = get_option('googlelanguagetranslator_flags');
    $flag_width = get_option('googlelanguagetranslator_flag_size');
    $get_language_choices = get_option('language_display_settings');
    $floating_widget = get_option ('googlelanguagetranslator_floating_widget');
    $floating_widget_text = get_option ('googlelanguagetranslator_floating_widget_text');
    $floating_widget_text_translation_allowed = get_option ('googlelanguagetranslator_floating_widget_text_allow_translation');
    $is_active = get_option ( 'googlelanguagetranslator_active' );
    $is_multilanguage = get_option('googlelanguagetranslator_multilanguage');
    $str = '';

    if( $is_active == 1) {
      if ($floating_widget=='yes') {
	    $str.='<div id="glt-translate-trigger"><span'.($floating_widget_text_translation_allowed != 1 ? ' class="notranslate"' : ' class="translate"').'>'.(empty($floating_widget_text) ? 'Translate &raquo;' : $floating_widget_text).'</span></div>';
        $str.='<div id="glt-toolbar"></div>';
      } //endif $floating_widget
		
      if ((($layout=='SIMPLE' && !isset($vertical)) || ($layout=='Vertical' && !isset($vertical)) || (isset($vertical) && $show_flags==0)) || (($layout=='Horizontal' && !isset($horizontal)) || (isset($horizontal) && $show_flags==0))):

      $str.='<div id="flags" style="display:none" class="size'.$flag_width.'">';
	  $str.='<ul id="sortable" class="ui-sortable">';	  
        if (empty($new_languages_array_string)) {
		  foreach ($this->languages_array as $key=>$value) {
		    $language_code = $key;
		    $language_name = $value;
		    $language_name_flag = $language_name;
            if (!empty($get_language_choices[$language_code]) && $get_language_choices[$language_code]==1) {
		      if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
			    $language_name_flag = 'canada';
			  }
			  if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
                $language_name_flag = 'united-states';
			  }
			  if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
				$language_name_flag = 'mexico';
			  }
			  if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
			    $language_name_flag = 'brazil';
			  } 
			  $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="nturl notranslate '.$language_code.' flag '.$language_name_flag.'"></a>';
			  } //empty
	      }//foreach
	    } else {
          if ($new_languages_array_count != count($get_language_choices)):
		    foreach ($get_language_choices as $key => $value) {
              $language_code = $key;
		      $language_name = $this->languages_array[$key];
		      $language_name_flag = $language_name;
              
              if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
				$language_name_flag = 'canada';
			  }
			  if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
                $language_name_flag = 'united-states';
			  }
			  if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
				$language_name_flag = 'mexico';
			  }
			  if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
			    $language_name_flag = 'brazil';
			  }
			  $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="nturl notranslate '.$language_code.' flag '.$language_name_flag.'"></a>';
	        } //foreach
          else:
            foreach ($new_languages_array_codes as $value) {
              $language_name = $value;
		      $language_code = array_search ($language_name, $this->languages_array);
		      $language_name_flag = $language_name;
              
			if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
			  $language_name_flag = 'canada';
			}
			if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
              $language_name_flag = 'united-states';
			}
			if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
		      $language_name_flag = 'mexico';
			}
			if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
			  $language_name_flag = 'brazil';
			}
			$str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="nturl notranslate '.$language_code.' flag '.$language_name_flag.'"></a>'; 
	      }//foreach
        endif;
	  }//endif
      $str.='</ul>';
      $str.='</div>';
		
	  endif; //layout
	}

    $language_choices = $this->googlelanguagetranslator_included_languages();
    $layout = get_option('googlelanguagetranslator_display');
    $is_multilanguage = get_option('googlelanguagetranslator_multilanguage');
    $horizontal_layout = ', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL';
    $simple_layout = ', layout: google.translate.TranslateElement.InlineLayout.SIMPLE';
    $auto_display = ', autoDisplay: false';
    $default_language = get_option('googlelanguagetranslator_language');

    if ($is_multilanguage == 1):
      $multilanguagePage = ', multilanguagePage:true';
      $str.="<div id='glt-footer'>".(!isset($vertical) && !isset($horizontal) ? '<div id="google_language_translator" class="default-language-'.$default_language.'"></div>' : '')."</div><script>function GoogleLanguageTranslatorInit() { new google.translate.TranslateElement({pageLanguage: '".$default_language."'".$language_choices . ($layout=='Horizontal' ? $horizontal_layout : ($layout=='SIMPLE' ? $simple_layout : '')) . $auto_display . $multilanguagePage . $this->analytics()."}, 'google_language_translator');}</script>";
      echo $str;
	elseif ($is_multilanguage == 0):
	  $str.="<div id='glt-footer'>".(!isset($vertical) && !isset($horizontal) ? '<div id="google_language_translator" class="default-language-'.$default_language.'"></div>' : '')."</div><script>function GoogleLanguageTranslatorInit() { new google.translate.TranslateElement({pageLanguage: '".$default_language."'".$language_choices . ($layout=='Horizontal' ? $horizontal_layout : ($layout=='SIMPLE' ? $simple_layout : '')) . $auto_display . $this->analytics()."}, 'google_language_translator');}</script>";
      echo $str;
	endif; //is_multilanguage
  }

  public function googlelanguagetranslator_vertical() {
	global $started;
	global $vertical;
	$vertical = 1;
	$started = false;
	$new_languages_array_string = get_option('googlelanguagetranslator_flags_order');
	$new_languages_array = explode(",",$new_languages_array_string);
	$new_languages_array_codes = array_values($new_languages_array);
	$new_languages_array_count = count($new_languages_array);
	$get_language_choices = get_option ('language_display_settings');
	$show_flags = get_option('googlelanguagetranslator_flags'); 
	$flag_width = get_option('googlelanguagetranslator_flag_size');
	$default_language_code = get_option('googlelanguagetranslator_language');
    $english_flag_choice = get_option('googlelanguagetranslator_english_flag_choice');
    $spanish_flag_choice = get_option('googlelanguagetranslator_spanish_flag_choice');
    $portuguese_flag_choice = get_option('googlelanguagetranslator_portuguese_flag_choice');
	$is_active = get_option ( 'googlelanguagetranslator_active' );
	$language_choices = $this->googlelanguagetranslator_included_languages();
	$floating_widget = get_option ('googlelanguagetranslator_floating_widget');
	$str = '';

	if ($is_active==1):
	  if ($show_flags==1):
	  $str.='<div id="flags" class="size'.$flag_width.'">';
	  $str.='<ul id="sortable" class="ui-sortable" style="float:left">';
	  
	  if (empty($new_languages_array_string)):
	    foreach ($this->languages_array as $key=>$value) {
		  $language_code = $key;
		  $language_name = $value;
		  $language_name_flag = $language_name;
			
          if (!empty($get_language_choices[$language_code]) && $get_language_choices[$language_code]==1) {
            if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
		      $language_name_flag = 'canada';
			}
		    if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
              $language_name_flag = 'united-states';
		    }
            if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
		      $language_name_flag = 'mexico';
		    }
            if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
	          $language_name_flag = 'brazil';
	        }
	        $str.="<li id='".$language_name."'><a title='".$language_name."' class='notranslate flag ".$language_code." ".$language_name_flag."'></a></li>";
          } //endif
	    }//foreach
	  else:
	    if ($new_languages_array_count != count($get_language_choices)):
		    foreach ($get_language_choices as $key => $value) {
              $language_code = $key;
		      $language_name = $this->languages_array[$key];
		      $language_name_flag = $language_name;
             
              if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
				$language_name_flag = 'canada';
		      }
		      if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
                $language_name_flag = 'united-states';
		      }
		      if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
				$language_name_flag = 'mexico';
			  }
		      if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
			    $language_name_flag = 'brazil';
			  }
				
			  $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="nturl notranslate '.$language_code.' flag '.$language_name_flag.'"></a>';
	        } //foreach
          else:
            foreach ($new_languages_array_codes as $value) {
              $language_name = $value;
		      $language_code = array_search ($language_name, $this->languages_array);
		      $language_name_flag = $language_name;

		      if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
			    $language_name_flag = 'canada';
			  }
			  if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
                $language_name_flag = 'united-states';
			  }
		      if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
			    $language_name_flag = 'mexico';
			  }
			  if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
			    $language_name_flag = 'brazil';
			  }
			  $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="nturl notranslate '.$language_code.' flag '.$language_name_flag.'"></a>';
	        }//foreach
          endif;
	  endif;
	  
      $str.='</ul>';
      $str.='</div>';
	  
	  endif; //show_flags
	  
      $str.='<div id="google_language_translator" class="default-language-'.$default_language_code.'"></div>'; return $str;
	  
    endif; 
  } // End glt_vertical

  public function googlelanguagetranslator_horizontal() {
	global $started;
	global $horizontal;
	$horizontal = 1;
    $started = false;
    $new_languages_array_string = get_option('googlelanguagetranslator_flags_order');
    $new_languages_array = explode(",",$new_languages_array_string);
    $new_languages_array_codes = array_values($new_languages_array);
    $new_languages_array_count = count($new_languages_array);
    $get_language_choices = get_option ('language_display_settings');
	$show_flags = get_option('googlelanguagetranslator_flags'); 
    $flag_width = get_option('googlelanguagetranslator_flag_size');
    $default_language_code = get_option('googlelanguagetranslator_language');
    $english_flag_choice = get_option('googlelanguagetranslator_english_flag_choice');
    $spanish_flag_choice = get_option('googlelanguagetranslator_spanish_flag_choice');
    $portuguese_flag_choice = get_option('googlelanguagetranslator_portuguese_flag_choice');
    $is_active = get_option ( 'googlelanguagetranslator_active' );
    $language_choices = $this->googlelanguagetranslator_included_languages();
    $floating_widget = get_option ('googlelanguagetranslator_floating_widget');
    $str = '';

    if ($is_active==1):
	  if ($show_flags==1):
	  $str.='<div id="flags" class="size'.$flag_width.'">';
	  $str.='<ul id="sortable" class="ui-sortable" style="float:left">';

	  if (empty($new_languages_array_string)):
	    foreach ($this->languages_array as $key=>$value) {
		  $language_code = $key;
		  $language_name = $value;
		  $language_name_flag = $language_name;
			
          if (!empty($get_language_choices[$language_code]) && $get_language_choices[$language_code]==1) {
            if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
		      $language_name_flag = 'canada';
		    }
		    if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
              $language_name_flag = 'united-states';
		    }
            if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
		      $language_name_flag = 'mexico';
		    }
            if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
	          $language_name_flag = 'brazil';
	        }
	        $str.="<li id='".$language_name."'><a title='".$language_name."' class='notranslate flag ".$language_code." ".$language_name_flag."'></a></li>";
          } //endif
	    }//foreach
	  else:
	    if ($new_languages_array_count != count($get_language_choices)):
		    foreach ($get_language_choices as $key => $value) {
              $language_code = $key;
		      $language_name = $this->languages_array[$key];
		      $language_name_flag = $language_name;
             
              if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
				$language_name_flag = 'canada';
		      }
			  if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
                $language_name_flag = 'united-states';
			  }
			  if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
				$language_name_flag = 'mexico';
			  }
			  if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
			    $language_name_flag = 'brazil';
			  }
			  $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="nturl notranslate '.$language_code.' flag '.$language_name_flag.'"></a>';
	        } //foreach
          else:
            foreach ($new_languages_array_codes as $value) {
              $language_name = $value;
		      $language_code = array_search ($language_name, $this->languages_array);
		      $language_name_flag = $language_name;

			  if ( $language_name == 'English' && $english_flag_choice == 'canadian_flag') {
			    $language_name_flag = 'canada';
			  }
			  if ( $language_name == "English" && $english_flag_choice == 'us_flag') {
                $language_name_flag = 'united-states';
			  }
			  if ( $language_name == 'Spanish' && $spanish_flag_choice == 'mexican_flag') {
				$language_name_flag = 'mexico';
			  }
		      if ( $language_name == 'Portuguese' && $portuguese_flag_choice == 'brazilian_flag') {
			    $language_name_flag = 'brazil';
			  }
			  $str.='<li id="'.$language_name.'"><a title="'.$language_name.'" class="nturl notranslate '.$language_code.' flag '.$language_name_flag.'"></a>';
	        }//foreach
          endif;
	  endif;
      $str.='</ul>';
      $str.='</div>';
	  
	  endif; //show_flags
	  
      $str.='<div id="google_language_translator" class="default-language-'.$default_language_code.'"></div>'; return $str;
	  
    endif; 
  } // End glt_horizontal

  public function initialize_settings() {
    add_settings_section('glt_settings','Settings','','google_language_translator');

    $settings_name_array = array ('googlelanguagetranslator_active','googlelanguagetranslator_language','language_display_settings','googlelanguagetranslator_flags','googlelanguagetranslator_translatebox','googlelanguagetranslator_display','glt_language_switcher_width','glt_language_switcher_text_color','glt_language_switcher_bg_color','googlelanguagetranslator_toolbar','googlelanguagetranslator_showbranding','googlelanguagetranslator_flags_alignment','googlelanguagetranslator_analytics','googlelanguagetranslator_analytics_id','googlelanguagetranslator_css','googlelanguagetranslator_multilanguage','googlelanguagetranslator_floating_widget','googlelanguagetranslator_flag_size','googlelanguagetranslator_flags_order','googlelanguagetranslator_english_flag_choice','googlelanguagetranslator_spanish_flag_choice','googlelanguagetranslator_portuguese_flag_choice','googlelanguagetranslator_floating_widget_text','glt_floating_widget_text_color','googlelanguagetranslator_floating_widget_text_allow_translation','glt_floating_widget_position','glt_floating_widget_bg_color');

    foreach ($settings_name_array as $setting) {
      add_settings_field( $setting,'',$setting.'_cb','google_language_translator','glt_settings');
      register_setting( 'google_language_translator',$setting);
    }
  }

  public function googlelanguagetranslator_active_cb() {
    $option_name = 'googlelanguagetranslator_active' ;
    $new_value = 1;
      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  }

	  $options = get_option (''.$option_name.'');

	  $html = '<input type="checkbox" name="googlelanguagetranslator_active" id="googlelanguagetranslator_active" value="1" '.checked(1,$options,false).'/> &nbsp; Check this box to activate';
	  echo $html;
	}

  public function googlelanguagetranslator_language_cb() {

	$option_name = 'googlelanguagetranslator_language';
    $new_value = 'en';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  }

	  $options = get_option (''.$option_name.''); ?>

      <select name="googlelanguagetranslator_language" id="googlelanguagetranslator_language">

	  <?php

        foreach ($this->languages_array as $key => $value) {
		  $language_code = $key;
		  $language_name = $value; ?>
		    <option value="<?php echo $language_code; ?>" <?php if($options==''.$language_code.''){echo "selected";}?>><?php echo $language_name; ?></option>
	      <?php } ?>
      </select>
    <?php
    }

    public function language_display_settings_cb() {
	  $default_language_code = get_option('googlelanguagetranslator_language');
	  $option_name = 'language_display_settings';
      $new_value = array(''.$default_language_code.'' => 1);

	  if ( get_option( $option_name ) == false ) {
        // The option does not exist, so we update it.
        update_option( $option_name, $new_value );
	  }

	  $get_language_choices = get_option (''.$option_name.''); ?>

      <script>jQuery(document).ready(function($) { $('.select-all-languages').on('click',function(e) { e.preventDefault(); $('.languages').find('input:checkbox').prop('checked', true); }); $('.clear-all-languages').on('click',function(e) { e.preventDefault(); 
$('.languages').find('input:checkbox').prop('checked', false); }); }); </script>

      <?php

	  foreach ($this->languages_array as $key => $value) {
		$language_code = $key;
		$language_name = $value;
		$language_code_array[] = $key;

		if (!isset($get_language_choices[''.$language_code.''])) {
		  $get_language_choices[''.$language_code.''] = 0;
		}

		$items[] = $get_language_choices[''.$language_code.''];
		$language_codes = $language_code_array;
		$item_count = count($items);

		if ($item_count == 1 || $item_count == 27 || $item_count == 53 || $item_count == 79) { ?>
          <div class="languages" style="width:25%; float:left">
	    <?php } ?>
		  <div><input type="checkbox" name="language_display_settings[<?php echo $language_code; ?>]" value="1"<?php checked( 1,$get_language_choices[''.$language_code.'']); ?>/><?php echo $language_name; ?></div>
        <?php
		if ($item_count == 26 || $item_count == 52 || $item_count == 78 || $item_count == 104) { ?>
          </div>
        <?php }
	  } ?>
     <div class="clear"></div>
    <?php
	}

    public function googlelanguagetranslator_flags_cb() { 
	
      $option_name = 'googlelanguagetranslator_flags' ;
      $new_value = 1;

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  } 
	  
	  $options = get_option (''.$option_name.'');

      $html = '<input type="checkbox" name="googlelanguagetranslator_flags" id="googlelanguagetranslator_flags" value="1" '.checked(1,$options,false).'/> &nbsp; Check to show flags';
  
      echo $html;
    }

    public function googlelanguagetranslator_floating_widget_cb() {

	$option_name = 'googlelanguagetranslator_floating_widget' ;
    $new_value = 'yes';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  }

	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_floating_widget" id="googlelanguagetranslator_floating_widget" style="width:170px">
		      <option value="yes" <?php if($options=='yes'){echo "selected";}?>>Yes, show widget</option>
			  <option value="no" <?php if($options=='no'){echo "selected";}?>>No, hide widget</option>
		  </select>
  <?php }

  public function googlelanguagetranslator_floating_widget_text_cb() {

    $option_name = 'googlelanguagetranslator_floating_widget_text' ;
    $new_value = 'Translate &raquo;';

    if ( get_option( $option_name ) === false ) {
      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
    }

    $options = get_option (''.$option_name.''); ?>

    <input type="text" name="googlelanguagetranslator_floating_widget_text" id="googlelanguagetranslator_floating_widget_text" value="<?php echo esc_attr($options); ?>" style="width:170px"/>
		      
  <?php }

  public function googlelanguagetranslator_floating_widget_text_allow_translation_cb() {
    $option_name = 'googlelanguagetranslator_floating_widget_text_allow_translation' ;
    $new_value = 0;

    if ( get_option( $option_name ) === false ) {
      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
    }

    $options = get_option (''.$option_name.'');

    $html = '<input type="checkbox" name="googlelanguagetranslator_floating_widget_text_allow_translation" id="googlelanguagetranslator_floating_widget_text_allow_translation" value="1" '.checked(1,$options,false).'/> &nbsp; Check to allow';
    echo $html;
  }
	
  public function glt_floating_widget_position_cb() {
      $option_name = 'glt_floating_widget_position';
      $new_value = '';

      if (get_option($option_name) === false):
        update_option($option_name, $new_value);
      endif;

      $options = get_option(''.$option_name.''); ?>

      <select name="glt_floating_widget_position" id="glt_floating_widget_position" style="width:170px">
        <option value="bottom_left" <?php if($options=='bottom_left'){echo "selected";}?>>Bottom left</option>
        <option value="bottom_center" <?php if($options=='bottom_center'){echo "selected";}?>>Bottom center</option>
	    <option value="bottom_right" <?php if($options=='bottom_right'){echo "selected";}?>>Bottom right</option>
        <option value="top_left" <?php if($options=='top_left'){echo "selected";}?>>Top left</option>
        <option value="top_center" <?php if($options=='top_center'){echo "selected";}?>>Top center</option>
	    <option value="top_right" <?php if($options=='top_right'){echo "selected";}?>>Top right</option>
      </select>
  <?php
  }

  public function glt_floating_widget_text_color_cb() {
    $option_name = 'glt_floating_widget_text_color';
    $new_value = '#ffffff';

    if (get_option($option_name) === false):
      update_option($option_name, $new_value);
    endif;

    $options = get_option(''.$option_name.''); ?>

    <input type="text" name="glt_floating_widget_text_color" id="glt_floating_widget_text_color" class="color-field" value="<?php echo $options; ?>"/>
  <?php
  }
	
  public function glt_floating_widget_bg_color_cb() {
    $option_name = 'glt_floating_widget_bg_color';
    $new_value = '#f89406';

    if (get_option($option_name) === false):
      update_option($option_name, $new_value);
    endif;

    $options = get_option(''.$option_name.''); ?>

    <input type="text" name="glt_floating_widget_bg_color" id="glt_floating_widget_bg_color" class="color-field" value="<?php echo $options; ?>"/>
  <?php
  }
	
  public function glt_language_switcher_width_cb() {
	
  $option_name = 'glt_language_switcher_width' ;
  $new_value = '';

  if ( get_option( $option_name ) === false ) {
    update_option( $option_name, $new_value );
  } 
	  
  $options = get_option (''.$option_name.''); ?>

  <select name="glt_language_switcher_width" id="glt_language_switcher_width" style="width:110px;">
    <option value="100%" <?php if($options=='100%'){echo "selected";}?>>100%</option>
    <option value="">-------</option>
    <option value="150px" <?php if($options=='150px'){echo "selected";}?>>150px</option>
    <option value="160px" <?php if($options=='160px'){echo "selected";}?>>160px</option>
    <option value="170px" <?php if($options=='170px'){echo "selected";}?>>170px</option>
    <option value="180px" <?php if($options=='180px'){echo "selected";}?>>180px</option>
	<option value="190px" <?php if($options=='190px'){echo "selected";}?>>190px</option>
    <option value="200px" <?php if($options=='200px'){echo "selected";}?>>200px</option>
	<option value="210px" <?php if($options=='210px'){echo "selected";}?>>210px</option>
    <option value="220px" <?php if($options=='220px'){echo "selected";}?>>220px</option>
	<option value="230px" <?php if($options=='230px'){echo "selected";}?>>230px</option>
    <option value="240px" <?php if($options=='240px'){echo "selected";}?>>240px</option>
	<option value="250px" <?php if($options=='250px'){echo "selected";}?>>250px</option>
    <option value="260px" <?php if($options=='260px'){echo "selected";}?>>260px</option>
	<option value="270px" <?php if($options=='270px'){echo "selected";}?>>270px</option>
    <option value="280px" <?php if($options=='280px'){echo "selected";}?>>280px</option>
	<option value="290px" <?php if($options=='290px'){echo "selected";}?>>290px</option>
    <option value="300px" <?php if($options=='300px'){echo "selected";}?>>300px</option>
  </select> 
  <?php }
	
  public function glt_language_switcher_text_color_cb() {
    $option_name = 'glt_language_switcher_text_color';
    $new_value = '#32373c';

    if (get_option($option_name) === false):
      update_option($option_name, $new_value);
    endif;

    $options = get_option(''.$option_name.''); ?>

    <input type="text" name="glt_language_switcher_text_color" id="glt_language_switcher_text_color" class="color-field" value="<?php echo $options; ?>"/>
  <?php	  
  }
	
  public function glt_language_switcher_bg_color_cb() {
    $option_name = 'glt_language_switcher_bg_color';
    $new_value = '';

    if (get_option($option_name) === false):
      update_option($option_name, $new_value);
    endif;

    $options = get_option(''.$option_name.''); ?>

    <input type="text" name="glt_language_switcher_bg_color" id="glt_language_switcher_bg_color" class="color-field" value="<?php echo $options; ?>"/>
  <?php	  
  }

  public function googlelanguagetranslator_translatebox_cb() {

    $option_name = 'googlelanguagetranslator_translatebox' ;
    $new_value = 'yes';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  }

	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_translatebox" id="googlelanguagetranslator_translatebox" style="width:190px">
            <option value="yes" <?php if($options=='yes'){echo "selected";}?>>Show language switcher</option>
	    <option value="no" <?php if($options=='no'){echo "selected";}?>>Hide language switcher</option>
          </select>
  <?php }

  public function googlelanguagetranslator_display_cb() {

	$option_name = 'googlelanguagetranslator_display' ;
    $new_value = 'Vertical';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  }

	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_display" id="googlelanguagetranslator_display" style="width:170px;">
             <option value="Vertical" <?php if(get_option('googlelanguagetranslator_display')=='Vertical'){echo "selected";}?>>Vertical</option>
             <option value="Horizontal" <?php if(get_option('googlelanguagetranslator_display')=='Horizontal'){echo "selected";}?>>Horizontal</option>
             <?php
               $browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
	       if (!empty($get_http_accept_language)):
	         $get_http_accept_language = explode(",",$browser_lang);
	       else:
	         $get_http_accept_language = explode(",",$browser_lang);
	       endif;
               $bestlang = $get_http_accept_language[0];
               $bestlang_prefix = substr($get_http_accept_language[0],0,2); 
               
               if ($bestlang_prefix == 'en'): ?>
	       <option value="SIMPLE" <?php if (get_option('googlelanguagetranslator_display')=='SIMPLE'){echo "selected";}?>>SIMPLE</option>
             <?php endif; ?>
          </select>
  <?php }

  public function googlelanguagetranslator_toolbar_cb() {

	$option_name = 'googlelanguagetranslator_toolbar' ;
    $new_value = 'Yes';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  }

	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_toolbar" id="googlelanguagetranslator_toolbar" style="width:170px;">
             <option value="Yes" <?php if(get_option('googlelanguagetranslator_toolbar')=='Yes'){echo "selected";}?>>Yes</option>
             <option value="No" <?php if(get_option('googlelanguagetranslator_toolbar')=='No'){echo "selected";}?>>No</option>
          </select>
  <?php }

  public function googlelanguagetranslator_showbranding_cb() {

	$option_name = 'googlelanguagetranslator_showbranding' ;
    $new_value = 'Yes';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  }

	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_showbranding" id="googlelanguagetranslator_showbranding" style="width:170px;">
             <option value="Yes" <?php if(get_option('googlelanguagetranslator_showbranding')=='Yes'){echo "selected";}?>>Yes</option>
             <option value="No" <?php if(get_option('googlelanguagetranslator_showbranding')=='No'){echo "selected";}?>>No</option>
          </select>
  <?php }

  public function googlelanguagetranslator_flags_alignment_cb() {

	$option_name = 'googlelanguagetranslator_flags_alignment' ;
    $new_value = 'flags_left';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, 'flags_left' );
	  }

	  $options = get_option (''.$option_name.''); ?>

      <input type="radio" name="googlelanguagetranslator_flags_alignment" id="flags_left" value="flags_left" <?php if($options=='flags_left'){echo "checked";}?>/> Align Left<br/>
      <input type="radio" name="googlelanguagetranslator_flags_alignment" id="flags_right" value="flags_right" <?php if($options=='flags_right'){echo "checked";}?>/> Align Right
  <?php }

  public function googlelanguagetranslator_analytics_cb() {

	$option_name = 'googlelanguagetranslator_analytics' ;
    $new_value = 0;

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  }

	  $options = get_option (''.$option_name.'');

    $html = '<input type="checkbox" name="googlelanguagetranslator_analytics" id="googlelanguagetranslator_analytics" value="1" '.checked(1,$options,false).'/> &nbsp; Activate Google Analytics tracking?';
    echo $html;
  }

  public function googlelanguagetranslator_analytics_id_cb() {

	$option_name = 'googlelanguagetranslator_analytics_id' ;
    $new_value = '';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  }

	  $options = get_option (''.$option_name.'');

    $html = '<input type="text" name="googlelanguagetranslator_analytics_id" id="googlelanguagetranslator_analytics_id" value="'.$options.'" />';
    echo $html;
  }

  public function googlelanguagetranslator_flag_size_cb() {

	$option_name = 'googlelanguagetranslator_flag_size' ;
    $new_value = '18';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  }

	  $options = get_option (''.$option_name.''); ?>

          <select name="googlelanguagetranslator_flag_size" id="googlelanguagetranslator_flag_size" style="width:110px;">
             <option value="16" <?php if($options=='16'){echo "selected";}?>>16px</option>
			 <option value="18" <?php if($options=='18'){echo "selected";}?>>18px</option>
             <option value="20" <?php if($options=='20'){echo "selected";}?>>20px</option>
			 <option value="22" <?php if($options=='22'){echo "selected";}?>>22px</option>
             <option value="24" <?php if($options=='24'){echo "selected";}?>>24px</option>
          </select>
  <?php }

  public function googlelanguagetranslator_flags_order_cb() {
	$option_name = 'googlelanguagetranslator_flags_order';
	$new_value = '';

	if ( get_option ( $option_name ) === false ) {

	  // The option does not exist, so we update it.
	  update_option( $option_name, $new_value );
	}

	$options = get_option ( ''.$option_name.'' ); ?>

    <input type="hidden" id="order" name="googlelanguagetranslator_flags_order" value="<?php print_r(get_option('googlelanguagetranslator_flags_order')); ?>" />
   <?php
  }

  public function googlelanguagetranslator_english_flag_choice_cb() {
	$option_name = 'googlelanguagetranslator_english_flag_choice';
	$new_value = 'us_flag';

	if ( get_option ( $option_name ) === false ) {

	  // The option does not exist, so we update it.
	  update_option( $option_name, $new_value );
	}

	$options = get_option ( ''.$option_name.'' ); ?>

    <select name="googlelanguagetranslator_english_flag_choice" id="googlelanguagetranslator_english_flag_choice">
      <option value="us_flag" <?php if($options=='us_flag'){echo "selected";}?>>U.S. Flag</option>
	  <option value="uk_flag" <?php if ($options=='uk_flag'){echo "selected";}?>>U.K Flag</option>
	  <option value="canadian_flag" <?php if ($options=='canadian_flag'){echo "selected";}?>>Canadian Flag</option>
    </select>
   <?php
  }

  public function googlelanguagetranslator_spanish_flag_choice_cb() {
	$option_name = 'googlelanguagetranslator_spanish_flag_choice';
	$new_value = 'spanish_flag';

	if ( get_option ( $option_name ) === false ) {

	  // The option does not exist, so we update it.
	  update_option( $option_name, $new_value );
	}

	$options = get_option ( ''.$option_name.'' ); ?>

    <select name="googlelanguagetranslator_spanish_flag_choice" id="googlelanguagetranslator_spanish_flag_choice">
      <option value="spanish_flag" <?php if($options=='spanish_flag'){echo "selected";}?>>Spanish Flag</option>
	  <option value="mexican_flag" <?php if ($options=='mexican_flag'){echo "selected";}?>>Mexican Flag</option>
    </select>
   <?php
  }

  public function googlelanguagetranslator_portuguese_flag_choice_cb() {
	$option_name = 'googlelanguagetranslator_portuguese_flag_choice';
	$new_value = 'portuguese_flag';

	if ( get_option ( $option_name ) === false ) {

	  // The option does not exist, so we update it.
	  update_option( $option_name, $new_value );
	}

	$options = get_option ( ''.$option_name.'' ); ?>

    <select name="googlelanguagetranslator_portuguese_flag_choice" id="googlelanguagetranslator_spanish_flag_choice">
      <option value="portuguese_flag" <?php if($options=='portuguese_flag'){echo "selected";}?>>Portuguese Flag</option>
	  <option value="brazilian_flag" <?php if ($options=='brazilian_flag'){echo "selected";}?>>Brazilian Flag</option>
    </select>
   <?php
  }

  public function googlelanguagetranslator_css_cb() {

    $option_name = 'googlelanguagetranslator_css' ;
    $new_value = '';

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  }

	  $options = get_option (''.$option_name.'');

	  $html = '<textarea style="width:100%; height:200px" name="googlelanguagetranslator_css" id="googlelanguagetranslator_css">'.$options.'</textarea>';
    echo $html;
  }

  public function googlelanguagetranslator_multilanguage_cb() {

	$option_name = 'googlelanguagetranslator_multilanguage' ;
    $new_value = 0;

      if ( get_option( $option_name ) === false ) {

      // The option does not exist, so we update it.
      update_option( $option_name, $new_value );
	  }

	  $options = get_option (''.$option_name.'');

      $html = '<input type="checkbox" name="googlelanguagetranslator_multilanguage" id="googlelanguagetranslator_multilanguage" value="1" '.checked(1,$options,false).'/> &nbsp; Turn on multilanguage mode?';
      echo $html;
  }

  public function googlelanguagetranslator_exclude_translation_cb() {

	$option_name = 'googlelanguagetranslator_exclude_translation';
	$new_value = '';

	if (get_option($option_name) === false ) {
	  // The option does not exist, so we update it.
	  update_option( $option_name, $new_value );
	}

	$options = get_option (''.$option_name.'');

	$html = '<input type="text" name="'.$option_name.'" id="'.$option_name.'" value="'.$options.'" />';

	echo $html;
  }

  public function page_layout_cb() {
    include( plugin_dir_path( __FILE__ ) . '/css/style.php'); add_thickbox(); ?>
      <div id="glt-settings" class="wrap">
        <div id="icon-options-general" class="icon32"></div>
	  <h2><span class="notranslate">Google Language Translator</span></h2>
            <form action="<?php echo admin_url( '/options.php'); ?>" method="post">
              <div class="metabox-holder has-right-sidebar" style="float:left; width:65%">
                <div class="postbox glt-main-settings" style="width: 100%">
                  <h3 class="notranslate">Main Settings</h3>
                    <?php settings_fields('google_language_translator'); ?>
                      <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
                        <tr>
                          <td style="width:60%" class="notranslate">Plugin Status:</td>
                          <td class="notranslate"><?php $this->googlelanguagetranslator_active_cb(); ?></td>
                        </tr>

                        <tr class="notranslate">
                          <td>Choose the original language of your website</td>
                          <td><?php $this->googlelanguagetranslator_language_cb(); ?></td>
                        </tr>
						  
						<tr class="notranslate">
		                  <td colspan="2">What languages will be active? (<a class="select-all-languages" href="#">Select All</a> | <a class="clear-all-languages" href="#">Clear</a>)</td>
		                </tr>
						  
						<tr class="notranslate languages">
		                  <td colspan="2"><?php $this->language_display_settings_cb(); ?></td>
		                </tr>
                      </table>
                </div> <!-- .postbox -->

                <div class="postbox glt-layout-settings" style="width: 100%">
                  <h3 class="notranslate">Language Switcher Settings</h3>
                  <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
					  
			      <tr class="notranslate">
		            <td class="choose_flags_intro">Language switcher width: <strong style="color:red">NEW!</strong></td>
		            <td class="choose_flags_intro"><?php $this->glt_language_switcher_width_cb(); ?></td>
		          </tr>
					  
				  <tr class="notranslate">
		            <td class="choose_flags_intro">Language switcher text color: <strong style="color:red">NEW!</strong></td>
		            <td class="choose_flags_intro"><?php $this->glt_language_switcher_text_color_cb(); ?></td>
		          </tr>
					  
				  <tr class="notranslate">
		            <td class="choose_flags_intro">Language switcher background color: <strong style="color:red">NEW!</strong></td>
		            <td class="choose_flags_intro"><?php $this->glt_language_switcher_bg_color_cb(); ?></td>
		          </tr>
					  
		          <tr class="notranslate">
		            <td class="choose_flags_intro">Show flag images?<br/>(Display up to 104 flags above the language switcher)</td>
		            <td class="choose_flags_intro"><?php $this->googlelanguagetranslator_flags_cb(); ?></td>
		          </tr>

                    <tr class="notranslate">
                      <td>Show or hide the langauge switcher?</td>
                      <td><?php $this->googlelanguagetranslator_translatebox_cb(); ?></td>
                    </tr>

                    <tr class="notranslate">
                      <td>Layout option:</td>
                      <td><?php $this->googlelanguagetranslator_display_cb(); ?></td>
                    </tr>

                    <tr class="notranslate">
                      <td>Show Google Toolbar?</td>
                      <td><?php $this->googlelanguagetranslator_toolbar_cb(); ?></td>
                    </tr>

                    <tr class="notranslate">
                      <td>Show Google Branding? &nbsp;<a href="https://developers.google.com/translate/v2/attribution" target="_blank">Learn more</a></td>
		      <td><?php $this->googlelanguagetranslator_showbranding_cb(); ?></td>
                    </tr>

                    <tr class="alignment notranslate">
                      <td class="flagdisplay">Align the translator left or right?</td>
                      <td class="flagdisplay"><?php $this->googlelanguagetranslator_flags_alignment_cb(); ?></td>
                    </tr>
                  </table>
                </div> <!-- .postbox -->

                <div class="postbox glt-floating-widget-settings" style="width: 100%">
                  <h3 class="notranslate">Floating Widget Settings</h3>
                  <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
                    <tr class="floating_widget_show notranslate">
		              <td>Show floating translation widget?</td>
                      <td><?php $this->googlelanguagetranslator_floating_widget_cb(); ?></td>
                    </tr>

                    <tr class="floating-widget floating-widget-custom-text notranslate hidden">
                      <td>Custom text for the floating widget:</td>
                      <td><?php $this->googlelanguagetranslator_floating_widget_text_cb(); ?></td>
                    </tr>

                    <tr class="floating-widget floating-widget-text-translate notranslate hidden">
                      <td>Allow floating widget text to translate?:</td>
                      <td><?php $this->googlelanguagetranslator_floating_widget_text_allow_translation_cb(); ?></td>
                    </tr>
					  
					<tr class="floating-widget floating-widget-position notranslate hidden">
	                  <td>Floating Widget Position: <strong style="color:red">NEW!</strong></td>
		              <td><?php $this->glt_floating_widget_position_cb(); ?></td>
		            </tr>

                    <tr class="floating-widget floating-widget-text-color notranslate hidden">
	                  <td>Floating Widget Text Color: <strong style="color:red">NEW!</strong></td>
		              <td><?php $this->glt_floating_widget_text_color_cb(); ?></td>
		            </tr>
					  
					<tr class="floating-widget floating-widget-color notranslate hidden">
	                  <td>Floating Widget Background Color <strong style="color:red">NEW!</strong></td>
		              <td><?php $this->glt_floating_widget_bg_color_cb(); ?></td>
		            </tr>
                  </table>
                </div> <!-- .postbox -->

                <div class="postbox glt-behavior-settings" style="width: 100%">
                  <h3 class="notranslate">Behavior Settings</h3>
                    <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
                      <tr class="multilanguage notranslate">
                      <td>Multilanguage Page option? &nbsp;<a href="#TB_inline?width=200&height=150&inlineId=multilanguage-page-description" title="What is the Multi-Language Page Option?" class="thickbox">Learn more</a><div id="multilanguage-page-description" style="display:none"><p>If you activate this setting, Google will translate all text into a single language when requested by your user, even if text is written in multiple languages. In most cases, this setting is not recommended, although for certain websites it might be necessary.</p></div></td>
                      <td><?php $this->googlelanguagetranslator_multilanguage_cb(); ?></td>
                    </tr>

                    <tr class="notranslate">
                      <td>Google Analytics:</td>
                      <td><?php $this->googlelanguagetranslator_analytics_cb(); ?></td>
                    </tr>

                    <tr class="analytics notranslate">
                      <td>Google Analytics ID (Ex. 'UA-11117410-2')</td>
                      <td><?php $this->googlelanguagetranslator_analytics_id_cb(); ?></td>
                    </tr>
                  </table>
                </div> <!-- .postbox -->

                <div class="postbox glt-usage-settings" style="width: 100%">
                  <h3 class="notranslate">Usage</h3>
                  <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
                    <tr class="notranslate">
                      <td>For usage in pages/posts/sidebar:</td>
                      <td><code>[google-translator]</code></td>
                    </tr>

                    <tr class="notranslate">
                      <td style="width:40%">For usage in header/footer/page templates:</td>
                      <td style="width:60%"><code>&lt;?php echo do_shortcode('[google-translator]'); ?&gt;</code></td>
                    </tr>

                    <tr class="notranslate">
                      <td colspan="2">Single language usage in menus/pages/posts</td>
                    </tr>

                    <tr class="notranslate">
                      <td colspan="2"><code>[glt language="Spanish" label="Espa&ntilde;ol" image="yes" text="yes" image_size="24"]</code></td>
                    </tr>

                    <tr class="notranslate">
                      <td colspan="2">
                        <a href="#TB_inline?width=200&height=450&inlineId=single-language-shortcode-description" title="How to place a single language in your Wordpress menu" class="thickbox">How to place a single language in your Wordpress menu</a>
			<div id="single-language-shortcode-description" style="display:none">
			  <p>For menu usage, you need to create a new menu, or use an existing menu, by navigating to "Appearance > Menus".</p>
			  <p>First you will need to enable "descriptions" for your menu items, which can be found in a tab labeled "Screen Options" in the upper-right area of the page.</p>
			  <p>Once descriptions are enabled, follow these steps:<br/>
                            <ol>
			      <li>Create a new menu item using "Link" as the menu item type.</li>
			      <li>Use <code style="border:none">#</code> for the URL</li>
			      <li>Enter a navigation label of your choice. This label does not appear on your website - it is meant only to help you identify the menu item.</li>
			      <li>Place the following shortcode into the "description" field, and modify it to display the language and navigation label of your choice:</li>
                            </ol>
                          <p><code>[glt language="Spanish" label="Espa&ntilde;ol"]</code></p>
                        </div> <!-- .single-language-shortcode-description -->
                      </td>
                    </tr>

		    <tr class="notranslate">
                      <td colspan="2">
                        <?php
	                  if (isset($_POST['submit'])) {
	                    if (empty($_POST['submit']) && !check_admin_referer( 'glt-save-settings', 'glt-save-settings-nonce' )) {
	                      wp_die();
	                    }
	                  }
	                  wp_nonce_field('glt-save-settings, glt-save-settings-nonce', false);
                          submit_button(); ?>
                      </td>
                    </tr>
                  </table>
		</div> <!-- .postbox -->
		</div> <!-- .metbox-holder -->

		<div class="metabox-holder" style="float:right; clear:right; width:33%">
		  <div class="postbox glt-preview-settings">
		    <h3 class="notranslate">Preview</h3>
                      <table style="width:100%">
		        <tr>
                          <td style="box-sizing:border-box; -webkit-box-sizing:border-box; -moz-box-sizing:border-box; padding:15px 15px; margin:0px"><span class="notranslate"> Drag &amp; drop flags to change their position.<br/><br/>(Note: flag order resets when flags are added/removed)</span><br/><br/><?php echo do_shortcode('[google-translator]'); ?><p class="hello"><span class="notranslate">Translated text:</span> &nbsp; <span>Hello</span></p>
                          </td>
                        </tr>
                      </table>
		  </div> <!-- .postbox -->
	        </div> <!-- .metabox-holder -->

                <div class="metabox-holder box-right notranslate" style="float: right; width: 33%; clear:right">
                  <div class="postbox glt-advanced-settings">
                    <h3>Advanced Settings</h3>
                      <div class="inside">
                        <table style="border-collapse:separate" width="100%" border="0" cellspacing="8" cellpadding="0" class="form-table">
                          <tr class="notranslate">
	                    <td class="advanced">Select flag size:</td>
	                    <td class="advanced"><?php $this->googlelanguagetranslator_flag_size_cb(); ?></td>
                          </tr>

                          <tr class="notranslate">
	                    <td class="advanced">Flag for English:</td>
	                    <td class="advanced"><?php $this->googlelanguagetranslator_english_flag_choice_cb(); ?></td>
                          </tr>

                          <tr class="notranslate">
	                    <td class="advanced">Flag for Spanish:</td>
	                    <td class="advanced"><?php $this->googlelanguagetranslator_spanish_flag_choice_cb(); ?></td>
                          </tr>

                          <tr class="notranslate">
	                    <td class="advanced">Flag for Portuguese:</td>
	                    <td class="advanced"><?php $this->googlelanguagetranslator_portuguese_flag_choice_cb(); ?></td>
                          </tr>
                        </table>
                      </div> <!-- .inside -->
                    </div> <!-- .postbox -->
                  </div> <!-- .metabox-holder -->


	          <div class="metabox-holder box-right notranslate" style="float: right; width: 33%;">
                    <div class="postbox glt-css-settings">
                      <h3>Add CSS Styles</h3>
			<div class="inside">
			  <p>You can apply any necessary CSS styles below:</p>
			  <?php $this->googlelanguagetranslator_css_cb(); ?>
                        </div> <!-- .inside -->
                    </div> <!-- .postbox -->
                  </div> <!-- .metabox-holder -->
	          <?php $this->googlelanguagetranslator_flags_order_cb(); ?>
	    </form>

            <div class="metabox-holder box-right notranslate" style="float: right; width: 33%;">
              <div class="postbox">
                <h3>GLT Premium 5.0.42 is Here! $30</h3>
                  <div class="inside">
                    <a class="wp-studio-logo" href="http://www.wp-studio.net/" target="_blank"><img style="background:#444; border-radius:3px; -webkit-border-radius:3px; -moz-border-radius:3px; width:177px;" src="<?php echo plugins_url( 'images/logo.png' , __FILE__ ); ?>"></a><br />
                      <ul id="features" style="margin-left:15px">
                        <li style="list-style:square outside">104 Languages with flags</li>
                        <li style="list-style:square outside">Edit up to 5 phrases in any language, while using auto-translation</li>
						<li style="list-style:square outside">Adjust language switcher background, text color, and flag display</li>
                        <li style="list-style:square outside">6 Floating Widget positions</li>
						<li style="list-style:square outside">Adjust floating widget text color, background, and toolbar colors</li>
                        <li style="list-style:square outside">Exclude specific areas from translation</li>
		                <li style="list-style:square outside">jQuery-powered language switcher</li>
		                <li style="list-style:square outside">Add single languages to your menus/pages/posts</li>
		                <li style="list-style:square outside">Language switcher loads inline with page content</li>
		                <li style="list-style:square outside">Custom flag choices for English, Spanish and Portuguese</li>
		                <li style="list-style:square outside">User-friendly URLs, hide or show <code>lang</code> attribute</li>
		                <li style="list-style:square outside">Drag/drop flags to re-arrange their order</li>
                        <li style="list-style:square outside">Duplicate pages/posts into your chosen languages (for editing)</li>
	                    <li style="list-style:square outside">FREE access to all future updates</li>
	                  </ul>
                  </div> <!-- .inside -->
              </div> <!-- .postbox -->
            </div> <!-- .metabox-holder -->

	    <div class="metabox-holder box-right notranslate" style="float: right; width: 33%;">
              <div class="postbox">
                <h3>Please Consider A Donation</h3>
                  <div class="inside">If you find our plugin useful, help keep it actively developed by clicking the donate button <br /><br />
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                      <input type="hidden" name="cmd" value="_donations">
                      <input type="hidden" name="business" value="robertmyrick@hotmail.com">
                      <input type="hidden" name="lc" value="US">
                      <input type="hidden" name="item_name" value="Support Studio 88 Design and help us bring you more Wordpress goodies!  Any donation is kindly appreciated.  Thank you!">
                      <input type="hidden" name="no_note" value="0">
                      <input type="hidden" name="currency_code" value="USD">
                      <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
                      <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                      <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </form>
                  </div> <!-- .inside -->
              </div> <!-- .postbox -->
            </div> <!-- .metabox-holder -->
      </div> <!-- .wrap -->
<?php
  }
}
$google_language_translator = new google_language_translator();