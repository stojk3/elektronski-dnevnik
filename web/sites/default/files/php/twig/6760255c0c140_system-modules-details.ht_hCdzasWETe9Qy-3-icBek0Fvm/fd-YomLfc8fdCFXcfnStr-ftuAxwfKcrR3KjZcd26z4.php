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

/* core/themes/claro/templates/admin/system-modules-details.html.twig */
class __TwigTemplate_3104585744805629ea15825c1f74bf1b extends Template
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
        // line 27
        echo "<table class=\"responsive-enabled module-list\">
  <thead>
    <tr>
      <th class=\"checkbox visually-hidden\">";
        // line 30
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Installed"));
        echo "</th>
      <th class=\"name visually-hidden\">";
        // line 31
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Name"));
        echo "</th>
      <th class=\"description visually-hidden priority-low\">";
        // line 32
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Description"));
        echo "</th>
    </tr>
  </thead>
  <tbody>
    ";
        // line 36
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["modules"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["module"]) {
            // line 37
            echo "      <tr";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["module"], "attributes", [], "any", false, false, true, 37), "addClass", [0 => "module-list__module"], "method", false, false, true, 37), 37, $this->source), "html", null, true);
            echo ">
        <td class=\"module-list__checkbox\">
          ";
            // line 39
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "checkbox", [], "any", false, false, true, 39), 39, $this->source), "html", null, true);
            echo "
        </td>
        <td class=\"module-list__module\">
          <label id=\"";
            // line 42
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "id", [], "any", false, false, true, 42), 42, $this->source), "html", null, true);
            echo "\" for=\"";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "enable_id", [], "any", false, false, true, 42), 42, $this->source), "html", null, true);
            echo "\" class=\"module-list__module-name table-filter-text-source\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "name", [], "any", false, false, true, 42), 42, $this->source), "html", null, true);
            echo "</label>
        </td>
        <td class=\"expand priority-low module-list__description\">
          <details class=\"js-form-wrapper form-wrapper module-list__module-details claro-details\" id=\"";
            // line 45
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "enable_id", [], "any", false, false, true, 45), 45, $this->source), "html", null, true);
            echo "-description\">
            <summary aria-controls=\"";
            // line 46
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "enable_id", [], "any", false, false, true, 46), 46, $this->source), "html", null, true);
            echo "-description\" role=\"button\" aria-expanded=\"false\" class=\"claro-details__summary module-list__module-summary\"><span class=\"text module-description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "description", [], "any", false, false, true, 46), 46, $this->source), "html", null, true);
            echo "</span></summary>
            <div class=\"claro-details__wrapper module-details__wrapper\">
              <div class=\"module-details__description\">
                <div class=\"module-details__requirements\">
                  <div class=\"module-details__requirement\">";
            // line 50
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Machine name: <span dir=\"ltr\" class=\"table-filter-text-source\">@machine-name</span>", ["@machine-name" => twig_get_attribute($this->env, $this->source, $context["module"], "machine_name", [], "any", false, false, true, 50)]));
            echo "</div>
                  ";
            // line 51
            if (twig_get_attribute($this->env, $this->source, $context["module"], "version", [], "any", false, false, true, 51)) {
                // line 52
                echo "                    <div class=\"module-details__requirement\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Version: @module-version", ["@module-version" => twig_get_attribute($this->env, $this->source, $context["module"], "version", [], "any", false, false, true, 52)]));
                echo "</div>
                  ";
            }
            // line 54
            echo "                  ";
            if (twig_get_attribute($this->env, $this->source, $context["module"], "requires", [], "any", false, false, true, 54)) {
                // line 55
                echo "                    <div class=\"module-details__requirement\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Requires: @module-list", ["@module-list" => twig_get_attribute($this->env, $this->source, $context["module"], "requires", [], "any", false, false, true, 55)]));
                echo "</div>
                  ";
            }
            // line 57
            echo "                  ";
            if (twig_get_attribute($this->env, $this->source, $context["module"], "required_by", [], "any", false, false, true, 57)) {
                // line 58
                echo "                    <div class=\"module-details__requirement\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Required by: @module-list", ["@module-list" => twig_get_attribute($this->env, $this->source, $context["module"], "required_by", [], "any", false, false, true, 58)]));
                echo "</div>
                  ";
            }
            // line 60
            echo "                </div>
                ";
            // line 61
            if (twig_get_attribute($this->env, $this->source, $context["module"], "links", [], "any", false, false, true, 61)) {
                // line 62
                echo "                  <div class=\"module-details__links\">
                    ";
                // line 63
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable([0 => "help", 1 => "permissions", 2 => "configure"]);
                foreach ($context['_seq'] as $context["_key"] => $context["link_type"]) {
                    // line 64
                    echo "                      ";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_0 = twig_get_attribute($this->env, $this->source, $context["module"], "links", [], "any", false, false, true, 64)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[$context["link_type"]] ?? null) : null), 64, $this->source), "html", null, true);
                    echo "
                    ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link_type'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 66
                echo "                  </div>
                ";
            }
            // line 68
            echo "              </div>
            </div>
          </details>
        </td>
      </tr>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['module'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 74
        echo "  </tbody>
</table>
";
    }

    public function getTemplateName()
    {
        return "core/themes/claro/templates/admin/system-modules-details.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  164 => 74,  153 => 68,  149 => 66,  140 => 64,  136 => 63,  133 => 62,  131 => 61,  128 => 60,  122 => 58,  119 => 57,  113 => 55,  110 => 54,  104 => 52,  102 => 51,  98 => 50,  89 => 46,  85 => 45,  75 => 42,  69 => 39,  63 => 37,  59 => 36,  52 => 32,  48 => 31,  44 => 30,  39 => 27,);
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/claro/templates/admin/system-modules-details.html.twig", "/var/www/web/core/themes/claro/templates/admin/system-modules-details.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 36, "if" => 51);
        static $filters = array("t" => 30, "escape" => 37);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['for', 'if'],
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
