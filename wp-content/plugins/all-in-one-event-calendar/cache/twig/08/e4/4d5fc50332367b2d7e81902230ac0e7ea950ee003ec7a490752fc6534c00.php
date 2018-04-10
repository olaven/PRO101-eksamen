<?php

/* navigation.twig */
class __TwigTemplate_08e44d5fc50332367b2d7e81902230ac0e7ea950ee003ec7a490752fc6534c00 extends Twig_Template
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
        echo "<div class=\"ai1ec-clearfix\">
\t";
        // line 2
        echo (isset($context["views_dropdown"]) ? $context["views_dropdown"] : null);
        echo "
\t<div class=\"ai1ec-title-buttons ai1ec-btn-toolbar\">
\t\t";
        // line 4
        echo (isset($context["before_pagination"]) ? $context["before_pagination"] : null);
        echo "
\t\t";
        // line 5
        echo (isset($context["pagination_links"]) ? $context["pagination_links"] : null);
        echo "
\t\t";
        // line 6
        echo (isset($context["after_pagination"]) ? $context["after_pagination"] : null);
        echo "
\t\t";
        // line 7
        if (array_key_exists("contribution_buttons", $context)) {
            // line 8
            echo "\t\t\t";
            echo (isset($context["contribution_buttons"]) ? $context["contribution_buttons"] : null);
            echo "
\t\t";
        }
        // line 10
        echo "\t</div>
\t";
        // line 11
        if (array_key_exists("below_toolbar", $context)) {
            // line 12
            echo "\t\t";
            echo (isset($context["below_toolbar"]) ? $context["below_toolbar"] : null);
            echo "
\t";
        }
        // line 14
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "navigation.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 12,  47 => 10,  41 => 8,  35 => 6,  60 => 13,  48 => 8,  40 => 6,  29 => 4,  22 => 2,  28 => 5,  24 => 4,  218 => 86,  210 => 81,  206 => 79,  204 => 78,  195 => 72,  190 => 70,  184 => 69,  176 => 64,  171 => 62,  165 => 61,  162 => 60,  160 => 59,  153 => 55,  148 => 53,  142 => 52,  134 => 47,  129 => 45,  123 => 44,  115 => 39,  110 => 37,  104 => 36,  96 => 31,  91 => 29,  85 => 28,  78 => 25,  73 => 23,  68 => 20,  65 => 19,  59 => 17,  53 => 15,  44 => 7,  42 => 11,  34 => 5,  27 => 4,  25 => 4,  23 => 3,  86 => 26,  75 => 24,  70 => 19,  66 => 14,  62 => 17,  58 => 14,  54 => 11,  50 => 11,  43 => 13,  39 => 7,  31 => 5,  26 => 3,  21 => 2,  19 => 1,);
    }
}
