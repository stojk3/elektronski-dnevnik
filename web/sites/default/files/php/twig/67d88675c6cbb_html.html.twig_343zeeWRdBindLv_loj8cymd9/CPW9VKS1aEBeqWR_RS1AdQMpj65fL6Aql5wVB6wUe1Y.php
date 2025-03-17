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

/* themes/contrib/bootstrap3/templates/system/html.html.twig */
class __TwigTemplate_504f20c21e422476ace5484cb22b745d extends Template
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
        // line 48
        $context["body_classes"] = [0 => ((        // line 49
($context["logged_in"] ?? null)) ? ("user-logged-in") : ("")), 1 => (( !        // line 50
($context["root_path"] ?? null)) ? ("path-frontpage") : (("path-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(($context["root_path"] ?? null), 50, $this->source))))), 2 => ((        // line 51
($context["node_type"] ?? null)) ? (("page-node-type-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(($context["node_type"] ?? null), 51, $this->source)))) : ("")), 3 => ((        // line 52
($context["db_offline"] ?? null)) ? ("db-offline") : ("")), 4 => ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,         // line 53
($context["theme"] ?? null), "settings", [], "any", false, false, true, 53), "navbar_position", [], "any", false, false, true, 53)) ? (("navbar-is-" . $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["theme"] ?? null), "settings", [], "any", false, false, true, 53), "navbar_position", [], "any", false, false, true, 53), 53, $this->source))) : ("")), 5 => ((twig_get_attribute($this->env, $this->source,         // line 54
($context["theme"] ?? null), "has_glyphicons", [], "any", false, false, true, 54)) ? ("has-glyphicons") : (""))];
        // line 57
        echo "<!DOCTYPE html>
<html ";
        // line 58
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["html_attributes"] ?? null), 58, $this->source), "html", null, true);
        echo ">
  <head>
    <head-placeholder token=\"";
        // line 60
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(($context["placeholder_token"] ?? null), 60, $this->source));
        echo "\">
    <title>";
        // line 61
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->safeJoin($this->env, $this->sandbox->ensureToStringAllowed(($context["head_title"] ?? null), 61, $this->source), " | "));
        echo "</title>
    <css-placeholder token=\"";
        // line 62
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(($context["placeholder_token"] ?? null), 62, $this->source));
        echo "\">
    <js-placeholder token=\"";
        // line 63
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(($context["placeholder_token"] ?? null), 63, $this->source));
        echo "\">
  </head>
  <body";
        // line 65
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["body_classes"] ?? null)], "method", false, false, true, 65), 65, $this->source), "html", null, true);
        echo ">
    <a href=\"#main-content\" class=\"visually-hidden focusable skip-link\">
      ";
        // line 67
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Skip to main content"));
        echo "
    </a>
    ";
        // line 69
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["page_top"] ?? null), 69, $this->source), "html", null, true);
        echo "
    ";
        // line 70
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["page"] ?? null), 70, $this->source), "html", null, true);
        echo "
    ";
        // line 71
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["page_bottom"] ?? null), 71, $this->source), "html", null, true);
        echo "
    <js-bottom-placeholder token=\"";
        // line 72
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(($context["placeholder_token"] ?? null), 72, $this->source));
        echo "\">
  </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "themes/contrib/bootstrap3/templates/system/html.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  94 => 72,  90 => 71,  86 => 70,  82 => 69,  77 => 67,  72 => 65,  67 => 63,  63 => 62,  59 => 61,  55 => 60,  50 => 58,  47 => 57,  45 => 54,  44 => 53,  43 => 52,  42 => 51,  41 => 50,  40 => 49,  39 => 48,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/contrib/bootstrap3/templates/system/html.html.twig", "/var/www/web/themes/contrib/bootstrap3/templates/system/html.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 48);
        static $filters = array("clean_class" => 50, "escape" => 58, "raw" => 60, "safe_join" => 61, "t" => 67);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set'],
                ['clean_class', 'escape', 'raw', 'safe_join', 't'],
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
