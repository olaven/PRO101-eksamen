<?php

/* views_dropdown.twig */
class __TwigTemplate_c1804f545c5b33b8114cc21fe6cb5c59952fa8c7d680d237c3ca4d3f63b96c1c extends Twig_Template
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
        if ((twig_length_filter($this->env, (isset($context["available_views"]) ? $context["available_views"] : null)) > 1)) {
            // line 2
            echo "\t<div class=\"ai1ec-views-dropdown ai1ec-btn-group ai1ec-pull-right\">
\t\t<a class=\"ai1ec-btn ai1ec-btn-sm ai1ec-btn-default ai1ec-dropdown-toggle\"
\t\t\tdata-toggle=\"ai1ec-dropdown\">
\t\t\t<i class=\"ai1ec-icon-";
            // line 5
            echo twig_escape_filter($this->env, (isset($context["current_view"]) ? $context["current_view"] : null), "html", null, true);
            echo " ai1ec-view-icon\"></i>
\t\t\t<span class=\"ai1ec-hidden-xs ai1ec-hidden-sm\">
\t\t\t\t";
            // line 7
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["view_names"]) ? $context["view_names"] : null), (isset($context["current_view"]) ? $context["current_view"] : null), array(), "array"), "html", null, true);
            echo "
\t\t\t</span>
\t\t\t<span class=\"ai1ec-caret\"></span>
\t\t</a>
\t\t<div class=\"ai1ec-dropdown-menu\">
\t\t\t";
            // line 12
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["available_views"]) ? $context["available_views"] : null));
            foreach ($context['_seq'] as $context["key"] => $context["args"]) {
                // line 13
                echo "\t\t\t\t<div class=\"";
                if (((isset($context["key"]) ? $context["key"] : null) == (isset($context["current_view"]) ? $context["current_view"] : null))) {
                    echo "ai1ec-active";
                }
                echo "\"
\t\t\t\t\tdata-action=\"";
                // line 14
                echo twig_escape_filter($this->env, (isset($context["key"]) ? $context["key"] : null), "html", null, true);
                echo "\">
\t\t\t\t\t<a id=\"ai1ec-view-";
                // line 15
                echo twig_escape_filter($this->env, (isset($context["key"]) ? $context["key"] : null), "html", null, true);
                echo "\"
\t\t\t\t\t\t";
                // line 16
                echo (isset($context["data_type"]) ? $context["data_type"] : null);
                echo "
\t\t\t\t\t\tclass=\"ai1ec-load-view ";
                // line 17
                echo twig_escape_filter($this->env, (isset($context["key"]) ? $context["key"] : null), "html", null, true);
                echo "\"
\t\t\t\t\t\thref=\"";
                // line 18
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["available_views"]) ? $context["available_views"] : null), (isset($context["key"]) ? $context["key"] : null), array(), "array"), "href"), "html", null, true);
                echo "\">
\t\t\t\t\t\t<i class=\"ai1ec-icon-";
                // line 19
                echo twig_escape_filter($this->env, (isset($context["key"]) ? $context["key"] : null), "html", null, true);
                echo " ai1ec-view-icon\"></i>
\t\t\t\t\t\t<span class=\"ai1ec-hidden-xs ai1ec-hidden-sm\">
\t\t\t\t\t\t\t";
                // line 21
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["available_views"]) ? $context["available_views"] : null), (isset($context["key"]) ? $context["key"] : null), array(), "array"), "desc"), "html", null, true);
                echo "
\t\t\t\t\t\t</span>
\t\t\t\t\t</a>
\t\t\t\t</div>
\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['args'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 26
            echo "\t\t</div>
\t</div>
";
        }
    }

    public function getTemplateName()
    {
        return "views_dropdown.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  86 => 26,  75 => 21,  70 => 19,  66 => 18,  62 => 17,  58 => 16,  54 => 15,  50 => 14,  43 => 13,  39 => 12,  31 => 7,  26 => 5,  21 => 2,  19 => 1,);
    }
}
