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

/* themes/contrib/bootstrap3/templates/menu/menu--main.html.twig */
class __TwigTemplate_1e67b7080124481720ea1da7c4d4a08f extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doGetParent(array $context)
    {
        // line 20
        return "menu.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 22
        $context["classes"] = [0 => "menu", 1 => ("menu--" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(        // line 24
($context["menu_name"] ?? null), 24, $this->source))), 2 => "nav", 3 => "navbar-nav"];
        // line 20
        $this->parent = $this->loadTemplate("menu.html.twig", "themes/contrib/bootstrap3/templates/menu/menu--main.html.twig", 20);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "themes/contrib/bootstrap3/templates/menu/menu--main.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  46 => 20,  44 => 24,  43 => 22,  36 => 20,);
    }

    public function getSourceContext()
    {
        return new Source("{#
/**
 * @file
 * Default theme implementation to display a menu.
 *
 * Available variables:
 * - classes: A list of classes to apply to the top level <ul> element.
 * - dropdown_classes: A list of classes to apply to the dropdown <ul> element.
 * - menu_name: The machine name of the menu.
 * - items: A nested list of menu items. Each menu item contains:
 *   - attributes: HTML attributes for the menu item.
 *   - below: The menu item child items.
 *   - title: The menu link title.
 *   - url: The menu link url, instance of \\Drupal\\Core\\Url
 *   - localized_options: Menu link localized options.
 *
 * @ingroup templates
 */
#}
{% extends \"menu.html.twig\" %}
{%
  set classes = [
    'menu',
    'menu--' ~ menu_name|clean_class,
    'nav',
    'navbar-nav',
  ]
%}
", "themes/contrib/bootstrap3/templates/menu/menu--main.html.twig", "/var/www/web/themes/contrib/bootstrap3/templates/menu/menu--main.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 22);
        static $filters = array("clean_class" => 24);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set'],
                ['clean_class'],
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
