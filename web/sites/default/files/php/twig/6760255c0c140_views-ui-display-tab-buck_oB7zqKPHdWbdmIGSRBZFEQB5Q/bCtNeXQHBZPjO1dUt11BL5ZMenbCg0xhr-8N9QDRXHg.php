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

/* core/themes/claro/templates/views/views-ui-display-tab-bucket.html.twig */
class __TwigTemplate_82d6c2fb8b5870abfb8efa8d58a05c20 extends Template
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
        // line 21
        $context["classes"] = [0 => "views-ui-display-tab-bucket", 1 => ((        // line 23
($context["name"] ?? null)) ? (\Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(($context["name"] ?? null), 23, $this->source))) : ("")), 2 => ((        // line 24
($context["overridden"] ?? null)) ? ("overridden") : (""))];
        // line 27
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 27), 27, $this->source), "html", null, true);
        echo ">
  ";
        // line 28
        if ((($context["title"] ?? null) || ($context["actions"] ?? null))) {
            // line 29
            echo "    <div class=\"views-ui-display-tab-bucket__header";
            if (($context["actions"] ?? null)) {
                echo " views-ui-display-tab-bucket__header--actions";
            }
            echo "\">
    ";
            // line 30
            if (($context["title"] ?? null)) {
                // line 31
                echo "<h3 class=\"views-ui-display-tab-bucket__title\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 31, $this->source), "html", null, true);
                echo "</h3>";
            }
            // line 33
            echo "    ";
            if (($context["actions"] ?? null)) {
                // line 34
                echo "<div class=\"views-ui-display-tab-bucket__actions\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["actions"] ?? null), 34, $this->source), "html", null, true);
                echo "</div>";
            }
            // line 36
            echo "    </div>
  ";
        }
        // line 38
        echo "  ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["content"] ?? null), 38, $this->source), "html", null, true);
        echo "
</div>
";
    }

    public function getTemplateName()
    {
        return "core/themes/claro/templates/views/views-ui-display-tab-bucket.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  76 => 38,  72 => 36,  67 => 34,  64 => 33,  59 => 31,  57 => 30,  50 => 29,  48 => 28,  43 => 27,  41 => 24,  40 => 23,  39 => 21,);
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/claro/templates/views/views-ui-display-tab-bucket.html.twig", "/var/www/web/core/themes/claro/templates/views/views-ui-display-tab-bucket.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 21, "if" => 28);
        static $filters = array("clean_class" => 23, "escape" => 27);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['clean_class', 'escape'],
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
