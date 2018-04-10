<?php

/* calendar.twig */
class __TwigTemplate_fe5fa372e0eb51f713beb664be0cf0c9c8c78572b1851c15eac685f6cd98c181 extends Twig_Template
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
        // line 2
        echo "<!-- START All-in-One Event Calendar Plugin - Version ";
        echo (isset($context["version"]) ? $context["version"] : null);
        echo " -->
<div id=\"ai1ec-container\"
\t class=\"ai1ec-main-container ";
        // line 4
        echo (isset($context["ai1ec_calendar_classes"]) ? $context["ai1ec_calendar_classes"] : null);
        echo "\">
\t<!-- AI1EC_PAGE_CONTENT_PLACEHOLDER -->
\t<div id=\"ai1ec-calendar\" class=\"timely ai1ec-calendar\">
\t\t";
        // line 7
        if (array_key_exists("ai1ec_above_calendar", $context)) {
            // line 8
            echo "\t\t\t";
            echo (isset($context["ai1ec_above_calendar"]) ? $context["ai1ec_above_calendar"] : null);
            echo "
\t\t";
        }
        // line 10
        echo "\t\t";
        echo (isset($context["filter_menu"]) ? $context["filter_menu"] : null);
        echo "
\t\t<div id=\"ai1ec-calendar-view-container\"
\t\t\t class=\"ai1ec-calendar-view-container\">
\t\t\t<div id=\"ai1ec-calendar-view-loading\"
\t\t\t\t class=\"ai1ec-loading ai1ec-calendar-view-loading\"></div>
\t\t\t<div id=\"ai1ec-calendar-view\" class=\"ai1ec-calendar-view\">
\t\t\t\t";
        // line 16
        echo (isset($context["view"]) ? $context["view"] : null);
        echo "
\t\t\t</div>
\t\t</div>
\t\t<div class=\"ai1ec-subscribe-container ai1ec-pull-right ai1ec-btn-group\">
\t\t\t";
        // line 20
        echo (isset($context["subscribe_buttons"]) ? $context["subscribe_buttons"] : null);
        echo "
\t\t</div>
\t\t";
        // line 22
        echo (isset($context["after_view"]) ? $context["after_view"] : null);
        echo "
\t</div><!-- /.timely -->
</div>
";
        // line 25
        if ((!twig_test_empty((isset($context["inline_js_calendar"]) ? $context["inline_js_calendar"] : null)))) {
            // line 26
            echo "\t<script type=\"text/javascript\">";
            echo (isset($context["inline_js_calendar"]) ? $context["inline_js_calendar"] : null);
            echo "</script>
";
        }
        // line 28
        echo "<!-- END All-in-One Event Calendar Plugin -->
";
        // line 30
        echo "

";
    }

    public function getTemplateName()
    {
        return "calendar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  69 => 26,  67 => 25,  61 => 22,  71 => 26,  63 => 23,  51 => 18,  33 => 8,  330 => 120,  326 => 118,  322 => 117,  320 => 116,  312 => 114,  305 => 113,  303 => 112,  293 => 108,  287 => 105,  282 => 103,  277 => 100,  274 => 99,  268 => 96,  263 => 94,  258 => 91,  255 => 90,  252 => 89,  250 => 88,  244 => 85,  240 => 84,  236 => 82,  231 => 80,  227 => 79,  222 => 76,  220 => 75,  211 => 70,  205 => 67,  201 => 66,  198 => 65,  196 => 64,  187 => 61,  180 => 56,  170 => 51,  156 => 47,  145 => 43,  143 => 42,  139 => 41,  127 => 33,  121 => 31,  119 => 30,  112 => 29,  108 => 28,  100 => 26,  97 => 25,  92 => 24,  88 => 23,  84 => 21,  76 => 18,  72 => 17,  64 => 15,  56 => 20,  49 => 16,  46 => 10,  32 => 5,  30 => 5,  38 => 7,  52 => 12,  47 => 17,  41 => 9,  35 => 12,  60 => 14,  48 => 8,  40 => 6,  29 => 4,  22 => 2,  28 => 4,  24 => 3,  218 => 86,  210 => 81,  206 => 79,  204 => 78,  195 => 72,  190 => 70,  184 => 69,  176 => 54,  171 => 62,  165 => 50,  162 => 49,  160 => 48,  153 => 46,  148 => 44,  142 => 52,  134 => 47,  129 => 45,  123 => 44,  115 => 39,  110 => 37,  104 => 27,  96 => 31,  91 => 29,  85 => 28,  78 => 30,  73 => 23,  68 => 16,  65 => 24,  59 => 21,  53 => 19,  44 => 10,  42 => 11,  34 => 5,  27 => 4,  25 => 4,  23 => 3,  86 => 26,  75 => 28,  70 => 19,  66 => 14,  62 => 17,  58 => 14,  54 => 11,  50 => 11,  43 => 16,  39 => 10,  31 => 7,  26 => 3,  21 => 2,  19 => 2,);
    }
}
