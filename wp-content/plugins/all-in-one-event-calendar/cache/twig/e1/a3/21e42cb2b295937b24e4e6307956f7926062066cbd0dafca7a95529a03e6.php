<?php

/* base_page.twig */
class __TwigTemplate_e1a321e42cb2b295937b24e4e6307956f7926062066cbd0dafca7a95529a03e6 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'layout' => array($this, 'block_layout'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"wrap\">
\t";
        // line 2
        echo twig_escape_filter($this->env, $this->env->getExtension('ai1ec')->screen_icon(), "html", null, true);
        echo "
\t<h2>";
        // line 3
        echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
        echo "</h2>
\t<div id=\"poststuff\">
\t\t<form method=\"post\" action=\"";
        // line 5
        echo twig_escape_filter($this->env, (isset($context["action"]) ? $context["action"] : null), "html", null, true);
        echo "\">
\t\t\t";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('ai1ec')->wp_nonce_field($this->getAttribute((isset($context["nonce"]) ? $context["nonce"] : null), "action"), $this->getAttribute((isset($context["nonce"]) ? $context["nonce"] : null), "name"), $this->getAttribute((isset($context["nonce"]) ? $context["nonce"] : null), "referrer")), "html", null, true);
        echo "
\t\t\t<div class=\"metabox-holder\">
\t\t\t\t";
        // line 8
        $this->displayBlock('layout', $context, $blocks);
        // line 9
        echo "\t\t\t</div>
\t\t</form>
\t</div>";
        // line 12
        echo "</div>";
    }

    // line 8
    public function block_layout($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "base_page.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 8,  47 => 12,  43 => 9,  41 => 8,  36 => 6,  32 => 5,  27 => 3,  23 => 2,  20 => 1,  34 => 4,  31 => 3,  28 => 2,);
    }
}
