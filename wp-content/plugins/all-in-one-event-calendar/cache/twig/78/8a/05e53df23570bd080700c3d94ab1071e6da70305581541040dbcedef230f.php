<?php

/* theme-options/bootstrap_tabs.twig */
class __TwigTemplate_788a05e53df23570bd080700c3d94ab1071e6da70305581541040dbcedef230f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("bootstrap_tabs.twig");

        $this->blocks = array(
            'extra_html' => array($this, 'block_extra_html'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "bootstrap_tabs.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_extra_html($context, array $blocks = array())
    {
        // line 3
        echo "\t";
        $context["__internal_755d951e99219ff721a94985cd8b4284d2986e6a948935a8456a1e1c8071953d"] = $this->env->loadTemplate("form-elements/input.twig");
        // line 4
        echo "\t<div class=\"ai1ec-text-right\">
\t\t<div class=\"ai1ec-btn-toolbar\">
\t\t\t";
        // line 6
        echo $context["__internal_755d951e99219ff721a94985cd8b4284d2986e6a948935a8456a1e1c8071953d"]->getbutton($this->getAttribute((isset($context["submit"]) ? $context["submit"] : null), "id"), $this->getAttribute((isset($context["submit"]) ? $context["submit"] : null), "id"), $this->getAttribute((isset($context["submit"]) ? $context["submit"] : null), "value"), "submit", $this->getAttribute((isset($context["submit"]) ? $context["submit"] : null), "args"));
        echo "
\t\t\t";
        // line 7
        echo $context["__internal_755d951e99219ff721a94985cd8b4284d2986e6a948935a8456a1e1c8071953d"]->getbutton($this->getAttribute((isset($context["reset"]) ? $context["reset"] : null), "id"), $this->getAttribute((isset($context["reset"]) ? $context["reset"] : null), "id"), $this->getAttribute((isset($context["reset"]) ? $context["reset"] : null), "value"), "submit", $this->getAttribute((isset($context["reset"]) ? $context["reset"] : null), "args"));
        echo "
\t\t</div>
\t</div>
";
    }

    public function getTemplateName()
    {
        return "theme-options/bootstrap_tabs.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 3,  163 => 31,  152 => 29,  148 => 28,  144 => 27,  140 => 26,  136 => 25,  133 => 24,  127 => 22,  124 => 21,  109 => 20,  97 => 17,  91 => 16,  76 => 12,  71 => 11,  67 => 10,  48 => 5,  24 => 1,  19 => 19,  168 => 36,  162 => 35,  156 => 33,  145 => 31,  141 => 30,  137 => 29,  134 => 28,  130 => 23,  121 => 24,  110 => 22,  106 => 21,  102 => 20,  99 => 19,  95 => 18,  90 => 17,  87 => 16,  83 => 14,  80 => 13,  74 => 13,  66 => 11,  63 => 9,  59 => 8,  55 => 7,  44 => 5,  21 => 1,  42 => 7,  38 => 6,  35 => 2,  25 => 2,  39 => 2,  58 => 12,  45 => 4,  37 => 7,  33 => 4,  51 => 6,  47 => 6,  43 => 9,  41 => 4,  36 => 5,  32 => 4,  27 => 3,  23 => 2,  20 => 1,  34 => 4,  31 => 3,  28 => 2,);
    }
}
