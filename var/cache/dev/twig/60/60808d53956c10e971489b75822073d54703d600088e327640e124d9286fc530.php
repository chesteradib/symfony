<?php

/* MembersManagementBundle:Index:index.html.twig */
class __TwigTemplate_b978dccd5ca0fea32ac11a45d19c609ae97ad5d31ec4f652662210c2a5cf20c8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::base.html.twig", "MembersManagementBundle:Index:index.html.twig", 1);
        $this->blocks = array(
            'myscript' => array($this, 'block_myscript'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "MembersManagementBundle:Index:index.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "MembersManagementBundle:Index:index.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_myscript($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "myscript"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "myscript"));

        // line 4
        echo "    <script type=\"text/javascript\" id= \"mscript\" data-url=\"";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("mobile_index", array("page" => 0));
        echo "\" >

        if( ('onorientationchange' in window) 
                || (window.screen.width< window.screen.height)
                || (window.screen.width< 1280)
                ) { 
            var url = document.getElementById('mscript').getAttribute('data-url');
            window.location.replace(url);
        }
    </script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 16
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 17
        echo "   <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("css/homepage_styles.css"), "html", null, true);
        echo "\" />
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 20
    public function block_body($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 21
        echo "    
";
        // line 22
        $this->loadTemplate("MembersManagementBundle:HomePageInitial:homePageTemplates.html.twig", "MembersManagementBundle:Index:index.html.twig", 22)->display($context);
        echo " 
    
<div id=\"header\">
      ";
        // line 25
        $this->loadTemplate("MembersManagementBundle:HomePageInitial:HomePageHeader.html.twig", "MembersManagementBundle:Index:index.html.twig", 25)->display($context);
        // line 26
        echo "</div>

<div id=\"content\" class=\"righty\" 
     data-is-login-login=\"0\"
     data-login-login-url=\"";
        // line 30
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_user_security_login");
        echo "\"
     data-all-new-posters-url=\"";
        // line 31
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("all_new_posters");
        echo "\"
     data-url-all-jawla=\"";
        // line 32
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("all_jawla");
        echo "\"
     data-url-category=\"";
        // line 33
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("show_category");
        echo "\"
     >
    
    <div id=\"left_container\">
        <div id=\"left_progress\">
            <div></div>
        </div>
        <div id=\"left\">
            ";
        // line 41
        $this->loadTemplate("MembersManagementBundle:HomePageInitial:HomePageLeftInitial.html.twig", "MembersManagementBundle:Index:index.html.twig", 41)->display($context);
        // line 42
        echo "        </div>
    </div>
    <div id=\"center_container\">
        <div id=\"center_progress\">
            <div></div>
        </div>
        <div id=\"center\">
            ";
        // line 49
        $this->loadTemplate("MembersManagementBundle:HomePageInitial:HomePageCenterInitial.html.twig", "MembersManagementBundle:Index:index.html.twig", 49)->display($context);
        // line 50
        echo "        </div>
    </div>
    <div id=\"right_container\">
        <div id=\"right_progress\">
            <div></div>
        </div>
        <div id=\"right\">
            ";
        // line 57
        $this->loadTemplate("MembersManagementBundle:HomePageInitial:HomePageRightInitial.html.twig", "MembersManagementBundle:Index:index.html.twig", 57)->display($context);
        // line 58
        echo "        </div>
    </div>
    
</div>
<div id=\"left_direction\">
    <div id=\"left_direction_arrow\"></div>
</div>
<div id=\"right_direction\">
     <div id=\"right_direction_arrow\"></div>
</div>
        
        
<div id=\"security\">
    <div id=\"security_fucker\">
        <div id=\"login_trigger_container\">
            <a href=\"javascript:void(0);\" class=\"login_trigger\">
                ";
        // line 74
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("layout.login", array(), "FOSUserBundle"), "html", null, true);
        echo "
            </a>
        </div>

        <div id=\"signup_trigger_container\">
            <a href=\"javascript:void(0);\" class=\"signup_trigger\">
                ";
        // line 80
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("layout.register", array(), "FOSUserBundle"), "html", null, true);
        echo "
            </a>
        </div>
    </div>
    <div id=\"security_progress\">
        <div></div>
    </div>
    <div id=\"security_header\">
        <div id=\"login\">
        ";
        // line 89
        echo $this->env->getRuntime('Symfony\Bridge\Twig\Extension\HttpKernelRuntime')->renderFragment(Symfony\Bridge\Twig\Extension\HttpKernelExtension::controller("MembersManagementBundle:Security:login"));
        echo "
        </div>
        <div id=\"register\">
        ";
        // line 92
        echo $this->env->getRuntime('Symfony\Bridge\Twig\Extension\HttpKernelRuntime')->renderFragment(Symfony\Bridge\Twig\Extension\HttpKernelExtension::controller("MembersManagementBundle:Registration:register"));
        echo "
        </div>
    </div>
    <div id=\"security_footer\">
        <a class=\"lb-close\"></a>
    </div>
</div>


";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 103
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 104
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("js/app.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 105
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("js/homepage_js.js"), "html", null, true);
        echo "\"></script> 
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "MembersManagementBundle:Index:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  248 => 105,  243 => 104,  234 => 103,  214 => 92,  208 => 89,  196 => 80,  187 => 74,  169 => 58,  167 => 57,  158 => 50,  156 => 49,  147 => 42,  145 => 41,  134 => 33,  130 => 32,  126 => 31,  122 => 30,  116 => 26,  114 => 25,  108 => 22,  105 => 21,  96 => 20,  83 => 17,  74 => 16,  52 => 4,  43 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '::base.html.twig' %}

{% block myscript %}
    <script type=\"text/javascript\" id= \"mscript\" data-url=\"{{ path('mobile_index', { page : 0})}}\" >

        if( ('onorientationchange' in window) 
                || (window.screen.width< window.screen.height)
                || (window.screen.width< 1280)
                ) { 
            var url = document.getElementById('mscript').getAttribute('data-url');
            window.location.replace(url);
        }
    </script>
{% endblock %}

{% block stylesheets %}
   <link rel=\"stylesheet\" href=\"{{ asset('css/homepage_styles.css') }}\" />
{% endblock %}

{% block body %}
    
{% include \"MembersManagementBundle:HomePageInitial:homePageTemplates.html.twig\" %} 
    
<div id=\"header\">
      {% include \"MembersManagementBundle:HomePageInitial:HomePageHeader.html.twig\" %}
</div>

<div id=\"content\" class=\"righty\" 
     data-is-login-login=\"0\"
     data-login-login-url=\"{{ path('fos_user_security_login')}}\"
     data-all-new-posters-url=\"{{ path('all_new_posters')}}\"
     data-url-all-jawla=\"{{ path('all_jawla')}}\"
     data-url-category=\"{{ path('show_category') }}\"
     >
    
    <div id=\"left_container\">
        <div id=\"left_progress\">
            <div></div>
        </div>
        <div id=\"left\">
            {% include \"MembersManagementBundle:HomePageInitial:HomePageLeftInitial.html.twig\" %}
        </div>
    </div>
    <div id=\"center_container\">
        <div id=\"center_progress\">
            <div></div>
        </div>
        <div id=\"center\">
            {% include \"MembersManagementBundle:HomePageInitial:HomePageCenterInitial.html.twig\" %}
        </div>
    </div>
    <div id=\"right_container\">
        <div id=\"right_progress\">
            <div></div>
        </div>
        <div id=\"right\">
            {% include \"MembersManagementBundle:HomePageInitial:HomePageRightInitial.html.twig\" %}
        </div>
    </div>
    
</div>
<div id=\"left_direction\">
    <div id=\"left_direction_arrow\"></div>
</div>
<div id=\"right_direction\">
     <div id=\"right_direction_arrow\"></div>
</div>
        
        
<div id=\"security\">
    <div id=\"security_fucker\">
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
    </div>
    <div id=\"security_progress\">
        <div></div>
    </div>
    <div id=\"security_header\">
        <div id=\"login\">
        {{ render(controller('MembersManagementBundle:Security:login')) }}
        </div>
        <div id=\"register\">
        {{ render(controller('MembersManagementBundle:Registration:register')) }}
        </div>
    </div>
    <div id=\"security_footer\">
        <a class=\"lb-close\"></a>
    </div>
</div>


{% endblock %}

{% block javascripts %}
    <script src=\"{{ asset('js/app.js') }}\"></script>
    <script src=\"{{ asset('js/homepage_js.js') }}\"></script> 
{% endblock %}

", "MembersManagementBundle:Index:index.html.twig", "/vagrant/src/Members/Bundle/ManagementBundle/Resources/views/Index/index.html.twig");
    }
}
