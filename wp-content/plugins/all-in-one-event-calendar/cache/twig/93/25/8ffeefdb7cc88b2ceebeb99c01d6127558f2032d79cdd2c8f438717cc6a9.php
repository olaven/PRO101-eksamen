<?php

/* theme-options/page.twig */
class __TwigTemplate_93258ffeefdb7cc88b2ceebeb99c01d6127558f2032d79cdd2c8f438717cc6a9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("base_page.twig");

        $this->blocks = array(
            'layout' => array($this, 'block_layout'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base_page.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_layout($context, array $blocks = array())
    {
        // line 3
        echo "<div class=\"post-box-container left-side timely\">
\t";
        // line 4
        echo twig_escape_filter($this->env, $this->env->getExtension('ai1ec')->do_meta_boxes($this->getAttribute((isset($context["metabox"]) ? $context["metabox"] : null), "screen"), $this->getAttribute((isset($context["metabox"]) ? $context["metabox"] : null), "action"), $this->getAttribute((isset($context["metabox"]) ? $context["metabox"] : null), "object")), "html", null, true);
        echo "
</div>
";
    }

    public function getTemplateName()
    {
        return "theme-options/page.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  34 => 4,  31 => 3,  28 => 2,);
    }
}
