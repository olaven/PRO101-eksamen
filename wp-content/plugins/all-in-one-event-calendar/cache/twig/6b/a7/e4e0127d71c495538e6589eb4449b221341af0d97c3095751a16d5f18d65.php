<?php

/* theme-options/base_option.twig */
class __TwigTemplate_6ba7e4e0127d71c495538e6589eb4449b221341af0d97c3095751a16d5f18d65 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'variable' => array($this, 'block_variable'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"ai1ec-form-group\">
\t<label for=\"";
        // line 2
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "\" class=\"ai1ec-col-sm-4 ai1ec-col-xs-12 ai1ec-control-label\">
    ";
        // line 3
        echo twig_escape_filter($this->env, (isset($context["label"]) ? $context["label"] : null), "html", null, true);
        echo "
  </label>
\t";
        // line 5
        $this->displayBlock('variable', $context, $blocks);
        // line 6
        echo "</div>
";
    }

    // line 5
    public function block_variable($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "theme-options/base_option.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 5,  58 => 12,  45 => 9,  37 => 7,  33 => 5,  51 => 10,  47 => 12,  43 => 9,  41 => 8,  36 => 6,  32 => 5,  27 => 3,  23 => 2,  20 => 1,  34 => 6,  31 => 4,  28 => 3,);
    }
}
