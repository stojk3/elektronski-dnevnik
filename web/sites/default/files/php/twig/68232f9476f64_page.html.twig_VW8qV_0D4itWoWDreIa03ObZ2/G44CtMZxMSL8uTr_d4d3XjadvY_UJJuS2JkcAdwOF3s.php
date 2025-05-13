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

/* themes/contrib/bootstrap3/templates/system/page.html.twig */
class __TwigTemplate_9403083e169a964dba5bf4aeb95173d9 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'navbar' => [$this, 'block_navbar'],
            'main' => [$this, 'block_main'],
            'header' => [$this, 'block_header'],
            'sidebar_first' => [$this, 'block_sidebar_first'],
            'highlighted' => [$this, 'block_highlighted'],
            'help' => [$this, 'block_help'],
            'content' => [$this, 'block_content'],
            'sidebar_second' => [$this, 'block_sidebar_second'],
            'footer' => [$this, 'block_footer'],
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 54
        $context["container"] = ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["theme"] ?? null), "settings", [], "any", false, false, true, 54), "fluid_container", [], "any", false, false, true, 54)) ? ("container-fluid") : ("container"));
        // line 56
        if ((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "navigation", [], "any", false, false, true, 56) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "navigation_collapsible", [], "any", false, false, true, 56))) {
            // line 57
            echo "  ";
            $this->displayBlock('navbar', $context, $blocks);
        }
        // line 94
        echo "
";
        // line 96
        $this->displayBlock('main', $context, $blocks);
        // line 161
        echo "
";
        // line 162
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 162)) {
            // line 163
            echo "  ";
            $this->displayBlock('footer', $context, $blocks);
        }
    }

    // line 57
    public function block_navbar($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 58
        echo "    ";
        // line 59
        $context["navbar_classes"] = [0 => "navbar", 1 => ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,         // line 61
($context["theme"] ?? null), "settings", [], "any", false, false, true, 61), "navbar_inverse", [], "any", false, false, true, 61)) ? ("navbar-inverse") : ("navbar-default")), 2 => ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,         // line 62
($context["theme"] ?? null), "settings", [], "any", false, false, true, 62), "navbar_position", [], "any", false, false, true, 62)) ? (("navbar-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["theme"] ?? null), "settings", [], "any", false, false, true, 62), "navbar_position", [], "any", false, false, true, 62), 62, $this->source)))) : (($context["container"] ?? null)))];
        // line 65
        echo "    <header";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["navbar_attributes"] ?? null), "addClass", [0 => ($context["navbar_classes"] ?? null)], "method", false, false, true, 65), 65, $this->source), "html", null, true);
        echo " id=\"navbar\" role=\"banner\">
      ";
        // line 66
        if ( !twig_get_attribute($this->env, $this->source, ($context["navbar_attributes"] ?? null), "hasClass", [0 => ($context["container"] ?? null)], "method", false, false, true, 66)) {
            // line 67
            echo "        <div class=\"";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null), 67, $this->source), "html", null, true);
            echo "\">
      ";
        }
        // line 69
        echo "      <div class=\"navbar-header\">
        ";
        // line 70
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "navigation", [], "any", false, false, true, 70), 70, $this->source), "html", null, true);
        echo "
        ";
        // line 72
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "navigation_collapsible", [], "any", false, false, true, 72)) {
            // line 73
            echo "          <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar-collapse\" aria-expanded=\"false\">
            <span class=\"sr-only\">";
            // line 74
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Toggle navigation"));
            echo "</span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
          </button>
        ";
        }
        // line 80
        echo "      </div>

      ";
        // line 83
        echo "      ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "navigation_collapsible", [], "any", false, false, true, 83)) {
            // line 84
            echo "        <div id=\"navbar-collapse\" class=\"navbar-collapse collapse\">
          ";
            // line 85
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "navigation_collapsible", [], "any", false, false, true, 85), 85, $this->source), "html", null, true);
            echo "
        </div>
      ";
        }
        // line 88
        echo "      ";
        if ( !twig_get_attribute($this->env, $this->source, ($context["navbar_attributes"] ?? null), "hasClass", [0 => ($context["container"] ?? null)], "method", false, false, true, 88)) {
            // line 89
            echo "        </div>
      ";
        }
        // line 91
        echo "    </header>
  ";
    }

    // line 96
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 97
        echo "  <div role=\"main\" class=\"main-container ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null), 97, $this->source), "html", null, true);
        echo " js-quickedit-main-content\">
    <div class=\"row\">

      ";
        // line 101
        echo "      ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 101)) {
            // line 102
            echo "        ";
            $this->displayBlock('header', $context, $blocks);
            // line 107
            echo "      ";
        }
        // line 108
        echo "
      ";
        // line 110
        echo "      ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 110)) {
            // line 111
            echo "        ";
            $this->displayBlock('sidebar_first', $context, $blocks);
            // line 116
            echo "      ";
        }
        // line 117
        echo "
      ";
        // line 119
        echo "      ";
        // line 120
        $context["content_classes"] = [0 => (((twig_get_attribute($this->env, $this->source,         // line 121
($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 121) && twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 121))) ? ("col-sm-6") : ("")), 1 => (((twig_get_attribute($this->env, $this->source,         // line 122
($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 122) && twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 122)))) ? ("col-sm-9") : ("")), 2 => (((twig_get_attribute($this->env, $this->source,         // line 123
($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 123) && twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 123)))) ? ("col-sm-9") : ("")), 3 => (((twig_test_empty(twig_get_attribute($this->env, $this->source,         // line 124
($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 124)) && twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 124)))) ? ("col-sm-12") : (""))];
        // line 127
        echo "      <section";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["content_attributes"] ?? null), "addClass", [0 => ($context["content_classes"] ?? null)], "method", false, false, true, 127), 127, $this->source), "html", null, true);
        echo ">

        ";
        // line 130
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 130)) {
            // line 131
            echo "          ";
            $this->displayBlock('highlighted', $context, $blocks);
            // line 134
            echo "        ";
        }
        // line 135
        echo "
        ";
        // line 137
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "help", [], "any", false, false, true, 137)) {
            // line 138
            echo "          ";
            $this->displayBlock('help', $context, $blocks);
            // line 141
            echo "        ";
        }
        // line 142
        echo "
        ";
        // line 144
        echo "        ";
        $this->displayBlock('content', $context, $blocks);
        // line 148
        echo "      </section>

      ";
        // line 151
        echo "      ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 151)) {
            // line 152
            echo "        ";
            $this->displayBlock('sidebar_second', $context, $blocks);
            // line 157
            echo "      ";
        }
        // line 158
        echo "    </div>
  </div>
";
    }

    // line 102
    public function block_header($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 103
        echo "          <div class=\"col-sm-12\" role=\"heading\">
            ";
        // line 104
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 104), 104, $this->source), "html", null, true);
        echo "
          </div>
        ";
    }

    // line 111
    public function block_sidebar_first($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 112
        echo "          <aside class=\"col-sm-3\" role=\"complementary\">
            ";
        // line 113
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 113), 113, $this->source), "html", null, true);
        echo "
          </aside>
        ";
    }

    // line 131
    public function block_highlighted($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 132
        echo "            <div class=\"highlighted\">";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 132), 132, $this->source), "html", null, true);
        echo "</div>
          ";
    }

    // line 138
    public function block_help($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 139
        echo "            ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "help", [], "any", false, false, true, 139), 139, $this->source), "html", null, true);
        echo "
          ";
    }

    // line 144
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 145
        echo "          <a id=\"main-content\"></a>
          ";
        // line 146
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 146), 146, $this->source), "html", null, true);
        echo "
        ";
    }

    // line 152
    public function block_sidebar_second($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 153
        echo "          <aside class=\"col-sm-3\" role=\"complementary\">
            ";
        // line 154
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 154), 154, $this->source), "html", null, true);
        echo "
          </aside>
        ";
    }

    // line 163
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 164
        echo "    <footer class=\"footer ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null), 164, $this->source), "html", null, true);
        echo "\" role=\"contentinfo\">
      ";
        // line 165
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 165), 165, $this->source), "html", null, true);
        echo "
    </footer>
  ";
    }

    public function getTemplateName()
    {
        return "themes/contrib/bootstrap3/templates/system/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  326 => 165,  321 => 164,  317 => 163,  310 => 154,  307 => 153,  303 => 152,  297 => 146,  294 => 145,  290 => 144,  283 => 139,  279 => 138,  272 => 132,  268 => 131,  261 => 113,  258 => 112,  254 => 111,  247 => 104,  244 => 103,  240 => 102,  234 => 158,  231 => 157,  228 => 152,  225 => 151,  221 => 148,  218 => 144,  215 => 142,  212 => 141,  209 => 138,  206 => 137,  203 => 135,  200 => 134,  197 => 131,  194 => 130,  188 => 127,  186 => 124,  185 => 123,  184 => 122,  183 => 121,  182 => 120,  180 => 119,  177 => 117,  174 => 116,  171 => 111,  168 => 110,  165 => 108,  162 => 107,  159 => 102,  156 => 101,  149 => 97,  145 => 96,  140 => 91,  136 => 89,  133 => 88,  127 => 85,  124 => 84,  121 => 83,  117 => 80,  108 => 74,  105 => 73,  102 => 72,  98 => 70,  95 => 69,  89 => 67,  87 => 66,  82 => 65,  80 => 62,  79 => 61,  78 => 59,  76 => 58,  72 => 57,  66 => 163,  64 => 162,  61 => 161,  59 => 96,  56 => 94,  52 => 57,  50 => 56,  48 => 54,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/contrib/bootstrap3/templates/system/page.html.twig", "/var/www/web/themes/contrib/bootstrap3/templates/system/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 54, "if" => 56, "block" => 57);
        static $filters = array("clean_class" => 62, "escape" => 65, "t" => 74);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'block'],
                ['clean_class', 'escape', 't'],
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
