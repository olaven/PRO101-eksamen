<?php

/* timely-menu-icon.twig */
class __TwigTemplate_6b2c061bbbe82525690ae9ecc2cbcf8ff4e2ebe0056efad05bd2a94fbbd63fc3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<style type=\"text/css\" media=\"all\">
  @font-face {
    font-family: 'Timely Icons';
    src:url('";
        // line 4
        echo twig_escape_filter($this->env, (isset($context["admin_theme_font_url"]) ? $context["admin_theme_font_url"] : null), "html", null, true);
        echo "timely-icons.eot');
    src:url('";
        // line 5
        echo twig_escape_filter($this->env, (isset($context["admin_theme_font_url"]) ? $context["admin_theme_font_url"] : null), "html", null, true);
        echo "timely-icons.eot?#iefix') format('embedded-opentype'),
    url('";
        // line 6
        echo twig_escape_filter($this->env, (isset($context["admin_theme_font_url"]) ? $context["admin_theme_font_url"] : null), "html", null, true);
        echo "timely-icons.svg#Timely-Icons') format('svg'),
    url('";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["admin_theme_font_url"]) ? $context["admin_theme_font_url"] : null), "html", null, true);
        echo "timely-icons.woff') format('woff'),
    url('";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["admin_theme_font_url"]) ? $context["admin_theme_font_url"] : null), "html", null, true);
        echo "timely-icons.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
  }
  ";
        // line 12
        if ((isset($context["before_font_icons"]) ? $context["before_font_icons"] : null)) {
            // line 13
            echo "  #menu-posts-ai1ec_event > .menu-icon-post > div.wp-menu-image {
    background-image: url('";
            // line 14
            echo twig_escape_filter($this->env, (isset($context["admin_theme_img_url"]) ? $context["admin_theme_img_url"] : null), "html", null, true);
            echo "/timely-admin-menu.png') !important;
  }
  ";
        } else {
            // line 17
            echo "  #menu-posts-ai1ec_event > .menu-icon-post > div.wp-menu-image:before {
    content:        '\\21' !important;
    display:        inline-block !important;
    font-family:    'Timely Icons' !important;
    font-style:     normal !important;
    font-weight:    normal !important;
    speak:          none !important;
    vertical-align: baseline !important;
    line-height:    16px !important;
  }
  ";
        }
        // line 28
        echo "</style>
";
    }

    public function getTemplateName()
    {
        return "timely-menu-icon.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 28,  58 => 17,  52 => 14,  49 => 13,  47 => 12,  40 => 8,  36 => 7,  32 => 6,  28 => 5,  24 => 4,  19 => 1,);
    }
}
