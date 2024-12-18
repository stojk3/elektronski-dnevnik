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

/* themes/contrib/bootstrap5/templates/layout/page.html.twig */
class __TwigTemplate_ad7a0580f13b060f24307d8e5f5b5c16 extends Template
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
        // line 46
        $context["nav_classes"] = ((("navbar navbar-expand-lg" . (((        // line 47
($context["b5_navbar_schema"] ?? null) != "none")) ? ((" navbar-" . $this->sandbox->ensureToStringAllowed(($context["b5_navbar_schema"] ?? null), 47, $this->source))) : (" "))) . (((        // line 48
($context["b5_navbar_schema"] ?? null) != "none")) ? ((((($context["b5_navbar_schema"] ?? null) == "dark")) ? (" text-light") : (" text-dark"))) : (" "))) . (((        // line 49
($context["b5_navbar_bg_schema"] ?? null) != "none")) ? ((" bg-" . $this->sandbox->ensureToStringAllowed(($context["b5_navbar_bg_schema"] ?? null), 49, $this->source))) : (" ")));
        // line 51
        echo "
";
        // line 53
        $context["footer_classes"] = (((" " . (((        // line 54
($context["b5_footer_schema"] ?? null) != "none")) ? ((" footer-" . $this->sandbox->ensureToStringAllowed(($context["b5_footer_schema"] ?? null), 54, $this->source))) : (" "))) . (((        // line 55
($context["b5_footer_schema"] ?? null) != "none")) ? ((((($context["b5_footer_schema"] ?? null) == "dark")) ? (" text-light") : (" text-dark"))) : (" "))) . (((        // line 56
($context["b5_footer_bg_schema"] ?? null) != "none")) ? ((" bg-" . $this->sandbox->ensureToStringAllowed(($context["b5_footer_bg_schema"] ?? null), 56, $this->source))) : (" ")));
        // line 58
        echo "
<header role=\"banner\">
  ";
        // line 60
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 60), 60, $this->source), "html", null, true);
        echo "

  ";
        // line 62
        if (((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "nav_branding", [], "any", false, false, true, 62) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "nav_main", [], "any", false, false, true, 62)) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "nav_additional", [], "any", false, false, true, 62))) {
            // line 63
            echo "  <nav class=\"";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["nav_classes"] ?? null), 63, $this->source), "html", null, true);
            echo "\">
    <div class=\"";
            // line 64
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["b5_top_container"] ?? null), 64, $this->source), "html", null, true);
            echo " d-flex\">
      ";
            // line 65
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "nav_branding", [], "any", false, false, true, 65), 65, $this->source), "html", null, true);
            echo "

      ";
            // line 67
            if ((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "nav_main", [], "any", false, false, true, 67) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "nav_additional", [], "any", false, false, true, 67))) {
                // line 68
                echo "        <button class=\"navbar-toggler collapsed\" type=\"button\" data-bs-toggle=\"collapse\"
                data-bs-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\"
                aria-expanded=\"false\" aria-label=\"Toggle navigation\">
          <span class=\"navbar-toggler-icon\"></span>
        </button>

        <div class=\"collapse navbar-collapse justify-content-md-end\" id=\"navbarSupportedContent\">
          ";
                // line 75
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "nav_main", [], "any", false, false, true, 75), 75, $this->source), "html", null, true);
                echo "
          ";
                // line 76
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "nav_additional", [], "any", false, false, true, 76), 76, $this->source), "html", null, true);
                echo "
        </div>
      ";
            }
            // line 79
            echo "    </div>
  </nav>
  ";
        }
        // line 82
        echo "
</header>

<main role=\"main\">
  <a id=\"main-content\" tabindex=\"-1\"></a>";
        // line 87
        echo "
  ";
        // line 89
        $context["sidebar_first_classes"] = (((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 89) && twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 89))) ? ("col-12 col-sm-6 col-lg-3") : ("col-12 col-lg-3"));
        // line 91
        echo "
  ";
        // line 93
        $context["sidebar_second_classes"] = (((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 93) && twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 93))) ? ("col-12 col-sm-6 col-lg-3") : ("col-12 col-lg-3"));
        // line 95
        echo "
  ";
        // line 97
        $context["content_classes"] = (((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 97) && twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 97))) ? ("col-12 col-lg-6") : ((((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 97) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 97))) ? ("col-12 col-lg-9") : ("col-12"))));
        // line 99
        echo "

  <div class=\"";
        // line 101
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["b5_top_container"] ?? null), 101, $this->source), "html", null, true);
        echo "\">
    ";
        // line 102
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 102)) {
            // line 103
            echo "      ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 103), 103, $this->source), "html", null, true);
            echo "
    ";
        }
        // line 105
        echo "    <div class=\"row g-0\">
      ";
        // line 106
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 106)) {
            // line 107
            echo "        <div class=\"order-2 order-lg-1 ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["sidebar_first_classes"] ?? null), 107, $this->source), "html", null, true);
            echo "\">
          ";
            // line 108
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 108), 108, $this->source), "html", null, true);
            echo "
        </div>
      ";
        }
        // line 111
        echo "      <div class=\"order-1 order-lg-2 ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["content_classes"] ?? null), 111, $this->source), "html", null, true);
        echo "\">
        ";
        // line 112
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 112), 112, $this->source), "html", null, true);
        echo "
      </div>
      ";
        // line 114
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 114)) {
            // line 115
            echo "        <div class=\"order-3 ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["sidebar_second_classes"] ?? null), 115, $this->source), "html", null, true);
            echo "\">
          ";
            // line 116
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 116), 116, $this->source), "html", null, true);
            echo "
        </div>
      ";
        }
        // line 119
        echo "    </div>
  </div>

</main>

";
        // line 124
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 124)) {
            // line 125
            echo "<footer role=\"contentinfo\" class=\"mt-auto ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["footer_classes"] ?? null), 125, $this->source), "html", null, true);
            echo "\">
  <div class=\"";
            // line 126
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["b5_top_container"] ?? null), 126, $this->source), "html", null, true);
            echo "\">
    ";
            // line 127
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 127), 127, $this->source), "html", null, true);
            echo "
  </div>
</footer>
";
        }
    }

    public function getTemplateName()
    {
        return "themes/contrib/bootstrap5/templates/layout/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  197 => 127,  193 => 126,  188 => 125,  186 => 124,  179 => 119,  173 => 116,  168 => 115,  166 => 114,  161 => 112,  156 => 111,  150 => 108,  145 => 107,  143 => 106,  140 => 105,  134 => 103,  132 => 102,  128 => 101,  124 => 99,  122 => 97,  119 => 95,  117 => 93,  114 => 91,  112 => 89,  109 => 87,  103 => 82,  98 => 79,  92 => 76,  88 => 75,  79 => 68,  77 => 67,  72 => 65,  68 => 64,  63 => 63,  61 => 62,  56 => 60,  52 => 58,  50 => 56,  49 => 55,  48 => 54,  47 => 53,  44 => 51,  42 => 49,  41 => 48,  40 => 47,  39 => 46,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/contrib/bootstrap5/templates/layout/page.html.twig", "/var/www/web/themes/contrib/bootstrap5/templates/layout/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 46, "if" => 62);
        static $filters = array("escape" => 60);
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
