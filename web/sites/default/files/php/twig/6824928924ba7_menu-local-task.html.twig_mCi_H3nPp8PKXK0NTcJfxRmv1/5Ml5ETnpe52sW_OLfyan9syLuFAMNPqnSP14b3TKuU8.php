<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* core/themes/claro/templates/navigation/menu-local-task.html.twig */
class __TwigTemplate_a7dc1f927e8817b4e2f3d15209bcebb2 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 19
        $context["classes"] = [0 => "tabs__tab", 1 => (((        // line 21
($context["level"] ?? null) == "primary")) ? ("js-tab") : ("")), 2 => ((        // line 22
($context["is_active"] ?? null)) ? ("is-active") : ("")), 3 => ((        // line 23
($context["is_active"] ?? null)) ? ("js-active-tab") : (""))];
        // line 26
        echo "<li";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 26), 26, $this->source), "html", null, true);
        echo ">
  ";
        // line 27
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["link"] ?? null), 27, $this->source), "html", null, true);
        echo "
  ";
        // line 28
        if ((($context["is_active"] ?? null) && (($context["level"] ?? null) == "primary"))) {
            // line 29
            echo "    <button class=\"reset-appearance tabs__trigger\" aria-label=\"";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Tabs display toggle"));
            echo "\" data-drupal-nav-tabs-trigger>
      ";
            // line 30
            $this->loadTemplate("@claro/../images/src/hamburger-menu.svg", "core/themes/claro/templates/navigation/menu-local-task.html.twig", 30)->display($context);
            // line 31
            echo "    </button>
  ";
        }
        // line 33
        echo "</li>
";
    }

    public function getTemplateName()
    {
        return "core/themes/claro/templates/navigation/menu-local-task.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  66 => 33,  62 => 31,  60 => 30,  55 => 29,  53 => 28,  49 => 27,  44 => 26,  42 => 23,  41 => 22,  40 => 21,  39 => 19,);
    }

    public function getSourceContext()
    {
        return new Source("{#
/**
 * @file
 * Theme override for a local task link.
 *
 * Available variables:
 * - attributes: HTML attributes for the wrapper element.
 * - is_active: Whether the task item is an active tab.
 * - link: A rendered link element.
 * - level: The menu level where the tab is rendered.
 *
 * Note: This template renders the content for each task item in
 * menu-local-tasks.html.twig.
 *
 * @see template_preprocess_menu_local_task()
 */
#}
{%
  set classes = [
    'tabs__tab',
    level == 'primary' ? 'js-tab',
    is_active ? 'is-active',
    is_active ? 'js-active-tab',
  ]
%}
<li{{ attributes.addClass(classes) }}>
  {{ link }}
  {% if is_active and level == 'primary' %}
    <button class=\"reset-appearance tabs__trigger\" aria-label=\"{{ 'Tabs display toggle'|t }}\" data-drupal-nav-tabs-trigger>
      {% include \"@claro/../images/src/hamburger-menu.svg\" %}
    </button>
  {% endif %}
</li>
", "core/themes/claro/templates/navigation/menu-local-task.html.twig", "/var/www/web/core/themes/claro/templates/navigation/menu-local-task.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 19, "if" => 28, "include" => 30);
        static $filters = array("escape" => 26, "t" => 29);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'include'],
                ['escape', 't'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
