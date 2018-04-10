<?php

/* filter-menu.twig */
class __TwigTemplate_1f25bacc16e82305cef35f2d4954e3a58cf88f86b74ba3bdfdb3edd107c03a6d extends Twig_Template
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
        if ((!array_key_exists("hide_toolbar", $context))) {
            // line 2
            echo "\t";
            if (array_key_exists("ai1ec_before_filter_menu", $context)) {
                // line 3
                echo "\t\t";
                echo (isset($context["ai1ec_before_filter_menu"]) ? $context["ai1ec_before_filter_menu"] : null);
                echo "
\t";
            }
            // line 5
            echo "\t<div class=\"timely ai1ec-calendar-toolbar ai1ec-clearfix
\t";
            // line 6
            if (((((twig_test_empty((isset($context["categories"]) ? $context["categories"] : null)) && twig_test_empty((isset($context["tags"]) ? $context["tags"] : null))) && (!array_key_exists("additional_filters", $context))) && twig_test_empty((isset($context["contribution_buttons"]) ? $context["contribution_buttons"] : null))) && (!array_key_exists("additional_buttons", $context)))) {
                // line 12
                echo "\t\tai1ec-hidden
\t";
            }
            // line 14
            echo "\t\">
\t\t<ul class=\"ai1ec-nav ai1ec-nav-pills ai1ec-pull-left ai1ec-filters\">
\t\t\t";
            // line 16
            echo (isset($context["categories"]) ? $context["categories"] : null);
            echo "
\t\t\t";
            // line 17
            echo (isset($context["tags"]) ? $context["tags"] : null);
            echo "
\t\t\t";
            // line 18
            if (array_key_exists("additional_filters", $context)) {
                // line 19
                echo "\t\t\t\t";
                echo (isset($context["additional_filters"]) ? $context["additional_filters"] : null);
                echo "
\t\t\t";
            }
            // line 21
            echo "\t\t</ul>
\t\t<div class=\"ai1ec-pull-right\">
\t\t";
            // line 23
            if (array_key_exists("additional_buttons", $context)) {
                // line 24
                echo "\t\t\t";
                echo (isset($context["additional_buttons"]) ? $context["additional_buttons"] : null);
                echo "
\t\t";
            }
            // line 26
            echo "\t\t</div>
\t</div>";
        }
    }

    public function getTemplateName()
    {
        return "filter-menu.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 26,  63 => 23,  51 => 18,  33 => 6,  330 => 120,  326 => 118,  322 => 117,  320 => 116,  312 => 114,  305 => 113,  303 => 112,  293 => 108,  287 => 105,  282 => 103,  277 => 100,  274 => 99,  268 => 96,  263 => 94,  258 => 91,  255 => 90,  252 => 89,  250 => 88,  244 => 85,  240 => 84,  236 => 82,  231 => 80,  227 => 79,  222 => 76,  220 => 75,  211 => 70,  205 => 67,  201 => 66,  198 => 65,  196 => 64,  187 => 61,  180 => 56,  170 => 51,  156 => 47,  145 => 43,  143 => 42,  139 => 41,  127 => 33,  121 => 31,  119 => 30,  112 => 29,  108 => 28,  100 => 26,  97 => 25,  92 => 24,  88 => 23,  84 => 21,  76 => 18,  72 => 17,  64 => 15,  56 => 13,  49 => 11,  46 => 10,  32 => 5,  30 => 5,  38 => 7,  52 => 12,  47 => 17,  41 => 9,  35 => 12,  60 => 14,  48 => 8,  40 => 6,  29 => 4,  22 => 2,  28 => 4,  24 => 3,  218 => 86,  210 => 81,  206 => 79,  204 => 78,  195 => 72,  190 => 70,  184 => 69,  176 => 54,  171 => 62,  165 => 50,  162 => 49,  160 => 48,  153 => 46,  148 => 44,  142 => 52,  134 => 47,  129 => 45,  123 => 44,  115 => 39,  110 => 37,  104 => 27,  96 => 31,  91 => 29,  85 => 28,  78 => 19,  73 => 23,  68 => 16,  65 => 24,  59 => 21,  53 => 19,  44 => 10,  42 => 11,  34 => 5,  27 => 4,  25 => 3,  23 => 3,  86 => 26,  75 => 24,  70 => 19,  66 => 14,  62 => 17,  58 => 14,  54 => 11,  50 => 11,  43 => 16,  39 => 14,  31 => 5,  26 => 3,  21 => 2,  19 => 1,);
    }
}
