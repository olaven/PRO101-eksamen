<?php

/* form-elements/input.twig */
class __TwigTemplate_f33591d24d07f386c1027eeea2cbf1deffececd4acae7346e2c250942cfcff65 extends Twig_Template
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
        // line 19
        echo "
";
    }

    // line 1
    public function getinput($_id = null, $_name = "", $_value = "", $_type = "text", $_attributes = array())
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $_id,
            "name" => $_name,
            "value" => $_value,
            "type" => $_type,
            "attributes" => $_attributes,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 2
            echo "\t";
            if (((isset($context["name"]) ? $context["name"] : null) == "")) {
                // line 3
                echo "\t\t";
                $context["id"] = (isset($context["name"]) ? $context["name"] : null);
                // line 4
                echo "\t";
            }
            // line 5
            echo "\t<input
\t\ttype=\"";
            // line 6
            echo twig_escape_filter($this->env, (isset($context["type"]) ? $context["type"] : null), "html", null, true);
            echo "\"
\t\tname=\"";
            // line 7
            echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
            echo "\"
\t\tvalue=\"";
            // line 8
            echo twig_escape_filter($this->env, (isset($context["value"]) ? $context["value"] : null), "html", null, true);
            echo "\"
\t\tid=\"";
            // line 9
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "\"
\t\tclass=\"";
            // line 10
            if (!twig_in_filter((isset($context["type"]) ? $context["type"] : null), array(0 => "radio", 1 => "checkbox"))) {
                echo "ai1ec-form-control";
            }
            // line 11
            echo "\t\t\t";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "class"), "html", null, true);
            echo "\"
\t\t";
            // line 12
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["attributes"]) ? $context["attributes"] : null));
            foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
                // line 13
                echo "\t\t\t";
                if (((isset($context["attribute"]) ? $context["attribute"] : null) != "class")) {
                    // line 14
                    echo "\t\t\t\t";
                    echo twig_escape_filter($this->env, (isset($context["attribute"]) ? $context["attribute"] : null), "html", null, true);
                    echo "=\"";
                    echo twig_escape_filter($this->env, (isset($context["value"]) ? $context["value"] : null), "html", null, true);
                    echo "\"
\t\t\t";
                }
                // line 16
                echo "\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 17
            echo "\t\t/>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 20
    public function getbutton($_id = null, $_name = "", $_value = "", $_type = "text", $_attributes = array())
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $_id,
            "name" => $_name,
            "value" => $_value,
            "type" => $_type,
            "attributes" => $_attributes,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 21
            echo "\t";
            if (((isset($context["name"]) ? $context["name"] : null) == "")) {
                // line 22
                echo "\t\t";
                $context["id"] = (isset($context["name"]) ? $context["name"] : null);
                // line 23
                echo "\t";
            }
            // line 24
            echo "\t<button
\t\ttype=\"";
            // line 25
            echo twig_escape_filter($this->env, (isset($context["type"]) ? $context["type"] : null), "html", null, true);
            echo "\"
\t\tname=\"";
            // line 26
            echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
            echo "\"
\t\tid=\"";
            // line 27
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "\"
\t\t";
            // line 28
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["attributes"]) ? $context["attributes"] : null));
            foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
                // line 29
                echo "\t\t\t";
                echo twig_escape_filter($this->env, (isset($context["attribute"]) ? $context["attribute"] : null), "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, (isset($context["value"]) ? $context["value"] : null), "html", null, true);
                echo "\"
\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 31
            echo "\t\t>";
            echo (isset($context["value"]) ? $context["value"] : null);
            echo "</button>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "form-elements/input.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  163 => 31,  152 => 29,  148 => 28,  144 => 27,  140 => 26,  136 => 25,  133 => 24,  127 => 22,  124 => 21,  109 => 20,  97 => 17,  91 => 16,  76 => 12,  71 => 11,  67 => 10,  48 => 5,  24 => 1,  19 => 19,  168 => 36,  162 => 35,  156 => 33,  145 => 31,  141 => 30,  137 => 29,  134 => 28,  130 => 23,  121 => 24,  110 => 22,  106 => 21,  102 => 20,  99 => 19,  95 => 18,  90 => 17,  87 => 16,  83 => 14,  80 => 13,  74 => 13,  66 => 11,  63 => 9,  59 => 8,  55 => 7,  44 => 5,  21 => 1,  42 => 3,  38 => 3,  35 => 2,  25 => 2,  39 => 2,  58 => 12,  45 => 4,  37 => 7,  33 => 5,  51 => 6,  47 => 6,  43 => 9,  41 => 4,  36 => 6,  32 => 4,  27 => 3,  23 => 2,  20 => 1,  34 => 6,  31 => 4,  28 => 3,);
    }
}
