<?php

/* MembersManagementBundle:HomePageInitial:homePageTemplates.html.twig */
class __TwigTemplate_7c9ab333f4fc8b538e836c78c7753678714bc503b9fc5d73f53cbd522d411b92 extends Twig_Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "MembersManagementBundle:HomePageInitial:homePageTemplates.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "MembersManagementBundle:HomePageInitial:homePageTemplates.html.twig"));

        // line 1
        echo "<script id=\"openChatErrorTemplate\" type=\"text/x-jsrender\">
    <div id=\"open-chat-error\" class=\"error-theme\">
        <div class=\"error-message\">
            <div class=\"error-message-text\">
                <div class=\"message-text\">";
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("errors.chat.login_to_chat"), "html", null, true);
        echo "</div>
                <div class=\"login_trigger error-button\">";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("layout.login", array(), "FOSUserBundle"), "html", null, true);
        echo "</div>
                <div class=\"signup_trigger error-button\">";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("layout.register", array(), "FOSUserBundle"), "html", null, true);
        echo "</div>
            </div>
            <div class=\"error-message-close\">X</div>
            <div class=\"clear\"></div>
        </div>
    </div>
</script>
<script id=\"followUnfollowErrorTemplate\" type=\"text/x-jsrender\">
    <div id=\"follow-unfollow-error\" class=\"error-theme\">
        <div class=\"error-message\">
            <div class=\"error-message-text\">
                <div class=\"message-text\">";
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("errors.follow.login_to_follow"), "html", null, true);
        echo "</div>
                <div class=\"login_trigger error-button\">";
        // line 19
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("layout.login", array(), "FOSUserBundle"), "html", null, true);
        echo "</div>
                <div class=\"signup_trigger error-button\">";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("layout.register", array(), "FOSUserBundle"), "html", null, true);
        echo "</div>
            </div>
            <div class=\"error-message-close\">X</div>
            <div class=\"clear\"></div>
        </div>
    </div>
</script>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "MembersManagementBundle:HomePageInitial:homePageTemplates.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  61 => 20,  57 => 19,  53 => 18,  39 => 7,  35 => 6,  31 => 5,  25 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<script id=\"openChatErrorTemplate\" type=\"text/x-jsrender\">
    <div id=\"open-chat-error\" class=\"error-theme\">
        <div class=\"error-message\">
            <div class=\"error-message-text\">
                <div class=\"message-text\">{{ 'errors.chat.login_to_chat'| trans}}</div>
                <div class=\"login_trigger error-button\">{{ 'layout.login'|trans({}, 'FOSUserBundle') }}</div>
                <div class=\"signup_trigger error-button\">{{ 'layout.register'|trans({}, 'FOSUserBundle') }}</div>
            </div>
            <div class=\"error-message-close\">X</div>
            <div class=\"clear\"></div>
        </div>
    </div>
</script>
<script id=\"followUnfollowErrorTemplate\" type=\"text/x-jsrender\">
    <div id=\"follow-unfollow-error\" class=\"error-theme\">
        <div class=\"error-message\">
            <div class=\"error-message-text\">
                <div class=\"message-text\">{{ 'errors.follow.login_to_follow'| trans}}</div>
                <div class=\"login_trigger error-button\">{{ 'layout.login'|trans({}, 'FOSUserBundle') }}</div>
                <div class=\"signup_trigger error-button\">{{ 'layout.register'|trans({}, 'FOSUserBundle') }}</div>
            </div>
            <div class=\"error-message-close\">X</div>
            <div class=\"clear\"></div>
        </div>
    </div>
</script>", "MembersManagementBundle:HomePageInitial:homePageTemplates.html.twig", "/vagrant/src/Members/Bundle/ManagementBundle/Resources/views/HomePageInitial/homePageTemplates.html.twig");
    }
}
