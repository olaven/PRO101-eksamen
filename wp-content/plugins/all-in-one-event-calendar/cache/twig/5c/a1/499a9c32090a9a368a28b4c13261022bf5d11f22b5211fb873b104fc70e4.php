<?php

/* agenda.twig */
class __TwigTemplate_5ca1499a9c32090a9a368a28b4c13261022bf5d11f22b5211fb873b104fc70e4 extends Twig_Template
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
        echo (isset($context["navigation"]) ? $context["navigation"] : null);
        echo "

<div class=\"ai1ec-agenda-view";
        // line 3
        if ((isset($context["has_product_buy_button"]) ? $context["has_product_buy_button"] : null)) {
            echo " ai1ec-has-product-buy-button";
        }
        echo "\">
\t";
        // line 4
        if (twig_test_empty((isset($context["dates"]) ? $context["dates"] : null))) {
            // line 5
            echo "\t\t<p class=\"ai1ec-no-results\">
\t\t\t";
            // line 6
            echo twig_escape_filter($this->env, (isset($context["text_upcoming_events"]) ? $context["text_upcoming_events"] : null), "html", null, true);
            echo "
\t\t</p>
\t";
        } else {
            // line 9
            echo "\t\t";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["dates"]) ? $context["dates"] : null));
            foreach ($context['_seq'] as $context["date"] => $context["date_info"]) {
                // line 10
                echo "\t\t\t<div class=\"ai1ec-date
\t\t\t\t";
                // line 11
                if ((!twig_test_empty($this->getAttribute((isset($context["date_info"]) ? $context["date_info"] : null), "today")))) {
                    echo "ai1ec-today";
                }
                echo "\">
\t\t\t\t<a class=\"ai1ec-date-title ai1ec-load-view\"
\t\t\t\t\thref=\"";
                // line 13
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["date_info"]) ? $context["date_info"] : null), "href"), "html_attr");
                echo "\"
\t\t\t\t\t";
                // line 14
                echo (isset($context["data_type"]) ? $context["data_type"] : null);
                echo ">
\t\t\t\t\t<div class=\"ai1ec-month\">";
                // line 15
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["date_info"]) ? $context["date_info"] : null), "month"), "html", null, true);
                echo "</div>
\t\t\t\t\t<div class=\"ai1ec-day\">";
                // line 16
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["date_info"]) ? $context["date_info"] : null), "day"), "html", null, true);
                echo "</div>
\t\t\t\t\t<div class=\"ai1ec-weekday\">";
                // line 17
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["date_info"]) ? $context["date_info"] : null), "weekday"), "html", null, true);
                echo "</div>
\t\t\t\t\t";
                // line 18
                if ((isset($context["show_year_in_agenda_dates"]) ? $context["show_year_in_agenda_dates"] : null)) {
                    // line 19
                    echo "\t\t\t\t\t\t<div class=\"ai1ec-year\">";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["date_info"]) ? $context["date_info"] : null), "year"), "html", null, true);
                    echo "</div>
\t\t\t\t\t";
                }
                // line 21
                echo "\t\t\t\t</a>
\t\t\t\t<div class=\"ai1ec-date-events\">
\t\t\t\t\t";
                // line 23
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["date_info"]) ? $context["date_info"] : null), "events"));
                foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
                    // line 24
                    echo "\t\t\t\t\t\t";
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable((isset($context["category"]) ? $context["category"] : null));
                    foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
                        // line 25
                        echo "\t\t\t\t\t\t\t<div class=\"ai1ec-event
\t\t\t\t\t\t\t\tai1ec-event-id-";
                        // line 26
                        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "post_id"), "html", null, true);
                        echo "
\t\t\t\t\t\t\t\tai1ec-event-instance-id-";
                        // line 27
                        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "instance_id"), "html", null, true);
                        echo "
\t\t\t\t\t\t\t\t";
                        // line 28
                        if ($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "is_allday")) {
                            echo "ai1ec-allday";
                        }
                        // line 29
                        echo "\t\t\t\t\t\t\t\t";
                        if ((isset($context["expanded"]) ? $context["expanded"] : null)) {
                            echo "ai1ec-expanded";
                        }
                        echo "\"
\t\t\t\t\t\t\t\t";
                        // line 30
                        if ((!twig_test_empty($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "ticket_url")))) {
                            // line 31
                            echo "\t\t\t\t\t\t\t\t\tdata-ticket-url=\"";
                            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "ticket_url"), "html_attr");
                            echo "\"
\t\t\t\t\t\t\t\t";
                        }
                        // line 33
                        echo "\t\t\t\t\t\t\t\tdata-end=\"";
                        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "end"), "html", null, true);
                        echo "\">

\t\t\t\t\t\t\t\t<div class=\"ai1ec-event-header\">
\t\t\t\t\t\t\t\t\t<div class=\"ai1ec-event-toggle\">
\t\t\t\t\t\t\t\t\t\t<i class=\"ai1ec-fa ai1ec-fa-minus-circle ai1ec-fa-lg\"></i>
\t\t\t\t\t\t\t\t\t\t<i class=\"ai1ec-fa ai1ec-fa-plus-circle ai1ec-fa-lg\"></i>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<span class=\"ai1ec-event-title\">
\t\t\t\t\t\t\t\t\t\t";
                        // line 41
                        echo $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "filtered_title");
                        echo "
\t\t\t\t\t\t\t\t\t\t";
                        // line 42
                        if (((isset($context["show_location_in_title"]) ? $context["show_location_in_title"] : null) && (!twig_test_empty($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "venue"))))) {
                            // line 43
                            echo "\t\t\t\t\t\t\t\t\t\t\t<span class=\"ai1ec-event-location\"
\t\t\t\t\t\t\t\t\t\t\t\t>";
                            // line 44
                            echo twig_escape_filter($this->env, sprintf((isset($context["text_venue_separator"]) ? $context["text_venue_separator"] : null), $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "venue")), "html", null, true);
                            echo "</span>
\t\t\t\t\t\t\t\t\t\t";
                        }
                        // line 46
                        echo "\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t";
                        // line 47
                        echo (isset($context["action_buttons"]) ? $context["action_buttons"] : null);
                        echo "
\t\t\t\t\t\t\t\t\t";
                        // line 48
                        $context["edit_post_link"] = $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "edit_post_link");
                        // line 49
                        echo "\t\t\t\t\t\t\t\t\t";
                        if ((!twig_test_empty((isset($context["edit_post_link"]) ? $context["edit_post_link"] : null)))) {
                            // line 50
                            echo "\t\t\t\t\t\t\t\t\t\t<a class=\"post-edit-link\" href=\"";
                            echo (isset($context["edit_post_link"]) ? $context["edit_post_link"] : null);
                            echo "\">
\t\t\t\t\t\t\t\t\t\t\t<i class=\"ai1ec-fa ai1ec-fa-pencil\"></i> ";
                            // line 51
                            echo twig_escape_filter($this->env, (isset($context["text_edit"]) ? $context["text_edit"] : null), "html", null, true);
                            echo "
\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t";
                        }
                        // line 54
                        echo "
\t\t\t\t\t\t\t\t\t<div class=\"ai1ec-event-time\">
\t\t\t\t\t\t\t\t\t\t ";
                        // line 56
                        echo $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "timespan_short");
                        echo "
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t";
                        // line 61
                        echo "\t\t\t\t\t\t\t\t<div class=\"ai1ec-event-summary ";
                        if ((isset($context["expanded"]) ? $context["expanded"] : null)) {
                            echo "ai1ec-expanded";
                        }
                        echo "\">

\t\t\t\t\t\t\t\t\t<div class=\"ai1ec-event-description\">
\t\t\t\t\t\t\t\t\t\t";
                        // line 64
                        if ((twig_test_empty($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "content_img_url")) && (!twig_test_empty($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "avatar_not_wrapped"))))) {
                            // line 65
                            echo "\t\t\t\t\t\t\t\t\t\t\t<a class=\"ai1ec-load-event\"
\t\t\t\t\t\t\t\t\t\t\t\thref=\"";
                            // line 66
                            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "permalink"), "html_attr");
                            echo "\">
\t\t\t\t\t\t\t\t\t\t\t\t";
                            // line 67
                            echo $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "avatar_not_wrapped");
                            echo "
\t\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t\t";
                        }
                        // line 70
                        echo "\t\t\t\t\t\t\t\t\t\t";
                        echo $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "filtered_content");
                        echo "
\t\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t\t<div class=\"ai1ec-event-summary-footer\">
\t\t\t\t\t\t\t\t\t\t<div class=\"ai1ec-btn-group ai1ec-actions\">
\t\t\t\t\t\t\t\t\t\t\t";
                        // line 75
                        if (((isset($context["is_ticket_button_enabled"]) ? $context["is_ticket_button_enabled"] : null) && (!twig_test_empty($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "ticket_url"))))) {
                            // line 76
                            echo "\t\t\t\t\t\t\t\t\t\t\t\t<a class=\"ai1ec-pull-right ai1ec-btn ai1ec-btn-primary
\t\t\t\t\t\t\t\t\t\t\t\t\t\tai1ec-btn-xs ai1ec-buy-tickets\"
\t\t\t\t\t\t\t\t\t\t\t\t\ttarget=\"_blank\"
\t\t\t\t\t\t\t\t\t\t\t\t\thref=\"";
                            // line 79
                            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "ticket_url"), "html_attr");
                            echo "\"
\t\t\t\t\t\t\t\t\t\t\t\t\t>";
                            // line 80
                            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "ticket_url_label"), "html", null, true);
                            echo "</a>
\t\t\t\t\t\t\t\t\t\t\t";
                        }
                        // line 82
                        echo "\t\t\t\t\t\t\t\t\t\t\t<a class=\"ai1ec-read-more ai1ec-btn ai1ec-btn-default
\t\t\t\t\t\t\t\t\t\t\t\tai1ec-load-event\"
\t\t\t\t\t\t\t\t\t\t\t\thref=\"";
                        // line 84
                        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "permalink"), "html_attr");
                        echo "\">
\t\t\t\t\t\t\t\t\t\t\t\t";
                        // line 85
                        echo twig_escape_filter($this->env, (isset($context["text_read_more"]) ? $context["text_read_more"] : null), "html", null, true);
                        echo " <i class=\"ai1ec-fa ai1ec-fa-arrow-right\"></i>
\t\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t";
                        // line 88
                        $context["categories"] = $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "categories_html");
                        // line 89
                        echo "\t\t\t\t\t\t\t\t\t\t";
                        $context["tags"] = $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "tags_html");
                        // line 90
                        echo "\t\t\t\t\t\t\t\t\t\t";
                        if ((!twig_test_empty((isset($context["categories"]) ? $context["categories"] : null)))) {
                            // line 91
                            echo "\t\t\t\t\t\t\t\t\t\t\t<span class=\"ai1ec-categories\">
\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"ai1ec-field-label\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"ai1ec-fa ai1ec-fa-folder-open\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t\t";
                            // line 94
                            echo twig_escape_filter($this->env, (isset($context["text_categories"]) ? $context["text_categories"] : null), "html", null, true);
                            echo "
\t\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t\t\t";
                            // line 96
                            echo (isset($context["categories"]) ? $context["categories"] : null);
                            echo "
\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t";
                        }
                        // line 99
                        echo "\t\t\t\t\t\t\t\t\t\t";
                        if ((!twig_test_empty((isset($context["tags"]) ? $context["tags"] : null)))) {
                            // line 100
                            echo "\t\t\t\t\t\t\t\t\t\t\t<span class=\"ai1ec-tags\">
\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"ai1ec-field-label\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"ai1ec-fa ai1ec-fa-tags\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t\t";
                            // line 103
                            echo twig_escape_filter($this->env, (isset($context["text_tags"]) ? $context["text_tags"] : null), "html", null, true);
                            echo "
\t\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t\t\t";
                            // line 105
                            echo (isset($context["tags"]) ? $context["tags"] : null);
                            echo "
\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t";
                        }
                        // line 108
                        echo "\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['event'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 112
                    echo " ";
                    // line 113
                    echo "\t\t\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                echo " ";
                // line 114
                echo "\t\t\t\t</div>
\t\t\t</div>
\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['date'], $context['date_info'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 116
            echo " ";
            // line 117
            echo "\t";
        }
        echo " ";
        // line 118
        echo "</div>

<div class=\"ai1ec-pull-left\">";
        // line 120
        echo (isset($context["pagination_links"]) ? $context["pagination_links"] : null);
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "agenda.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  330 => 120,  326 => 118,  322 => 117,  320 => 116,  312 => 114,  305 => 113,  303 => 112,  293 => 108,  287 => 105,  282 => 103,  277 => 100,  274 => 99,  268 => 96,  263 => 94,  258 => 91,  255 => 90,  252 => 89,  250 => 88,  244 => 85,  240 => 84,  236 => 82,  231 => 80,  227 => 79,  222 => 76,  220 => 75,  211 => 70,  205 => 67,  201 => 66,  198 => 65,  196 => 64,  187 => 61,  180 => 56,  170 => 51,  156 => 47,  145 => 43,  143 => 42,  139 => 41,  127 => 33,  121 => 31,  119 => 30,  112 => 29,  108 => 28,  100 => 26,  97 => 25,  92 => 24,  88 => 23,  84 => 21,  76 => 18,  72 => 17,  64 => 15,  56 => 13,  49 => 11,  46 => 10,  32 => 5,  30 => 4,  38 => 7,  52 => 12,  47 => 10,  41 => 9,  35 => 6,  60 => 14,  48 => 8,  40 => 6,  29 => 4,  22 => 2,  28 => 4,  24 => 3,  218 => 86,  210 => 81,  206 => 79,  204 => 78,  195 => 72,  190 => 70,  184 => 69,  176 => 54,  171 => 62,  165 => 50,  162 => 49,  160 => 48,  153 => 46,  148 => 44,  142 => 52,  134 => 47,  129 => 45,  123 => 44,  115 => 39,  110 => 37,  104 => 27,  96 => 31,  91 => 29,  85 => 28,  78 => 19,  73 => 23,  68 => 16,  65 => 19,  59 => 17,  53 => 15,  44 => 10,  42 => 11,  34 => 5,  27 => 4,  25 => 3,  23 => 3,  86 => 26,  75 => 24,  70 => 19,  66 => 14,  62 => 17,  58 => 14,  54 => 11,  50 => 11,  43 => 13,  39 => 7,  31 => 5,  26 => 3,  21 => 2,  19 => 1,);
    }
}
