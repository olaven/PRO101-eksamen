<?php

/* notification/admin.twig */
class __TwigTemplate_a2d63fbda218850f7e089e33254a2a7e597c13d99697a035b078e57b486b58fd extends Twig_Template
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
        echo "<div class=\"message ";
        echo twig_escape_filter($this->env, (isset($context["class"]) ? $context["class"] : null), "html", null, true);
        echo " ai1ec-message\">
\t";
        // line 2
        if ((!array_key_exists("label", $context))) {
            // line 3
            echo "    ";
            $context["label"] = (isset($context["text_label"]) ? $context["text_label"] : null);
            // line 4
            echo "\t";
        }
        // line 5
        echo "\t<p><strong>";
        echo twig_escape_filter($this->env, (isset($context["label"]) ? $context["label"] : null), "html", null, true);
        echo ":</strong></p>
\t";
        // line 6
        echo (isset($context["message"]) ? $context["message"] : null);
        echo "

\t";
        // line 8
        if ((isset($context["persistent"]) ? $context["persistent"] : null)) {
            // line 9
            echo "\t\t<button class=\"button button-primary ai1ec-dismissable\"
\t\t\tdata-key=\"";
            // line 10
            echo twig_escape_filter($this->env, (isset($context["msg_key"]) ? $context["msg_key"] : null), "html", null, true);
            echo "\">
\t\t\t";
            // line 11
            echo twig_escape_filter($this->env, (isset($context["text_dismiss_button"]) ? $context["text_dismiss_button"] : null), "html", null, true);
            echo "
\t\t</button>
\t";
        }
        // line 14
        echo "\t<p></p>
</div>
";
    }

    public function getTemplateName()
    {
        return "notification/admin.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  57 => 14,  51 => 11,  44 => 9,  42 => 8,  37 => 6,  29 => 4,  26 => 3,  71 => 28,  58 => 17,  52 => 14,  49 => 13,  47 => 10,  40 => 8,  36 => 7,  32 => 5,  28 => 5,  24 => 2,  19 => 1,);
    }
}
