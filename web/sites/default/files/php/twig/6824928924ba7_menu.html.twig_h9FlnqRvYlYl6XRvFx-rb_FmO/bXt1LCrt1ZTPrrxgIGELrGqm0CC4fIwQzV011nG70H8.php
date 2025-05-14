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

/* menu.html.twig */
class __TwigTemplate_1906c99e7c63c194b7bb5f4b706f9aa1 extends Template
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
        $macros["_self"] = $this->macros["_self"] = $this;
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 54
        echo "
";
        // line 60
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["_self"], "macro_menu_links", [($context["items"] ?? null), ($context["attributes"] ?? null), 0, ((($context["classes"] ?? null)) ? (($context["classes"] ?? null)) : ([0 => "menu", 1 => ("menu--" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(($context["menu_name"] ?? null), 60, $this->source))), 2 => "nav"])), ((($context["dropdown_classes"] ?? null)) ? (($context["dropdown_classes"] ?? null)) : ([0 => "dropdown-menu"]))], 60, $context, $this->getSourceContext()));
        echo "
";
    }

    // line 22
    public function macro_menu_links($__items__ = null, $__attributes__ = null, $__menu_level__ = null, $__classes__ = null, $__dropdown_classes__ = null, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "items" => $__items__,
            "attributes" => $__attributes__,
            "menu_level" => $__menu_level__,
            "classes" => $__classes__,
            "dropdown_classes" => $__dropdown_classes__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start();
        try {
            // line 23
            echo "  ";
            if (($context["items"] ?? null)) {
                // line 24
                echo "    <ul";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => (((($context["menu_level"] ?? null) == 0)) ? (($context["classes"] ?? null)) : (($context["dropdown_classes"] ?? null)))], "method", false, false, true, 24), 24, $this->source), "html", null, true);
                echo ">
    ";
                // line 25
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["items"] ?? null));
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
                foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                    // line 26
                    echo "      ";
                    // line 27
                    $context["item_classes"] = twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 27), "getOption", [0 => "container_attributes"], "method", false, false, true, 27), "class", [], "any", false, false, true, 27);
                    // line 29
                    echo "      ";
                    // line 30
                    $context["item_classes"] = [0 => (((twig_get_attribute($this->env, $this->source,                     // line 31
$context["item"], "is_expanded", [], "any", false, false, true, 31) && twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 31))) ? ("expanded dropdown") : ("")), 1 => ((twig_get_attribute($this->env, $this->source,                     // line 32
$context["item"], "in_active_trail", [], "any", false, false, true, 32)) ? ("active active-trail") : ("")), 2 => ((twig_get_attribute($this->env, $this->source,                     // line 33
$context["loop"], "first", [], "any", false, false, true, 33)) ? ("first") : ("")), 3 => ((twig_get_attribute($this->env, $this->source,                     // line 34
$context["loop"], "last", [], "any", false, false, true, 34)) ? ("last") : (""))];
                    // line 37
                    echo "      <li";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 37), "addClass", [0 => ($context["item_classes"] ?? null)], "method", false, false, true, 37), 37, $this->source), "html", null, true);
                    echo ">
        ";
                    // line 38
                    $context["link_title"] = twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 38);
                    // line 39
                    echo "        ";
                    $context["link_attributes"] = twig_get_attribute($this->env, $this->source, $context["item"], "link_attributes", [], "any", false, false, true, 39);
                    // line 40
                    echo "        ";
                    if ((((($context["menu_level"] ?? null) == 0) && twig_get_attribute($this->env, $this->source, $context["item"], "is_expanded", [], "any", false, false, true, 40)) && twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 40))) {
                        // line 41
                        echo "          ";
                        ob_start();
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["link_title"] ?? null), 41, $this->source), "html", null, true);
                        echo " <span class=\"caret\"></span>";
                        $context["link_title"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
                        // line 42
                        echo "          ";
                        $context["link_attributes"] = twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["link_attributes"] ?? null), "addClass", [0 => "dropdown-toggle"], "method", false, false, true, 42), "setAttribute", [0 => "data-toggle", 1 => "dropdown"], "method", false, false, true, 42);
                        // line 43
                        echo "        ";
                    }
                    // line 44
                    echo "        ";
                    // line 45
                    echo "        ";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getLink($this->sandbox->ensureToStringAllowed(($context["link_title"] ?? null), 45, $this->source), $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 45), 45, $this->source), $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["link_attributes"] ?? null), "addClass", [0 => ((twig_get_attribute($this->env, $this->source, $context["item"], "in_active_trail", [], "any", false, false, true, 45)) ? ("active-trail") : (""))], "method", false, false, true, 45), 45, $this->source)), "html", null, true);
                    echo "
        ";
                    // line 46
                    if (twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 46)) {
                        // line 47
                        echo "          ";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["_self"], "macro_menu_links", [twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 47), twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "removeClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 47), (($context["menu_level"] ?? null) + 1), ($context["classes"] ?? null), ($context["dropdown_classes"] ?? null)], 47, $context, $this->getSourceContext()));
                        echo "
        ";
                    }
                    // line 49
                    echo "      </li>
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
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 51
                echo "    </ul>
  ";
            }

            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    public function getTemplateName()
    {
        return "menu.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  158 => 51,  143 => 49,  137 => 47,  135 => 46,  130 => 45,  128 => 44,  125 => 43,  122 => 42,  116 => 41,  113 => 40,  110 => 39,  108 => 38,  103 => 37,  101 => 34,  100 => 33,  99 => 32,  98 => 31,  97 => 30,  95 => 29,  93 => 27,  91 => 26,  74 => 25,  69 => 24,  66 => 23,  49 => 22,  43 => 60,  40 => 54,);
    }

    public function getSourceContext()
    {
        return new Source("{#
/**
 * @file
 * Default theme implementation to display a menu.
 *
 * Available variables:
 * - classes: A list of classes to apply to the top level <ul> element.
 * - dropdown_classes: A list of classes to apply to the dropdown <ul> element.
 * - menu_name: The machine name of the menu.
 * - items: A nested list of menu items. Each menu item contains:
 *   - attributes: HTML attributes for the menu item.
 *   - below: The menu item child items.
 *   - title: The menu link title.
 *   - url: The menu link url, instance of \\Drupal\\Core\\Url
 *   - localized_options: Menu link localized options.
 *
 * @ingroup templates
 *
 * Define a custom macro that will render all menu trees.
 */
#}
{% macro menu_links(items, attributes, menu_level, classes, dropdown_classes) %}
  {% if items %}
    <ul{{ attributes.addClass(menu_level == 0 ? classes : dropdown_classes) }}>
    {% for item in items %}
      {%
        set item_classes = item.url.getOption('container_attributes').class
      %}
      {%
        set item_classes = [
          item.is_expanded and item.below ? 'expanded dropdown',
          item.in_active_trail ? 'active active-trail',
          loop.first ? 'first',
          loop.last ? 'last',
        ]
      %}
      <li{{ item.attributes.addClass(item_classes) }}>
        {% set link_title = item.title %}
        {% set link_attributes = item.link_attributes %}
        {% if menu_level == 0 and item.is_expanded and item.below %}
          {% set link_title %}{{ link_title }} <span class=\"caret\"></span>{% endset %}
          {% set link_attributes = link_attributes.addClass('dropdown-toggle').setAttribute('data-toggle', 'dropdown') %}
        {% endif %}
        {# Must use link() here so it triggers hook_link_alter(). #}
        {{ link(link_title, item.url, link_attributes.addClass(item.in_active_trail ? 'active-trail')) }}
        {% if item.below %}
          {{ _self.menu_links(item.below, attributes.removeClass(classes), menu_level + 1, classes, dropdown_classes) }}
        {% endif %}
      </li>
    {% endfor %}
    </ul>
  {% endif %}
{% endmacro %}

{#
  Invoke the custom macro defined above. If classes were provided, use them.
  This allows the template to be extended without having to also duplicate the
  code above. @see http://twig.sensiolabs.org/doc/tags/macro.html
#}
{{ _self.menu_links(items, attributes, 0, classes ?: ['menu', 'menu--' ~ menu_name|clean_class, 'nav'], dropdown_classes ?: ['dropdown-menu']) }}
", "menu.html.twig", "themes/contrib/bootstrap3/templates/menu/menu.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("macro" => 22, "if" => 23, "for" => 25, "set" => 27);
        static $filters = array("clean_class" => 60, "escape" => 24);
        static $functions = array("link" => 45);

        try {
            $this->sandbox->checkSecurity(
                ['macro', 'if', 'for', 'set', 'import'],
                ['clean_class', 'escape'],
                ['link']
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
