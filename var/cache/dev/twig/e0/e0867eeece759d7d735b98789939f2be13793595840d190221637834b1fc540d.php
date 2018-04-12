<?php

/* FOSUserBundle:Registration:register_content.html.twig */
class __TwigTemplate_1fc37f37be29300044c186e4c6aaa0c9b7ca00f047d0627665d8183bd6f0fb2b extends Twig_Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Registration:register_content.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Registration:register_content.html.twig"));

        // line 2
        echo "
<div class=\"wrapper\">
\t<div class=\"container\">
            <form id=\"register_form\" action=\"";
        // line 5
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_user_registration_register");
        echo "\"
                  method=\"POST\" 
                  class=\"fos_user_registration_register\" 
                  novalidate
                  id=\"register_form\">
                    <div id=\"register-form-email-error\" class=\"error-theme\">";
        // line 10
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "email", array()), 'errors');
        echo "</div>
                    <div id=\"register-form-email-widget\">
                        ";
        // line 12
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "email", array()), 'widget', array("attr" => array("placeholder" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("registration.enter_email", array(), "FOSUserBundle"))));
        echo "
                    </div>
                    
                    <div id=\"register-form-username-error\" class=\"error-theme\">";
        // line 15
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "username", array()), 'errors');
        echo "</div>
                    <div id=\"register-form-username-widget\">
                        ";
        // line 17
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "username", array()), 'widget', array("attr" => array("placeholder" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("registration.enter_username", array(), "FOSUserBundle"))));
        echo "
                    </div>
                    
                    <div id=\"register-form-firstpass-error\" class=\"error-theme\">";
        // line 20
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "plainPassword", array()), "first", array()), 'errors');
        echo "</div>
                    <div id=\"register-form-firstpass-widget\">
                        ";
        // line 22
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "plainPassword", array()), "first", array()), 'widget', array("attr" => array("placeholder" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("registration.enter_password", array(), "FOSUserBundle"))));
        echo "
                    </div>
                    
                    <div id=\"register-form-secondpass-error\" class=\"error-theme\"> ";
        // line 25
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "plainPassword", array()), "second", array()), 'errors');
        echo "</div>
                    <div id=\"register-form-secondpass-widget\">
                        ";
        // line 27
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "plainPassword", array()), "second", array()), 'widget', array("attr" => array("placeholder" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("registration.re_enter_password", array(), "FOSUserBundle"))));
        echo "
                    </div>
                    ";
        // line 29
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["form"] ?? $this->getContext($context, "form")), 'rest');
        echo "
                    
                    <div>
                        <button id=\"register_button\" type=\"submit\">";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("registration.submit", array(), "FOSUserBundle"), "html", null, true);
        echo "</button>
                    </div>
            </form>
            
        </div>
</div>

";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Registration:register_content.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 32,  81 => 29,  76 => 27,  71 => 25,  65 => 22,  60 => 20,  54 => 17,  49 => 15,  43 => 12,  38 => 10,  30 => 5,  25 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% trans_default_domain 'FOSUserBundle' %}

<div class=\"wrapper\">
\t<div class=\"container\">
            <form id=\"register_form\" action=\"{{ path('fos_user_registration_register') }}\"
                  method=\"POST\" 
                  class=\"fos_user_registration_register\" 
                  novalidate
                  id=\"register_form\">
                    <div id=\"register-form-email-error\" class=\"error-theme\">{{ form_errors(form.email) }}</div>
                    <div id=\"register-form-email-widget\">
                        {{ form_widget(form.email, { 'attr': { 'placeholder' : 'registration.enter_email'|trans }}) }}
                    </div>
                    
                    <div id=\"register-form-username-error\" class=\"error-theme\">{{ form_errors(form.username) }}</div>
                    <div id=\"register-form-username-widget\">
                        {{ form_widget(form.username, { 'attr': { 'placeholder' : 'registration.enter_username'|trans }}) }}
                    </div>
                    
                    <div id=\"register-form-firstpass-error\" class=\"error-theme\">{{ form_errors(form.plainPassword.first) }}</div>
                    <div id=\"register-form-firstpass-widget\">
                        {{ form_widget(form.plainPassword.first, { 'attr': { 'placeholder' : 'registration.enter_password'|trans }}) }}
                    </div>
                    
                    <div id=\"register-form-secondpass-error\" class=\"error-theme\"> {{ form_errors(form.plainPassword.second) }}</div>
                    <div id=\"register-form-secondpass-widget\">
                        {{ form_widget(form.plainPassword.second, { 'attr': { 'placeholder' : 'registration.re_enter_password'|trans }}) }}
                    </div>
                    {{ form_rest(form) }}
                    
                    <div>
                        <button id=\"register_button\" type=\"submit\">{{ 'registration.submit'|trans }}</button>
                    </div>
            </form>
            
        </div>
</div>

", "FOSUserBundle:Registration:register_content.html.twig", "/vagrant/src/Members/Bundle/ManagementBundle/Resources/views/Registration/register_content.html.twig");
    }
}
