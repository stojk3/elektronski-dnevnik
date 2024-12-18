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

/* core/modules/system/templates/admin-block.html.twig */
class __TwigTemplate_20c3aef014a1d9558082513c359bd2d9 extends Template
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
        $context["classes"] = [0 => "panel"];
        // line 23
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 23), 23, $this->source), "html", null, true);
        echo ">
  ";
        // line 24
        if (twig_get_attribute($this->env, $this->source, ($context["block"] ?? null), "title", [], "any", false, false, true, 24)) {
            // line 25
            echo "    <h3 class=\"panel__title\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["block"] ?? null), "title", [], "any", false, false, true, 25), 25, $this->source), "html", null, true);
            echo "</h3>
  ";
        }
        // line 27
        echo "  ";
        if (twig_get_attribute($this->env, $this->source, ($context["block"] ?? null), "content", [], "any", false, false, true, 27)) {
            // line 28
            echo "    <div class=\"panel__content\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["block"] ?? null), "content", [], "any", false, false, true, 28), 28, $this->source), "html", null, true);
            echo "</div>
  ";
        } elseif (twig_get_attribute($this->env, $this->source,         // line 29
($context["block"] ?? null), "description", [], "any", false, false, true, 29)) {
            // line 30
            echo "    <div class=\"panel__description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["block"] ?? null), "description", [], "any", false, false, true, 30), 30, $this->source), "html", null, true);
            echo "</div>
  ";
        }
        // line 32
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "core/modules/system/templates/admin-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 32,  64 => 30,  62 => 29,  57 => 28,  54 => 27,  48 => 25,  46 => 24,  41 => 23,  39 => 19,);
    }

    public function getSourceContext()
    {
        return new Source("", "core/modules/system/templates/admin-block.html.twig", "/var/www/web/core/modules/system/templates/admin-block.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 19, "if" => 24);
        static $filters = array("escape" => 23);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['escape'],
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
