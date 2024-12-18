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

/* core/themes/claro/templates/views/views-ui-display-tab-setting.html.twig */
class __TwigTemplate_b204eb7968403a0d36a01b24619ef239 extends Template
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
        // line 22
        $context["classes"] = [0 => "views-display-setting", 1 => "views-ui-display-tab-setting", 2 => ((        // line 25
($context["defaulted"] ?? null)) ? ("defaulted") : ("")), 3 => ((        // line 26
($context["overridden"] ?? null)) ? ("overridden") : (""))];
        // line 29
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 29), 29, $this->source), "html", null, true);
        echo ">
  ";
        // line 30
        if (($context["description"] ?? null)) {
            // line 31
            echo "<span class=\"label\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["description"] ?? null), 31, $this->source), "html", null, true);
            echo "</span>";
        }
        // line 33
        echo "  ";
        if (($context["settings_links"] ?? null)) {
            // line 34
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->safeJoin($this->env, $this->sandbox->ensureToStringAllowed(($context["settings_links"] ?? null), 34, $this->source), "<span class=\"label label--separator\">&nbsp;|&nbsp;</span>"));
            echo "
  ";
        }
        // line 36
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "core/themes/claro/templates/views/views-ui-display-tab-setting.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  64 => 36,  58 => 34,  55 => 33,  50 => 31,  48 => 30,  43 => 29,  41 => 26,  40 => 25,  39 => 22,);
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/claro/templates/views/views-ui-display-tab-setting.html.twig", "/var/www/web/core/themes/claro/templates/views/views-ui-display-tab-setting.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 22, "if" => 30);
        static $filters = array("escape" => 29, "safe_join" => 34);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['escape', 'safe_join'],
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
