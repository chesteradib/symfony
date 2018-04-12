<?php

/* MembersManagementBundle::search.html.twig */
class __TwigTemplate_f7bbe62b62395410584fc48ecbf70eab59896658dd38bc597ec2bb326eeb82b2 extends Twig_Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "MembersManagementBundle::search.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "MembersManagementBundle::search.html.twig"));

        // line 1
        echo "<form id=\"search-form\" 
      class=\"searchbar-form\" 
      method=\"post\" 
      action=\"";
        // line 4
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("site_search");
        echo "\"
      >      
\t<input type=\"text\" 
               class=\"search-keyword\" 
               name=\"SearchText\"
               ";
        // line 10
        echo "               tabindex=\"1\" 
               onfocus=\"if (this.value=='";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("menu.search.search_in_all_site"), "html", null, true);
        echo "') this.value = ''\" 
               maxlength=\"140\" 
               size=\"28\" 
               value=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("menu.search.search_in_all_site"), "html", null, true);
        echo "\"
               >
        <input type=\"submit\" class=\"search-button\" value>
</form>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "MembersManagementBundle::search.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  47 => 14,  41 => 11,  38 => 10,  30 => 4,  25 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<form id=\"search-form\" 
      class=\"searchbar-form\" 
      method=\"post\" 
      action=\"{{path('site_search')}}\"
      >      
\t<input type=\"text\" 
               class=\"search-keyword\" 
               name=\"SearchText\"
               {# placeholder=\"{{ 'menu.search.search_in_all_site'| trans }}\" #}
               tabindex=\"1\" 
               onfocus=\"if (this.value=='{{ 'menu.search.search_in_all_site'| trans }}') this.value = ''\" 
               maxlength=\"140\" 
               size=\"28\" 
               value=\"{{ 'menu.search.search_in_all_site'| trans }}\"
               >
        <input type=\"submit\" class=\"search-button\" value>
</form>", "MembersManagementBundle::search.html.twig", "/vagrant/src/Members/Bundle/ManagementBundle/Resources/views/search.html.twig");
    }
}
