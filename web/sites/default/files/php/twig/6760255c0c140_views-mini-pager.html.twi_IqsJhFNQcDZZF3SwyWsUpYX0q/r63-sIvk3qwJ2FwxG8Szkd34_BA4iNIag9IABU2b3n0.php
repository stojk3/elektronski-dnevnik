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

/* core/themes/claro/templates/views/views-mini-pager.html.twig */
class __TwigTemplate_4221ff4b77ef6f1ee44542f982701e59 extends Template
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
        // line 14
        $context["pager_action_classes"] = [0 => "pager__link", 1 => "pager__link--mini", 2 => "pager__link--action-link"];
        // line 20
        if ((twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, false, true, 20) || twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, false, true, 20))) {
            // line 21
            echo "  <nav";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => "pager"], "method", false, false, true, 21), "setAttribute", [0 => "role", 1 => "navigation"], "method", false, false, true, 21), "setAttribute", [0 => "aria-labelledby", 1 => ($context["heading_id"] ?? null)], "method", false, false, true, 21), 21, $this->source), "html", null, true);
            echo ">
    <h4";
            // line 22
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["title_attributes"] ?? null), "addClass", [0 => "visually-hidden"], "method", false, false, true, 22), "setAttribute", [0 => "id", 1 => ($context["heading_id"] ?? null)], "method", false, false, true, 22), 22, $this->source), "html", null, true);
            echo ">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Pagination"));
            echo "</h4>
    <ul";
            // line 23
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["content_attributes"] ?? null), "addClass", [0 => "pager__items", 1 => "js-pager__items"], "method", false, false, true, 23), 23, $this->source), "html", null, true);
            echo ">
      ";
            // line 24
            if (twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, false, true, 24)) {
                // line 25
                echo "        ";
                ob_start(function () { return ''; });
                // line 26
                echo "          <li class=\"pager__item pager__item--mini pager__item--action pager__item--previous\">
            <a";
                // line 27
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, false, true, 27), "attributes", [], "any", false, false, true, 27), "addClass", [0 => ($context["pager_action_classes"] ?? null)], "method", false, false, true, 27), "setAttribute", [0 => "title", 1 => t("Go to previous page")], "method", false, false, true, 27), "setAttribute", [0 => "href", 1 => twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "previous", [], "any", false, false, true, 27), "href", [], "any", false, false, true, 27)], "method", false, false, true, 27), 27, $this->source), "html", null, true);
                echo ">
              <span class=\"visually-hidden\">";
                // line 28
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Previous page"));
                echo "</span>
            </a>
          </li>
        ";
                $___internal_parse_0_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
                // line 25
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_spaceless($___internal_parse_0_));
                // line 32
                echo "      ";
            }
            // line 33
            echo "
      ";
            // line 34
            if (twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "current", [], "any", false, false, true, 34)) {
                // line 35
                echo "        <li class=\"pager__item pager__item--mini pager__item--current\">
          <span class=\"visually-hidden\">
            ";
                // line 37
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Current page"));
                echo "
          </span>
          ";
                // line 39
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "current", [], "any", false, false, true, 39), 39, $this->source), "html", null, true);
                echo "
        </li>
      ";
            }
            // line 42
            echo "
      ";
            // line 43
            if (twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, false, true, 43)) {
                // line 44
                echo "        ";
                ob_start(function () { return ''; });
                // line 45
                echo "          <li class=\"pager__item pager__item--mini pager__item--action pager__item--next\">
            <a";
                // line 46
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, false, true, 46), "attributes", [], "any", false, false, true, 46), "addClass", [0 => ($context["pager_action_classes"] ?? null)], "method", false, false, true, 46), "setAttribute", [0 => "title", 1 => t("Go to next page")], "method", false, false, true, 46), "setAttribute", [0 => "href", 1 => twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["items"] ?? null), "next", [], "any", false, false, true, 46), "href", [], "any", false, false, true, 46)], "method", false, false, true, 46), 46, $this->source), "html", null, true);
                echo ">
              <span class=\"visually-hidden\">";
                // line 47
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Next page"));
                echo "</span>
            </a>
          </li>
        ";
                $___internal_parse_1_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
                // line 44
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_spaceless($___internal_parse_1_));
                // line 51
                echo "      ";
            }
            // line 52
            echo "    </ul>
  </nav>
";
        }
    }

    public function getTemplateName()
    {
        return "core/themes/claro/templates/views/views-mini-pager.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 52,  126 => 51,  124 => 44,  117 => 47,  113 => 46,  110 => 45,  107 => 44,  105 => 43,  102 => 42,  96 => 39,  91 => 37,  87 => 35,  85 => 34,  82 => 33,  79 => 32,  77 => 25,  70 => 28,  66 => 27,  63 => 26,  60 => 25,  58 => 24,  54 => 23,  48 => 22,  43 => 21,  41 => 20,  39 => 14,);
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/claro/templates/views/views-mini-pager.html.twig", "/var/www/web/core/themes/claro/templates/views/views-mini-pager.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 14, "if" => 20, "apply" => 25);
        static $filters = array("escape" => 21, "t" => 22, "spaceless" => 25);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'apply'],
                ['escape', 't', 'spaceless'],
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
