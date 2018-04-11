<?php

/* ShopManagementBundle:Category:AllCategoriesForHeader.html.twig */
class __TwigTemplate_b95b77bc066085d5dd6b84288cdfe31d1ad3b3db1a16f2de16cd8daf6385637b extends Twig_Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "ShopManagementBundle:Category:AllCategoriesForHeader.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "ShopManagementBundle:Category:AllCategoriesForHeader.html.twig"));

        // line 1
        echo "
<table id=\"categories_table\">
    <tr>
    
    <td>
            ";
        // line 6
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(range(0, 2));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 7
            echo "                <h4>
                    <a href=\"javascript:void(0);\"
                       class=\"show_category_trigger\"
                       data-id=\"";
            // line 10
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 0, array(), "array"), "id", array()), "html", null, true);
            echo "\"
                       >";
            // line 11
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans((($this->getAttribute($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 0, array(), "array"), "Name", array()) . ".") . $this->getAttribute($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 0, array(), "array"), "Name", array()))), "html", null, true);
            echo "
                    </a>
                </h4>
                <ul>
                    ";
            // line 15
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 1, array(), "array"));
            foreach ($context['_seq'] as $context["_key"] => $context["subCategory"]) {
                // line 16
                echo "                        <li>
                            <a href=\"javascript:void(0);\" 
                                class=\"show_category_trigger\"
                                data-id=\"";
                // line 19
                echo twig_escape_filter($this->env, $this->getAttribute($context["subCategory"], "id", array()), "html", null, true);
                echo "\"
                                >";
                // line 20
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans((($this->getAttribute($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 0, array(), "array"), "Name", array()) . ".") . $this->getAttribute($context["subCategory"], "Name", array()))), "html", null, true);
                echo "
                            </a>
                            </li>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['subCategory'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 23
            echo " 
                </ul>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo "        </td>
        
        <td>
            ";
        // line 29
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(range(3, 5));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 30
            echo "                <h4>
                    <a href=\"javascript:void(0);\"
                       class=\"show_category_trigger\"
                       data-id=\"";
            // line 33
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 0, array(), "array"), "id", array()), "html", null, true);
            echo "\"
                       >";
            // line 34
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans((($this->getAttribute($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 0, array(), "array"), "Name", array()) . ".") . $this->getAttribute($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 0, array(), "array"), "Name", array()))), "html", null, true);
            echo "
                    </a>
                </h4>
                <ul>
                    ";
            // line 38
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 1, array(), "array"));
            foreach ($context['_seq'] as $context["_key"] => $context["subCategory"]) {
                // line 39
                echo "                        <li>
                            <a href=\"javascript:void(0);\" 
                                class=\"show_category_trigger\"
                                data-id=\"";
                // line 42
                echo twig_escape_filter($this->env, $this->getAttribute($context["subCategory"], "id", array()), "html", null, true);
                echo "\"
                                >";
                // line 43
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans((($this->getAttribute($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 0, array(), "array"), "Name", array()) . ".") . $this->getAttribute($context["subCategory"], "Name", array()))), "html", null, true);
                echo "
                            </a>
                            </li>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['subCategory'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 46
            echo " 
                </ul>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 49
        echo "        </td>
            
        <td>
             ";
        // line 52
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(range(6, 19));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 53
            echo "                <h4>
                    <a href=\"javascript:void(0);\"
                       class=\"show_category_trigger\"
                       data-id=\"";
            // line 56
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 0, array(), "array"), "id", array()), "html", null, true);
            echo "\"
                       >";
            // line 57
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans((($this->getAttribute($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 0, array(), "array"), "Name", array()) . ".") . $this->getAttribute($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 0, array(), "array"), "Name", array()))), "html", null, true);
            echo "
                    </a>
                </h4>
                <ul>
                    ";
            // line 61
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 1, array(), "array"));
            foreach ($context['_seq'] as $context["_key"] => $context["subCategory"]) {
                // line 62
                echo "                        <li>
                            <a href=\"javascript:void(0);\" 
                                class=\"show_category_trigger\"
                                data-id=\"";
                // line 65
                echo twig_escape_filter($this->env, $this->getAttribute($context["subCategory"], "id", array()), "html", null, true);
                echo "\"
                                >";
                // line 66
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans((($this->getAttribute($this->getAttribute($this->getAttribute(($context["categories"] ?? $this->getContext($context, "categories")), $context["i"], array(), "array"), 0, array(), "array"), "Name", array()) . ".") . $this->getAttribute($context["subCategory"], "Name", array()))), "html", null, true);
                echo "
                            </a>
                            </li>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['subCategory'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 69
            echo " 
                </ul>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 72
        echo "        </td>
    </tr>
</table>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "ShopManagementBundle:Category:AllCategoriesForHeader.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  195 => 72,  187 => 69,  177 => 66,  173 => 65,  168 => 62,  164 => 61,  157 => 57,  153 => 56,  148 => 53,  144 => 52,  139 => 49,  131 => 46,  121 => 43,  117 => 42,  112 => 39,  108 => 38,  101 => 34,  97 => 33,  92 => 30,  88 => 29,  83 => 26,  75 => 23,  65 => 20,  61 => 19,  56 => 16,  52 => 15,  45 => 11,  41 => 10,  36 => 7,  32 => 6,  25 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("
<table id=\"categories_table\">
    <tr>
    
    <td>
            {% for i in 0..2 %}
                <h4>
                    <a href=\"javascript:void(0);\"
                       class=\"show_category_trigger\"
                       data-id=\"{{categories[i][0].id}}\"
                       >{{ (categories[i][0].Name~'.'~categories[i][0].Name) | trans }}
                    </a>
                </h4>
                <ul>
                    {% for subCategory in categories[i][1] %}
                        <li>
                            <a href=\"javascript:void(0);\" 
                                class=\"show_category_trigger\"
                                data-id=\"{{subCategory.id}}\"
                                >{{ (categories[i][0].Name~'.'~subCategory.Name)| trans }}
                            </a>
                            </li>
                    {%endfor%} 
                </ul>
            {%endfor%}
        </td>
        
        <td>
            {% for i in 3..5 %}
                <h4>
                    <a href=\"javascript:void(0);\"
                       class=\"show_category_trigger\"
                       data-id=\"{{categories[i][0].id}}\"
                       >{{ (categories[i][0].Name~'.'~categories[i][0].Name) | trans }}
                    </a>
                </h4>
                <ul>
                    {% for subCategory in categories[i][1] %}
                        <li>
                            <a href=\"javascript:void(0);\" 
                                class=\"show_category_trigger\"
                                data-id=\"{{subCategory.id}}\"
                                >{{ (categories[i][0].Name~'.'~subCategory.Name)| trans }}
                            </a>
                            </li>
                    {%endfor%} 
                </ul>
            {%endfor%}
        </td>
            
        <td>
             {% for i in 6..19 %}
                <h4>
                    <a href=\"javascript:void(0);\"
                       class=\"show_category_trigger\"
                       data-id=\"{{categories[i][0].id}}\"
                       >{{ (categories[i][0].Name~'.'~categories[i][0].Name) | trans }}
                    </a>
                </h4>
                <ul>
                    {% for subCategory in categories[i][1] %}
                        <li>
                            <a href=\"javascript:void(0);\" 
                                class=\"show_category_trigger\"
                                data-id=\"{{subCategory.id}}\"
                                >{{ (categories[i][0].Name~'.'~subCategory.Name)| trans }}
                            </a>
                            </li>
                    {%endfor%} 
                </ul>
            {%endfor%}
        </td>
    </tr>
</table>
", "ShopManagementBundle:Category:AllCategoriesForHeader.html.twig", "/home/adib/devenv/src/Shop/Bundle/ManagementBundle/Resources/views/Category/AllCategoriesForHeader.html.twig");
    }
}
