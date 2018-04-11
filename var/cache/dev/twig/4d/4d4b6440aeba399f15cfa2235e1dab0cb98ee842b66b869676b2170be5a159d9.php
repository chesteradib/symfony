<?php

/* MembersManagementBundle:HomePageInitial:HomePageHeader.html.twig */
class __TwigTemplate_9de4344cad753261d5a65024a3811ab4ac769ea295c219c1f4ba49bb03022b7f extends Twig_Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "MembersManagementBundle:HomePageInitial:HomePageHeader.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "MembersManagementBundle:HomePageInitial:HomePageHeader.html.twig"));

        // line 1
        $this->loadTemplate("MembersManagementBundle:HomePageInitial:header_dialogs.html.twig", "MembersManagementBundle:HomePageInitial:HomePageHeader.html.twig", 1)->display($context);
        echo " 

<div id=\"website_logo_in_homepage\">
    <a href=\"";
        // line 4
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("index");
        echo "\"></a>
</div>

<div class=\"my_search\">
    ";
        // line 8
        $this->loadTemplate("MembersManagementBundle::search.html.twig", "MembersManagementBundle:HomePageInitial:HomePageHeader.html.twig", 8)->display($context);
        echo " 
</div>

<div class=\"show_categories\">
    <a href=\"javascript:void(0);\" class=\"show_categories_trigger\"> 
        <div>";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("menu.navigate_by_category"), "html", null, true);
        echo "</div>
        <div class=\"show_categories_arrow\"></div>
    </a>
</div>
        
<div id=\"login_trigger_container\">
    <a href=\"javascript:void(0);\" class=\"login_trigger\">
        ";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("layout.login", array(), "FOSUserBundle"), "html", null, true);
        echo "
    </a>
</div>

<div id=\"signup_trigger_container\">
    <a href=\"javascript:void(0);\" class=\"signup_trigger\">
        ";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("layout.register", array(), "FOSUserBundle"), "html", null, true);
        echo "
    </a>
</div>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "MembersManagementBundle:HomePageInitial:HomePageHeader.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 26,  56 => 20,  46 => 13,  38 => 8,  31 => 4,  25 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% include \"MembersManagementBundle:HomePageInitial:header_dialogs.html.twig\" %} 

<div id=\"website_logo_in_homepage\">
    <a href=\"{{path('index')}}\"></a>
</div>

<div class=\"my_search\">
    {% include \"MembersManagementBundle::search.html.twig\" %} 
</div>

<div class=\"show_categories\">
    <a href=\"javascript:void(0);\" class=\"show_categories_trigger\"> 
        <div>{{ 'menu.navigate_by_category'| trans}}</div>
        <div class=\"show_categories_arrow\"></div>
    </a>
</div>
        
<div id=\"login_trigger_container\">
    <a href=\"javascript:void(0);\" class=\"login_trigger\">
        {{ 'layout.login'|trans({}, 'FOSUserBundle') }}
    </a>
</div>

<div id=\"signup_trigger_container\">
    <a href=\"javascript:void(0);\" class=\"signup_trigger\">
        {{ 'layout.register'|trans({}, 'FOSUserBundle') }}
    </a>
</div>
", "MembersManagementBundle:HomePageInitial:HomePageHeader.html.twig", "/home/adib/devenv/src/Members/Bundle/ManagementBundle/Resources/views/HomePageInitial/HomePageHeader.html.twig");
    }
}
