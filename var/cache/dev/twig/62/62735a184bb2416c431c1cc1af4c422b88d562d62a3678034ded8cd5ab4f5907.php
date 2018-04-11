<?php

/* FOSUserBundle:Security:login.html.twig */
class __TwigTemplate_8110dd2e0173a4c6462307a79cae04fecf6296c9a0e2821887167f86b2e57be6 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Security:login.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Security:login.html.twig"));

        // line 2
        echo "
";
        // line 4
        echo "
";
        // line 5
        $this->displayBlock('fos_user_content', $context, $blocks);
        // line 75
        echo "
 
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 5
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 6
        if (($context["error"] ?? $this->getContext($context, "error"))) {
            // line 7
            echo "    <div id=\"security-error\" class=\"error-theme\">
        <div class=\"error-message\">
            <div class=\"error-message-text\">
                <div class=\"message-text\">";
            // line 10
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($this->getAttribute(($context["error"] ?? $this->getContext($context, "error")), "messageKey", array()), $this->getAttribute(($context["error"] ?? $this->getContext($context, "error")), "messageData", array()), "security"), "html", null, true);
            echo "</div>
            </div>
            <div class=\"error-message-close\">X</div>
            <div class=\"clear\"></div>
        </div>
    </div>
";
        }
        // line 17
        echo "
<div class=\"wrapper\">
\t<div class=\"container\">
\t\t";
        // line 21
        echo "                <form id=\"login_form\"
                        action=\"";
        // line 22
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_user_security_check");
        echo "\" 
                        method=\"post\"
                        >
                    <input type=\"hidden\" name=\"_csrf_token\" value=\"";
        // line 25
        echo twig_escape_filter($this->env, ($context["csrf_token"] ?? $this->getContext($context, "csrf_token")), "html", null, true);
        echo "\" />

                    
                    <input type=\"text\" 
                           id=\"username\" 
                           name=\"_username\" 
                           value=\"";
        // line 31
        echo twig_escape_filter($this->env, ($context["last_username"] ?? $this->getContext($context, "last_username")), "html", null, true);
        echo "\"
                           required=\"required\"
                           placeholder=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("security.login.username", array(), "FOSUserBundle"), "html", null, true);
        echo "\"
                           />

                    
                    <input type=\"password\" 
                           id=\"password\" 
                           name=\"_password\" 
                           required=\"required\"
                           placeholder=\"";
        // line 41
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("security.login.password", array(), "FOSUserBundle"), "html", null, true);
        echo "\"
                           />

                    <button type=\"submit\" 
                           id=\"_submit\" 
                           name=\"_submit\">
                           ";
        // line 47
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("security.login.submit", array(), "FOSUserBundle"), "html", null, true);
        echo "
                    </button>
                    ";
        // line 63
        echo "                </form>
                <div>            
                    <a id=\"forgot_trigger\" href=\"";
        // line 65
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_user_resetting_request");
        echo "\">
                        ";
        // line 66
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("security.i_forgot_password", array(), "FOSUserBundle"), "html", null, true);
        echo "
                    </a>  
                </div>
    </div>
</div>



";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Security:login.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  133 => 66,  129 => 65,  125 => 63,  120 => 47,  111 => 41,  100 => 33,  95 => 31,  86 => 25,  80 => 22,  77 => 21,  72 => 17,  62 => 10,  57 => 7,  55 => 6,  46 => 5,  34 => 75,  32 => 5,  29 => 4,  26 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{#{% extends \"::layout.html.twig\" %}#}

{% trans_default_domain 'FOSUserBundle' %}

{% block fos_user_content %}
{% if error %}
    <div id=\"security-error\" class=\"error-theme\">
        <div class=\"error-message\">
            <div class=\"error-message-text\">
                <div class=\"message-text\">{{ error.messageKey|trans(error.messageData, 'security') }}</div>
            </div>
            <div class=\"error-message-close\">X</div>
            <div class=\"clear\"></div>
        </div>
    </div>
{% endif %}

<div class=\"wrapper\">
\t<div class=\"container\">
\t\t{# <h1>Welcome</h1>#}
                <form id=\"login_form\"
                        action=\"{{ path(\"fos_user_security_check\") }}\" 
                        method=\"post\"
                        >
                    <input type=\"hidden\" name=\"_csrf_token\" value=\"{{ csrf_token }}\" />

                    
                    <input type=\"text\" 
                           id=\"username\" 
                           name=\"_username\" 
                           value=\"{{ last_username }}\"
                           required=\"required\"
                           placeholder=\"{{ 'security.login.username'|trans }}\"
                           />

                    
                    <input type=\"password\" 
                           id=\"password\" 
                           name=\"_password\" 
                           required=\"required\"
                           placeholder=\"{{ 'security.login.password'|trans }}\"
                           />

                    <button type=\"submit\" 
                           id=\"_submit\" 
                           name=\"_submit\">
                           {{ 'security.login.submit'|trans }}
                    </button>
                    {#             
                    <div class=\"p-container\">
                        <div>
                            <input type=\"checkbox\" 
                                   checked=\"\"
                                   id=\"remember_me\" 
                                   name=\"_remember_me\" 
                                   value=\"off\"
                                   />
                            <label class=\"checkbox\">{{ 'security.login.remember_me'|trans }}</label>
                            <div class=\"clear\"></div>
                        </div>
                    </div>
                    #}
                </form>
                <div>            
                    <a id=\"forgot_trigger\" href=\"{{path('fos_user_resetting_request')}}\">
                        {{ 'security.i_forgot_password'|trans({},'FOSUserBundle') }}
                    </a>  
                </div>
    </div>
</div>



{% endblock fos_user_content %}

 
", "FOSUserBundle:Security:login.html.twig", "/home/adib/devenv/src/Members/Bundle/ManagementBundle/Resources/views/Security/login.html.twig");
    }
}
