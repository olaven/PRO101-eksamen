<?php

/* theme-options/color-picker.twig */
class __TwigTemplate_65b5a575e6bf538d410a2e2197c73140d993d521b56e32435cddb3734e0f2db9 extends Twig_Template
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
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_variable($context, array $blocks = array())
    {
        // line 4
        ob_start();
        // line 5
        echo "<div class=\"ai1ec-col-sm-6 ai1ec-col-xs-9\">
  <div class=\"ai1ec-input-group color colorpickers\"
    data-color=\"";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["value"]) ? $context["value"] : null), "html", null, true);
        echo "\"
    data-color-format=\"";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["format"]) ? $context["format"] : null), "html", null, true);
        echo "\">
  \t<input type=\"text\" id=\"";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "\" name=\"";
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "\" class=\"ai1ec-form-control\"
      ";
        // line 10
        echo twig_escape_filter($this->env, (isset($context["readonly"]) ? $context["readonly"] : null), "html", null, true);
        echo " value=\"";
        echo twig_escape_filter($this->env, (isset($context["value"]) ? $context["value"] : null), "html", null, true);
        echo "\">
  \t<span class=\"ai1ec-input-group-addon\">
      <i style=\"background-color: ";
        // line 12
        echo twig_escape_filter($this->env, (isset($context["value"]) ? $context["value"] : null), "html", null, true);
        echo "\"></i>
    </span>
  </div>
</div>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return "theme-options/color-picker.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 12,  45 => 9,  37 => 7,  33 => 5,  51 => 10,  47 => 12,  43 => 9,  41 => 8,  36 => 6,  32 => 5,  27 => 3,  23 => 2,  20 => 1,  34 => 4,  31 => 4,  28 => 3,);
    }
}
