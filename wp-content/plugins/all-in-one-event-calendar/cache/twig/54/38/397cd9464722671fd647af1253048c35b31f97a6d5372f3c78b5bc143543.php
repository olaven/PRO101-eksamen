<?php

/* form-elements/select.twig */
class __TwigTemplate_5438397cd9464722671fd647af1253048c35b31f97a6d5372f3c78b5bc143543 extends Twig_Template
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
    }

    // line 1
    public function getselect($_id = null, $_name = "", $_attributes = array(), $_options = array())
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $_id,
            "name" => $_name,
            "attributes" => $_attributes,
            "options" => $_options,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 2
            echo "\t";
            if (((isset($context["name"]) ? $context["name"] : null) == "")) {
                // line 3
                echo "\t\t";
                $context["name"] = (isset($context["id"]) ? $context["id"] : null);
                // line 4
                echo "\t";
            }
            // line 5
            echo "\t<select
\t\tname=\"";
            // line 6
            echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
            echo "\"
\t\tid=\"";
            // line 7
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "\"
\t\tclass=\"ai1ec-form-control ";
            // line 8
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "class"), "html", null, true);
            echo "\"
\t\t";
            // line 9
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["attributes"]) ? $context["attributes"] : null));
            foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
                // line 10
                echo "\t\t\t";
                if (((isset($context["attribute"]) ? $context["attribute"] : null) != "class")) {
                    // line 11
                    echo "\t\t\t\t";
                    echo twig_escape_filter($this->env, (isset($context["attribute"]) ? $context["attribute"] : null), "html", null, true);
                    echo "=\"";
                    echo twig_escape_filter($this->env, (isset($context["value"]) ? $context["value"] : null), "html", null, true);
                    echo "\"
\t\t\t";
                }
                // line 13
                echo "\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 14
            echo "\t\t>
\t\t";
            // line 15
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["options"]) ? $context["options"] : null));
            foreach ($context['_seq'] as $context["key"] => $context["option"]) {
                // line 16
                echo "\t\t\t";
                if ($this->env->getExtension('ai1ec')->is_string((isset($context["key"]) ? $context["key"] : null))) {
                    // line 17
                    echo "\t\t\t\t<optgroup label=\"";
                    echo twig_escape_filter($this->env, (isset($context["key"]) ? $context["key"] : null), "html", null, true);
                    echo "\">
\t\t\t\t\t";
                    // line 18
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable((isset($context["option"]) ? $context["option"] : null));
                    foreach ($context['_seq'] as $context["_key"] => $context["opt"]) {
                        // line 19
                        echo "\t\t\t\t\t\t<option
\t\t\t\t\t\t\tvalue=\"";
                        // line 20
                        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["opt"]) ? $context["opt"] : null), "value"), "html", null, true);
                        echo "\"
\t\t\t\t\t\t";
                        // line 21
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["opt"]) ? $context["opt"] : null), "args"));
                        foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
                            // line 22
                            echo "\t\t\t\t\t\t\t";
                            echo twig_escape_filter($this->env, (isset($context["attribute"]) ? $context["attribute"] : null), "html", null, true);
                            echo "=\"";
                            echo twig_escape_filter($this->env, (isset($context["value"]) ? $context["value"] : null), "html", null, true);
                            echo "\"
\t\t\t\t\t\t";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 24
                        echo "\t\t\t\t\t\t>";
                        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["opt"]) ? $context["opt"] : null), "text"), "html", null, true);
                        echo "</option>
\t\t\t\t\t";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['opt'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 26
                    echo "\t\t\t\t</optgroup>
\t\t\t";
                } else {
                    // line 28
                    echo "\t\t\t\t<option
\t\t\t\t\tvalue=\"";
                    // line 29
                    echo $this->env->getExtension('ai1ec')->dropdown_filter($this->getAttribute((isset($context["option"]) ? $context["option"] : null), "value"));
                    echo "\"
\t\t\t\t";
                    // line 30
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["option"]) ? $context["option"] : null), "args"));
                    foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
                        // line 31
                        echo "\t\t\t\t\t";
                        echo twig_escape_filter($this->env, (isset($context["attribute"]) ? $context["attribute"] : null), "html", null, true);
                        echo "=\"";
                        echo twig_escape_filter($this->env, (isset($context["value"]) ? $context["value"] : null), "html", null, true);
                        echo "\"
\t\t\t\t";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 33
                    echo "\t\t\t\t>";
                    echo $this->env->getExtension('ai1ec')->dropdown_filter($this->getAttribute((isset($context["option"]) ? $context["option"] : null), "text"));
                    echo "</option>
\t\t\t";
                }
                // line 35
                echo "\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['option'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 36
            echo "\t\t</select>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "form-elements/select.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  168 => 36,  162 => 35,  156 => 33,  145 => 31,  141 => 30,  137 => 29,  134 => 28,  130 => 26,  121 => 24,  110 => 22,  106 => 21,  102 => 20,  99 => 19,  95 => 18,  90 => 17,  87 => 16,  83 => 15,  80 => 14,  74 => 13,  66 => 11,  63 => 10,  59 => 9,  55 => 8,  44 => 5,  21 => 1,  42 => 7,  38 => 3,  35 => 2,  25 => 2,  39 => 5,  58 => 12,  45 => 9,  37 => 7,  33 => 5,  51 => 7,  47 => 6,  43 => 9,  41 => 4,  36 => 6,  32 => 4,  27 => 3,  23 => 2,  20 => 1,  34 => 6,  31 => 4,  28 => 3,);
    }
}
