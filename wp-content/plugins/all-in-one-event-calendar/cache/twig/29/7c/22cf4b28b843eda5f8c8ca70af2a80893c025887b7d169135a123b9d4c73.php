<?php

/* theme-options/size.twig */
class __TwigTemplate_297c22cf4b28b843eda5f8c8ca70af2a80893c025887b7d169135a123b9d4c73 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("theme-options/base_option.twig");

        $this->blocks = array(
            'variable' => array($this, 'block_variable'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "theme-options/base_option.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        $context["__internal_dc1c3a5abd79051b9d9548b7691e83f4f730dc59dc2b85adcf544f1e39853a90"] = $this->env->loadTemplate("form-elements/input.twig");
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_variable($context, array $blocks = array())
    {
        // line 4
        echo "  <div class=\"ai1ec-col-sm-6 ai1ec-col-xs-9\">
    ";
        // line 5
        echo $context["__internal_dc1c3a5abd79051b9d9548b7691e83f4f730dc59dc2b85adcf544f1e39853a90"]->getinput((isset($context["id"]) ? $context["id"] : null), (isset($context["id"]) ? $context["id"] : null), (isset($context["value"]) ? $context["value"] : null), "text", (isset($context["args"]) ? $context["args"] : null));
        echo "
  </div>
";
    }

    public function getTemplateName()
    {
        return "theme-options/size.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 3,  163 => 31,  152 => 29,  148 => 28,  144 => 27,  140 => 26,  136 => 25,  133 => 24,  127 => 22,  124 => 21,  109 => 20,  97 => 17,  91 => 16,  76 => 12,  71 => 11,  67 => 10,  48 => 5,  24 => 1,  19 => 19,  168 => 36,  162 => 35,  156 => 33,  145 => 31,  141 => 30,  137 => 29,  134 => 28,  130 => 23,  121 => 24,  110 => 22,  106 => 21,  102 => 20,  99 => 19,  95 => 18,  90 => 17,  87 => 16,  83 => 14,  80 => 13,  74 => 13,  66 => 11,  63 => 9,  59 => 8,  55 => 7,  44 => 5,  21 => 1,  42 => 3,  38 => 3,  35 => 2,  25 => 2,  39 => 2,  58 => 12,  45 => 4,  37 => 7,  33 => 4,  51 => 6,  47 => 6,  43 => 9,  41 => 4,  36 => 5,  32 => 4,  27 => 3,  23 => 2,  20 => 1,  34 => 6,  31 => 4,  28 => 3,);
    }
}
