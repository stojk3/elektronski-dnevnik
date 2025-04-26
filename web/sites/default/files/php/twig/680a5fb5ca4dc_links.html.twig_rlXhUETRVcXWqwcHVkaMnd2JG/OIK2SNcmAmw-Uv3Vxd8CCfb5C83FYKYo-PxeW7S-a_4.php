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

/* themes/contrib/bootstrap3/templates/system/links.html.twig */
class __TwigTemplate_1b59173e588fe0a85cc6397b9e06758b extends Template
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
        // line 37
        if (($context["links"] ?? null)) {
            // line 38
            if (($context["heading"] ?? null)) {
                // line 39
                if (twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "level", [], "any", false, false, true, 39)) {
                    // line 40
                    echo "<";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "level", [], "any", false, false, true, 40), 40, $this->source), "html", null, true);
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "attributes", [], "any", false, false, true, 40), 40, $this->source), "html", null, true);
                    echo ">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "text", [], "any", false, false, true, 40), 40, $this->source), "html", null, true);
                    echo "</";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "level", [], "any", false, false, true, 40), 40, $this->source), "html", null, true);
                    echo ">";
                } else {
                    // line 42
                    echo "<h2";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "attributes", [], "any", false, false, true, 42), 42, $this->source), "html", null, true);
                    echo ">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "text", [], "any", false, false, true, 42), 42, $this->source), "html", null, true);
                    echo "</h2>";
                }
            }
            // line 45
            if (twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "hasClass", [0 => "inline"], "method", false, false, true, 45)) {
                // line 46
                echo "<ul";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => "list-inline"], "method", false, false, true, 46), 46, $this->source), "html", null, true);
                echo ">";
            } else {
                // line 48
                echo "<ul";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["attributes"] ?? null), 48, $this->source), "html", null, true);
                echo ">";
            }
            // line 50
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["links"] ?? null));
            foreach ($context['_seq'] as $context["key"] => $context["item"]) {
                // line 51
                echo "<li";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 51), "addClass", [0 => \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed($context["key"], 51, $this->source))], "method", false, false, true, 51), 51, $this->source), "html", null, true);
                echo ">";
                // line 52
                if (twig_get_attribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, true, 52)) {
                    // line 53
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, true, 53), 53, $this->source), "html", null, true);
                } elseif (twig_get_attribute($this->env, $this->source,                 // line 54
$context["item"], "text_attributes", [], "any", false, false, true, 54)) {
                    // line 55
                    echo "<span";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "text_attributes", [], "any", false, false, true, 55), 55, $this->source), "html", null, true);
                    echo ">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "text", [], "any", false, false, true, 55), 55, $this->source), "html", null, true);
                    echo "</span>";
                } else {
                    // line 57
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "text", [], "any", false, false, true, 57), 57, $this->source), "html", null, true);
                }
                // line 59
                echo "</li>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 61
            echo "</ul>";
        }
    }

    public function getTemplateName()
    {
        return "themes/contrib/bootstrap3/templates/system/links.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 61,  99 => 59,  96 => 57,  89 => 55,  87 => 54,  85 => 53,  83 => 52,  79 => 51,  75 => 50,  70 => 48,  65 => 46,  63 => 45,  55 => 42,  45 => 40,  43 => 39,  41 => 38,  39 => 37,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/contrib/bootstrap3/templates/system/links.html.twig", "/var/www/web/themes/contrib/bootstrap3/templates/system/links.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 37, "for" => 50);
        static $filters = array("escape" => 40, "clean_class" => 51);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
                ['escape', 'clean_class'],
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
