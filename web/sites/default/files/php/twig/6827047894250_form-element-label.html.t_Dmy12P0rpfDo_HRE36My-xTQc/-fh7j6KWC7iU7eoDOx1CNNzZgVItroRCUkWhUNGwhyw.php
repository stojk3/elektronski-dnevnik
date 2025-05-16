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

/* themes/contrib/bootstrap3/templates/input/form-element-label.html.twig */
class __TwigTemplate_905ef05ff4caf91fc930ada47d038d46 extends Template
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
        $context["classes"] = [0 => "control-label", 1 => (((        // line 24
($context["title_display"] ?? null) == "after")) ? ("option") : ("")), 2 => ((((        // line 25
($context["title_display"] ?? null) == "invisible") &&  !(($context["is_checkbox"] ?? null) || ($context["is_radio"] ?? null)))) ? ("sr-only") : ("")), 3 => ((        // line 26
($context["required"] ?? null)) ? ("js-form-required") : ("")), 4 => ((        // line 27
($context["required"] ?? null)) ? ("form-required") : (""))];
        // line 30
        if ((( !twig_test_empty(($context["title"] ?? null)) && (($context["title_display"] ?? null) == "invisible")) && (($context["is_checkbox"] ?? null) || ($context["is_radio"] ?? null)))) {
            // line 35
            $context["attributes"] = twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "setAttribute", [0 => "title", 1 => ($context["title"] ?? null)], "method", false, false, true, 35);
            // line 36
            $context["title"] = null;
        }
        // line 42
        if ((( !twig_test_empty(($context["title"] ?? null)) || ($context["is_checkbox"] ?? null)) || ($context["is_radio"] ?? null))) {
            // line 43
            echo "<label";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 43), 43, $this->source), "html", null, true);
            echo ">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["element"] ?? null), 43, $this->source), "html", null, true);
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 43, $this->source), "html", null, true);
            // line 44
            if (($context["description"] ?? null)) {
                // line 45
                echo "<p class=\"help-block\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["description"] ?? null), 45, $this->source), "html", null, true);
                echo "</p>";
            }
            // line 47
            echo "</label>";
        }
    }

    public function getTemplateName()
    {
        return "themes/contrib/bootstrap3/templates/input/form-element-label.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 47,  62 => 45,  60 => 44,  54 => 43,  52 => 42,  49 => 36,  47 => 35,  45 => 30,  43 => 27,  42 => 26,  41 => 25,  40 => 24,  39 => 22,);
    }

    public function getSourceContext()
    {
        return new Source("{#
/**
 * @file
 * Default theme implementation for a form element label.
 *
 * Available variables:
 * - element: an input element.
 * - title: The label's text.
 * - title_display: Elements title_display setting.
 * - description: element description.
 * - required: An indicator for whether the associated form element is required.
 * - is_checkbox: Whether the label is outputted in checkbox context.
 * - is_radio: Whether the label is outputted in radio button context.
 * - attributes: A list of HTML attributes for the label.
 *
 * @ingroup templates
 *
 * @see template_preprocess_form_element_label()
 */
#}
{%-
  set classes = [
    'control-label',
    title_display == 'after' ? 'option',
    title_display == 'invisible' and not (is_checkbox or is_radio) ? 'sr-only',
    required ? 'js-form-required',
    required ? 'form-required',
  ]
-%}
{% if title is not empty and title_display == 'invisible' and (is_checkbox or is_radio) -%}
  {#
  Clear but preserve label text as attribute (e.g. for screen readers) for
  checkboxes/radio buttons when it actually should be invisible.
  #}
  {%- set attributes = attributes.setAttribute('title', title) -%}
  {%- set title = null -%}
{%- endif -%}
{#
Labels for single checkboxes/radios contain the element itself and thus have
always to be rendered regardless of whether they have a title or not.
#}
{%- if title is not empty or is_checkbox or is_radio -%}
  <label{{ attributes.addClass(classes) }}>{{ element }}{{ title }}
    {%- if description -%}
      <p class=\"help-block\">{{ description }}</p>
    {%- endif -%}
  </label>
{%- endif -%}
", "themes/contrib/bootstrap3/templates/input/form-element-label.html.twig", "/var/www/web/themes/contrib/bootstrap3/templates/input/form-element-label.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 22, "if" => 30);
        static $filters = array("escape" => 43);
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
