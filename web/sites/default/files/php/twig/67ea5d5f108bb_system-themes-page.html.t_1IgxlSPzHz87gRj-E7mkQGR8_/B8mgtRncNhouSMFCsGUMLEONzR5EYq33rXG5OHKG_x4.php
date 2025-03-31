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

/* core/themes/claro/templates/system-themes-page.html.twig */
class __TwigTemplate_b239d2c33886bb4a391f71cbc4155aa9 extends Template
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
        // line 36
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["attributes"] ?? null), 36, $this->source), "html", null, true);
        echo ">
  ";
        // line 37
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["theme_groups"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["theme_group"]) {
            // line 38
            echo "    ";
            // line 39
            $context["theme_group_classes"] = [0 => "system-themes-list", 1 => ("system-themes-list--" . $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source,             // line 41
$context["theme_group"], "state", [], "any", false, false, true, 41), 41, $this->source)), 2 => "clearfix"];
            // line 45
            echo "
    ";
            // line 47
            $context["card_alignment"] = (((twig_get_attribute($this->env, $this->source, $context["theme_group"], "state", [], "any", false, false, true, 47) == "installed")) ? ("horizontal") : ("vertical"));
            // line 49
            echo "
    ";
            // line 50
            if ( !twig_get_attribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, true, 50)) {
                // line 51
                echo "      <hr>
    ";
            }
            // line 53
            echo "
    <div";
            // line 54
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["theme_group"], "attributes", [], "any", false, false, true, 54), "addClass", [0 => ($context["theme_group_classes"] ?? null)], "method", false, false, true, 54), 54, $this->source), "html", null, true);
            echo ">
      <h2 class=\"system-themes-list__header\">";
            // line 55
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme_group"], "title", [], "any", false, false, true, 55), 55, $this->source), "html", null, true);
            echo "</h2>
      <div class=\"card-list ";
            // line 56
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((($context["card_alignment"] ?? null) == "horizontal")) ? ("card-list--two-cols") : ("card-list--four-cols")));
            echo "\">
        ";
            // line 57
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["theme_group"], "themes", [], "any", false, false, true, 57));
            foreach ($context['_seq'] as $context["_key"] => $context["theme"]) {
                // line 58
                echo "          ";
                // line 59
                $context["theme_classes"] = [0 => ((twig_get_attribute($this->env, $this->source,                 // line 60
$context["theme"], "is_default", [], "any", false, false, true, 60)) ? ("theme-default") : ("")), 1 => ((twig_get_attribute($this->env, $this->source,                 // line 61
$context["theme"], "is_admin", [], "any", false, false, true, 61)) ? ("theme-admin") : ("")), 2 => "card", 3 => ("card--" . $this->sandbox->ensureToStringAllowed(                // line 63
($context["card_alignment"] ?? null), 63, $this->source)), 4 => "card-list__item"];
                // line 67
                echo "          ";
                // line 68
                $context["theme_title_classes"] = [0 => "card__content-item", 1 => "heading-f"];
                // line 73
                echo "          ";
                // line 74
                $context["theme_description_classes"] = [0 => "card__content-item"];
                // line 78
                echo "          <div";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["theme"], "attributes", [], "any", false, false, true, 78), "addClass", [0 => ($context["theme_classes"] ?? null)], "method", false, false, true, 78), "setAttribute", [0 => "aria-labelledby", 1 => twig_get_attribute($this->env, $this->source, $context["theme"], "title_id", [], "any", false, false, true, 78)], "method", false, false, true, 78), "setAttribute", [0 => "aria-describedby", 1 => ((twig_get_attribute($this->env, $this->source, $context["theme"], "description_id", [], "any", false, false, true, 78)) ? (twig_get_attribute($this->env, $this->source, $context["theme"], "description_id", [], "any", false, false, true, 78)) : (null))], "method", false, false, true, 78), 78, $this->source), "html", null, true);
                echo ">
            ";
                // line 79
                if (twig_get_attribute($this->env, $this->source, $context["theme"], "screenshot", [], "any", false, false, true, 79)) {
                    // line 80
                    echo "              <div class=\"card__image\">
                ";
                    // line 81
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "screenshot", [], "any", false, false, true, 81), 81, $this->source), "html", null, true);
                    echo "
              </div>
            ";
                }
                // line 84
                echo "            <div class=\"card__content-wrapper\">
              <div class=\"card__content\">
                <h3";
                // line 86
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $this->extensions['Drupal\Core\Template\TwigExtension']->createAttribute(["id" => twig_get_attribute($this->env, $this->source, $context["theme"], "title_id", [], "any", false, false, true, 86)]), "addClass", [0 => ($context["theme_title_classes"] ?? null)], "method", false, false, true, 86), 86, $this->source), "html", null, true);
                echo " id=";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "title_id", [], "any", false, false, true, 86), 86, $this->source), "html", null, true);
                echo ">";
                // line 87
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "name", [], "any", false, false, true, 87), 87, $this->source), "html", null, true);
                echo " ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "version", [], "any", false, false, true, 87), 87, $this->source), "html", null, true);
                // line 88
                if (twig_get_attribute($this->env, $this->source, $context["theme"], "notes", [], "any", false, false, true, 88)) {
                    // line 89
                    echo "                    (";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->safeJoin($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "notes", [], "any", false, false, true, 89), 89, $this->source), ", "));
                    echo ")";
                }
                // line 91
                echo "</h3>

                ";
                // line 93
                if ((twig_get_attribute($this->env, $this->source, $context["theme"], "description", [], "any", false, false, true, 93) && twig_get_attribute($this->env, $this->source, $context["theme"], "description_id", [], "any", false, false, true, 93))) {
                    // line 94
                    echo "                  <div";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $this->extensions['Drupal\Core\Template\TwigExtension']->createAttribute(["id" => ((twig_get_attribute($this->env, $this->source, $context["theme"], "description_id", [], "any", false, false, true, 94)) ? (twig_get_attribute($this->env, $this->source, $context["theme"], "description_id", [], "any", false, false, true, 94)) : (null))]), "addClass", [0 => ($context["theme_description_classes"] ?? null)], "method", false, false, true, 94), 94, $this->source), "html", null, true);
                    echo ">
                    ";
                    // line 95
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "description", [], "any", false, false, true, 95), 95, $this->source), "html", null, true);
                    echo "
                  </div>";
                }
                // line 98
                echo "</div>

              <div class=\"card__footer\">
                ";
                // line 101
                if (twig_get_attribute($this->env, $this->source, $context["theme"], "module_dependencies", [], "any", false, false, true, 101)) {
                    // line 102
                    echo "                  <div class=\"theme-info__requires\">
                    ";
                    // line 103
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Requires: @module_dependencies", ["@module_dependencies" => $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "module_dependencies", [], "any", false, false, true, 103), 103, $this->source))]));
                    echo "
                  </div>
                ";
                }
                // line 106
                echo "                ";
                // line 107
                echo "                ";
                if (twig_get_attribute($this->env, $this->source, $context["theme"], "incompatible", [], "any", false, false, true, 107)) {
                    // line 108
                    echo "                  <small class=\"incompatible\">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "incompatible", [], "any", false, false, true, 108), 108, $this->source), "html", null, true);
                    echo "</small>
                ";
                } else {
                    // line 110
                    echo "                    ";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "operations", [], "any", false, false, true, 110), 110, $this->source), "html", null, true);
                    echo "
                ";
                }
                // line 112
                echo "              </div>
            </div>
          </div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['theme'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 116
            echo "      </div>
    </div>
  ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['theme_group'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 119
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "core/themes/claro/templates/system-themes-page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  224 => 119,  208 => 116,  199 => 112,  193 => 110,  187 => 108,  184 => 107,  182 => 106,  176 => 103,  173 => 102,  171 => 101,  166 => 98,  161 => 95,  156 => 94,  154 => 93,  150 => 91,  145 => 89,  143 => 88,  139 => 87,  134 => 86,  130 => 84,  124 => 81,  121 => 80,  119 => 79,  114 => 78,  112 => 74,  110 => 73,  108 => 68,  106 => 67,  104 => 63,  103 => 61,  102 => 60,  101 => 59,  99 => 58,  95 => 57,  91 => 56,  87 => 55,  83 => 54,  80 => 53,  76 => 51,  74 => 50,  71 => 49,  69 => 47,  66 => 45,  64 => 41,  63 => 39,  61 => 38,  44 => 37,  39 => 36,);
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/claro/templates/system-themes-page.html.twig", "/var/www/web/core/themes/claro/templates/system-themes-page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 37, "set" => 39, "if" => 50);
        static $filters = array("escape" => 36, "safe_join" => 89, "t" => 103, "render" => 103);
        static $functions = array("create_attribute" => 86);

        try {
            $this->sandbox->checkSecurity(
                ['for', 'set', 'if'],
                ['escape', 'safe_join', 't', 'render'],
                ['create_attribute']
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
