<?php

/* bootstrap_tabs.twig */
class __TwigTemplate_1f5301836308ef8274b8f40f576da14b95efa5b66d8e5c3bbcd40df782e6fe3a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'extra_html' => array($this, 'block_extra_html'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        if ((isset($context["stacked"]) ? $context["stacked"] : null)) {
            echo "<div class=\"ai1ec-row\"><div class=\"ai1ec-col-sm-3\">";
        }
        // line 2
        echo "
<ul class=\"ai1ec-nav
\t";
        // line 4
        if ((isset($context["stacked"]) ? $context["stacked"] : null)) {
            // line 5
            echo "\t\tai1ec-nav-pills ai1ec-nav-stacked
\t";
        } else {
            // line 7
            echo "\t\tai1ec-nav-tabs
\t";
        }
        // line 8
        echo "\">

\t";
        // line 10
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["tabs"]) ? $context["tabs"] : null));
        foreach ($context['_seq'] as $context["id"] => $context["data"]) {
            if ($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "name", array(), "any", true, true)) {
                // line 11
                echo "\t\t";
                if ($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "items", array(), "any", true, true)) {
                    // line 12
                    echo "\t\t\t<li class=\"ai1ec-dropdown\">
\t\t\t\t<a href=\"#\" data-toggle=\"ai1ec-dropdown\">
\t\t\t\t\t";
                    // line 14
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "name"), "html", null, true);
                    echo " <i class=\"ai1ec-fa ai1ec-fa-caret-down\"></i>
\t\t\t\t</a>
\t\t\t\t<ul class=\"ai1ec-dropdown-menu\">
\t\t\t\t\t";
                    // line 17
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "items"));
                    foreach ($context['_seq'] as $context["drop_id"] => $context["drop_name"]) {
                        // line 18
                        echo "\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t<a href=\"#ai1ec-";
                        // line 19
                        echo twig_escape_filter($this->env, (isset($context["drop_id"]) ? $context["drop_id"] : null), "html", null, true);
                        echo "\" data-toggle=\"ai1ec-tab\">
\t\t\t\t\t\t\t\t";
                        // line 20
                        echo twig_escape_filter($this->env, (isset($context["drop_name"]) ? $context["drop_name"] : null), "html", null, true);
                        echo "
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</li>
\t\t\t\t\t";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['drop_id'], $context['drop_name'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 24
                    echo "\t\t\t\t</ul>
\t\t\t</li>
\t\t";
                } else {
                    // line 27
                    echo "\t\t\t<li>
\t\t\t\t<a href=\"#ai1ec-";
                    // line 28
                    echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
                    echo "\" data-toggle=\"ai1ec-tab\">";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "name"), "html", null, true);
                    echo "</a>
\t\t\t</li>
\t\t";
                }
                // line 31
                echo "\t";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['id'], $context['data'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "
</ul>

";
        // line 35
        if ((isset($context["stacked"]) ? $context["stacked"] : null)) {
            echo "</div><div class=\"ai1ec-col-sm-9\">";
        }
        // line 36
        echo "
<div class=\"ai1ec-tab-content ";
        // line 37
        echo twig_escape_filter($this->env, (isset($context["content_class"]) ? $context["content_class"] : null), "html", null, true);
        echo "\">
\t";
        // line 38
        echo (isset($context["pre_tabs_markup"]) ? $context["pre_tabs_markup"] : null);
        echo "
\t";
        // line 39
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["tabs"]) ? $context["tabs"] : null));
        foreach ($context['_seq'] as $context["id"] => $context["data"]) {
            // line 40
            echo "\t\t<div class=\"ai1ec-tab-pane\" id=\"ai1ec-";
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "\">
\t\t\t";
            // line 41
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "elements"));
            foreach ($context['_seq'] as $context["_key"] => $context["element"]) {
                // line 42
                echo "\t\t\t\t";
                echo $this->getAttribute((isset($context["element"]) ? $context["element"] : null), "html");
                echo "
\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['element'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 44
            echo "\t\t</div>
\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['id'], $context['data'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 46
        echo "</div>

";
        // line 48
        $this->displayBlock('extra_html', $context, $blocks);
        // line 50
        echo "
";
        // line 51
        if ((isset($context["stacked"]) ? $context["stacked"] : null)) {
            echo "</div></div>";
        }
    }

    // line 48
    public function block_extra_html($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "bootstrap_tabs.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  159 => 50,  157 => 48,  153 => 46,  146 => 44,  128 => 40,  120 => 38,  116 => 37,  113 => 36,  104 => 32,  89 => 28,  86 => 27,  81 => 24,  64 => 18,  60 => 17,  54 => 14,  50 => 12,  30 => 5,  163 => 31,  152 => 29,  148 => 28,  144 => 27,  140 => 26,  136 => 25,  133 => 41,  127 => 22,  124 => 39,  109 => 35,  97 => 31,  91 => 16,  76 => 12,  71 => 20,  67 => 19,  48 => 5,  24 => 2,  19 => 19,  168 => 48,  162 => 51,  156 => 33,  145 => 31,  141 => 30,  137 => 42,  134 => 28,  130 => 23,  121 => 24,  110 => 22,  106 => 21,  102 => 20,  99 => 19,  95 => 18,  90 => 17,  87 => 16,  83 => 14,  80 => 13,  74 => 13,  66 => 11,  63 => 9,  59 => 8,  55 => 7,  44 => 5,  21 => 1,  42 => 10,  38 => 8,  35 => 2,  25 => 2,  39 => 2,  58 => 12,  45 => 4,  37 => 7,  33 => 4,  51 => 6,  47 => 11,  43 => 9,  41 => 4,  36 => 5,  32 => 4,  27 => 3,  23 => 2,  20 => 1,  34 => 7,  31 => 3,  28 => 4,);
    }
}
