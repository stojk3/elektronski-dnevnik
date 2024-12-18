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

/* core/themes/claro/templates/status-report-grouped.html.twig */
class __TwigTemplate_869a38a6b85777ff09143c4c73c35cdb extends Template
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
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/drupal.collapse"), "html", null, true);
        echo "

<div class=\"system-status-report\">
  <h2 class=\"system-status-general-info__header\">";
        // line 22
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Status Details"));
        echo "</h2>
  ";
        // line 23
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["grouped_requirements"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["group"]) {
            // line 24
            echo "    <details class=\"claro-details\" open>
      <summary id=\"";
            // line 25
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["group"], "type", [], "any", false, false, true, 25), 25, $this->source), "html", null, true);
            echo "\" class=\"claro-details__summary claro-details__summary--system-status-report\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["group"], "title", [], "any", false, false, true, 25), 25, $this->source), "html", null, true);
            echo "</summary>
      <div class=\"claro-details__wrapper claro-details__wrapper--system-status-report\">
        ";
            // line 27
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["group"], "items", [], "any", false, false, true, 27));
            foreach ($context['_seq'] as $context["_key"] => $context["requirement"]) {
                // line 28
                echo "          <div class=\"system-status-report__row\">
              ";
                // line 30
                $context["summary_classes"] = [0 => "system-status-report__status-title", 1 => ((twig_in_filter(twig_get_attribute($this->env, $this->source,                 // line 32
$context["group"], "type", [], "any", false, false, true, 32), [0 => "warning", 1 => "error"])) ? (("system-status-report__status-icon system-status-report__status-icon--" . $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["group"], "type", [], "any", false, false, true, 32), 32, $this->source))) : (""))];
                // line 35
                echo "              <div";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->createAttribute(["class" => ($context["summary_classes"] ?? null)]), "html", null, true);
                echo " role=\"button\">
                ";
                // line 36
                if (twig_get_attribute($this->env, $this->source, $context["requirement"], "severity_title", [], "any", false, false, true, 36)) {
                    // line 37
                    echo "                  <span class=\"visually-hidden\">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["requirement"], "severity_title", [], "any", false, false, true, 37), 37, $this->source), "html", null, true);
                    echo "</span>
                ";
                }
                // line 39
                echo "                ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["requirement"], "title", [], "any", false, false, true, 39), 39, $this->source), "html", null, true);
                echo "
              </div>
              <div class=\"system-status-report__entry__value\">
                ";
                // line 42
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["requirement"], "value", [], "any", false, false, true, 42), 42, $this->source), "html", null, true);
                echo "
                ";
                // line 43
                if (twig_get_attribute($this->env, $this->source, $context["requirement"], "description", [], "any", false, false, true, 43)) {
                    // line 44
                    echo "                  <div class=\"description\">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["requirement"], "description", [], "any", false, false, true, 44), 44, $this->source), "html", null, true);
                    echo "</div>
                ";
                }
                // line 46
                echo "              </div>
          </div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['requirement'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 49
            echo "
      </div>
    </details>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['group'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 53
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "core/themes/claro/templates/status-report-grouped.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  122 => 53,  113 => 49,  105 => 46,  99 => 44,  97 => 43,  93 => 42,  86 => 39,  80 => 37,  78 => 36,  73 => 35,  71 => 32,  70 => 30,  67 => 28,  63 => 27,  56 => 25,  53 => 24,  49 => 23,  45 => 22,  39 => 19,);
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/claro/templates/status-report-grouped.html.twig", "/var/www/web/core/themes/claro/templates/status-report-grouped.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 23, "set" => 30, "if" => 36);
        static $filters = array("escape" => 19, "t" => 22);
        static $functions = array("attach_library" => 19, "create_attribute" => 35);

        try {
            $this->sandbox->checkSecurity(
                ['for', 'set', 'if'],
                ['escape', 't'],
                ['attach_library', 'create_attribute']
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
