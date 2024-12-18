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

/* core/themes/claro/templates/status-report-general-info.html.twig */
class __TwigTemplate_00f355effad4d95cb474aeebe2829708 extends Template
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
        // line 32
        echo "<div class=\"system-status-general-info\">
  <h2 class=\"system-status-general-info__header\">";
        // line 33
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("General System Information"));
        echo "</h2>
  <div class=\"system-status-general-info__items\">
    <div class=\"system-status-general-info__item card\">
      <span class=\"system-status-general-info__item-icon system-status-general-info__item-icon--drupal\"></span>
      <div class=\"system-status-general-info__item-details\">
        <h3 class=\"system-status-general-info__item-title\">";
        // line 38
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Drupal Version"));
        echo "</h3>
        ";
        // line 39
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["drupal"] ?? null), "value", [], "any", false, false, true, 39), 39, $this->source), "html", null, true);
        echo "
        ";
        // line 40
        if (twig_get_attribute($this->env, $this->source, ($context["drupal"] ?? null), "description", [], "any", false, false, true, 40)) {
            // line 41
            echo "          <div class=\"description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["drupal"] ?? null), "description", [], "any", false, false, true, 41), 41, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 43
        echo "      </div>
    </div>

    <div class=\"system-status-general-info__item card\">
      <span class=\"system-status-general-info__item-icon system-status-general-info__item-icon--server\"></span>
      <div class=\"system-status-general-info__item-details\">
        <h3 class=\"system-status-general-info__item-title\">";
        // line 49
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Web Server"));
        echo "</h3>
        ";
        // line 50
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["webserver"] ?? null), "value", [], "any", false, false, true, 50), 50, $this->source), "html", null, true);
        echo "
        ";
        // line 51
        if (twig_get_attribute($this->env, $this->source, ($context["webserver"] ?? null), "description", [], "any", false, false, true, 51)) {
            // line 52
            echo "          <div class=\"description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["webserver"] ?? null), "description", [], "any", false, false, true, 52), 52, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 54
        echo "      </div>
    </div>
    <div class=\"system-status-general-info__item card\">
      <span class=\"system-status-general-info__item-icon system-status-general-info__item-icon--clock\"></span>
      <div class=\"system-status-general-info__item-details\">
        <h3 class=\"system-status-general-info__item-title\">";
        // line 59
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Last Cron Run"));
        echo "</h3>
        ";
        // line 60
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["cron"] ?? null), "value", [], "any", false, false, true, 60), 60, $this->source), "html", null, true);
        echo "
        ";
        // line 61
        if (twig_get_attribute($this->env, $this->source, ($context["cron"] ?? null), "run_cron", [], "any", false, false, true, 61)) {
            // line 62
            echo "          <div class=\"system-status-general-info__run-cron\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["cron"] ?? null), "run_cron", [], "any", false, false, true, 62), 62, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 64
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["cron"] ?? null), "description", [], "any", false, false, true, 64)) {
            // line 65
            echo "          <div class=\"system-status-general-info__description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["cron"] ?? null), "description", [], "any", false, false, true, 65), 65, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 67
        echo "      </div>
    </div>
    <div class=\"system-status-general-info__item card\">
      <span class=\"system-status-general-info__item-icon system-status-general-info__item-icon--php\"></span>
      <div class=\"system-status-general-info__item-details\">
        <h3 class=\"system-status-general-info__item-title\">";
        // line 72
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("PHP"));
        echo "</h3>
        <h4 class=\"system-status-general-info__sub-item-title\">";
        // line 73
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Version"));
        echo "</h4>";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["php"] ?? null), "value", [], "any", false, false, true, 73), 73, $this->source), "html", null, true);
        echo "
        ";
        // line 74
        if (twig_get_attribute($this->env, $this->source, ($context["php"] ?? null), "description", [], "any", false, false, true, 74)) {
            // line 75
            echo "          <div class=\"description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["php"] ?? null), "description", [], "any", false, false, true, 75), 75, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 77
        echo "
        <h4 class=\"system-status-general-info__sub-item-title\">";
        // line 78
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Memory limit"));
        echo "</h4>";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["php_memory_limit"] ?? null), "value", [], "any", false, false, true, 78), 78, $this->source), "html", null, true);
        echo "
        ";
        // line 79
        if (twig_get_attribute($this->env, $this->source, ($context["php_memory_limit"] ?? null), "description", [], "any", false, false, true, 79)) {
            // line 80
            echo "          <div class=\"description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["php_memory_limit"] ?? null), "description", [], "any", false, false, true, 80), 80, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 82
        echo "      </div>
    </div>
    <div class=\"system-status-general-info__item card\">
      <span class=\"system-status-general-info__item-icon system-status-general-info__item-icon--database\"></span>
      <div class=\"system-status-general-info__item-details\">
        <h3 class=\"system-status-general-info__item-title\">";
        // line 87
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Database"));
        echo "</h3>
        <h4 class=\"system-status-general-info__sub-item-title\">";
        // line 88
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Version"));
        echo "</h4>";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["database_system_version"] ?? null), "value", [], "any", false, false, true, 88), 88, $this->source), "html", null, true);
        echo "
        ";
        // line 89
        if (twig_get_attribute($this->env, $this->source, ($context["database_system_version"] ?? null), "description", [], "any", false, false, true, 89)) {
            // line 90
            echo "          <div class=\"description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["database_system_version"] ?? null), "description", [], "any", false, false, true, 90), 90, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 92
        echo "
        <h4 class=\"system-status-general-info__sub-item-title\">";
        // line 93
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("System"));
        echo "</h4>";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["database_system"] ?? null), "value", [], "any", false, false, true, 93), 93, $this->source), "html", null, true);
        echo "
        ";
        // line 94
        if (twig_get_attribute($this->env, $this->source, ($context["database_system"] ?? null), "description", [], "any", false, false, true, 94)) {
            // line 95
            echo "          <div class=\"description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["database_system"] ?? null), "description", [], "any", false, false, true, 95), 95, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 97
        echo "      </div>
    </div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "core/themes/claro/templates/status-report-general-info.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  206 => 97,  200 => 95,  198 => 94,  192 => 93,  189 => 92,  183 => 90,  181 => 89,  175 => 88,  171 => 87,  164 => 82,  158 => 80,  156 => 79,  150 => 78,  147 => 77,  141 => 75,  139 => 74,  133 => 73,  129 => 72,  122 => 67,  116 => 65,  113 => 64,  107 => 62,  105 => 61,  101 => 60,  97 => 59,  90 => 54,  84 => 52,  82 => 51,  78 => 50,  74 => 49,  66 => 43,  60 => 41,  58 => 40,  54 => 39,  50 => 38,  42 => 33,  39 => 32,);
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/claro/templates/status-report-general-info.html.twig", "/var/www/web/core/themes/claro/templates/status-report-general-info.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 40);
        static $filters = array("t" => 33, "escape" => 39);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['t', 'escape'],
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
