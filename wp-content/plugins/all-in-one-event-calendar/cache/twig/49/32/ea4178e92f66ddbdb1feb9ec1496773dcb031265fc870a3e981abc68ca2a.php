<?php

/* datepicker_link.twig */
class __TwigTemplate_4932ea4178e92f66ddbdb1feb9ec1496773dcb031265fc870a3e981abc68ca2a extends Twig_Template
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
        echo "<a
\tclass=\"ai1ec-minical-trigger ai1ec-btn ai1ec-btn-sm ai1ec-btn-default
    ai1ec-tooltip-trigger\"
\t";
        // line 4
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["attributes"]) ? $context["attributes"] : null));
        foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
            // line 5
            echo "\t\t";
            echo twig_escape_filter($this->env, (isset($context["attribute"]) ? $context["attribute"] : null), "html", null, true);
            echo "=\"";
            echo twig_escape_filter($this->env, (isset($context["value"]) ? $context["value"] : null), "html", null, true);
            echo "\"
\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 7
        echo "\t";
        echo (isset($context["data_type"]) ? $context["data_type"] : null);
        echo "
\ttitle=\"";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["text_date"]) ? $context["text_date"] : null), "html", null, true);
        echo "\"
\t>
\t<i class=\"ai1ec-fa ai1ec-fa-calendar-o ai1ec-fa-fw ai1ec-fa-lg\"></i>
  <span class=\"ai1ec-calendar-title\">";
        // line 11
        echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
        echo "</span>
  <span class=\"ai1ec-calendar-title-short\">";
        // line 12
        echo twig_escape_filter($this->env, (isset($context["title_short"]) ? $context["title_short"] : null), "html", null, true);
        echo "</span>
</a>
";
    }

    public function getTemplateName()
    {
        return "datepicker_link.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 5,  24 => 4,  218 => 86,  210 => 81,  206 => 79,  204 => 78,  195 => 72,  190 => 70,  184 => 69,  176 => 64,  171 => 62,  165 => 61,  162 => 60,  160 => 59,  153 => 55,  148 => 53,  142 => 52,  134 => 47,  129 => 45,  123 => 44,  115 => 39,  110 => 37,  104 => 36,  96 => 31,  91 => 29,  85 => 28,  78 => 25,  73 => 23,  68 => 20,  65 => 19,  59 => 17,  53 => 15,  44 => 8,  42 => 11,  34 => 6,  27 => 5,  25 => 4,  23 => 3,  86 => 26,  75 => 24,  70 => 19,  66 => 18,  62 => 17,  58 => 16,  54 => 12,  50 => 11,  43 => 13,  39 => 7,  31 => 7,  26 => 5,  21 => 2,  19 => 1,);
    }
}
