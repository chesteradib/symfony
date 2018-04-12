<?php

/* MembersManagementBundle:HomePageInitial:HomePageLeftInitial.html.twig */
class __TwigTemplate_9dab69e4de64e1b1ddee9f2ca1b345f5f7860ccf713cf1cc7fcc2d55c026f622 extends Twig_Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "MembersManagementBundle:HomePageInitial:HomePageLeftInitial.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "MembersManagementBundle:HomePageInitial:HomePageLeftInitial.html.twig"));

        // line 1
        echo "<div id=\"left_context\">
    <div id=\"center-context-articles-from\">
        
    </div>
</div>


<div id=\"left_content\">
    <div id=\"left-items-container\">
    ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(range(0, 20));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 11
            echo "       <div class=\"all_my_inbox_item left-item-container\"></div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "    </div>

    <div id=\"center-content-pagination\" class=\"left-pagination\"></div>
      
</div>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "MembersManagementBundle:HomePageInitial:HomePageLeftInitial.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  47 => 13,  40 => 11,  36 => 10,  25 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div id=\"left_context\">
    <div id=\"center-context-articles-from\">
        
    </div>
</div>


<div id=\"left_content\">
    <div id=\"left-items-container\">
    {% for i in 0..20 %}
       <div class=\"all_my_inbox_item left-item-container\"></div>
    {% endfor %}
    </div>

    <div id=\"center-content-pagination\" class=\"left-pagination\"></div>
      
</div>", "MembersManagementBundle:HomePageInitial:HomePageLeftInitial.html.twig", "/vagrant/src/Members/Bundle/ManagementBundle/Resources/views/HomePageInitial/HomePageLeftInitial.html.twig");
    }
}
