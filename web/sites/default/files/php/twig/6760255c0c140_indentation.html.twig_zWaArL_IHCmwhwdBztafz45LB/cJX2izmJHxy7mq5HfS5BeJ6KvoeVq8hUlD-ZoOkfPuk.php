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

/* core/themes/claro/templates/admin/indentation.html.twig */
class __TwigTemplate_cfd5b770cd778fef631ca547e7743311 extends Template
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
        // line 12
        if ((($context["size"] ?? null) > 0)) {
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(range(1, ($context["size"] ?? null)));
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                echo "<div class=\"js-indentation indentation\">
  <svg
    xmlns=\"http://www.w3.org/2000/svg\"
    class=\"tree\"
    width=\"25\"
    height=\"25\"
    viewBox=\"0 0 25 25\">
    <path
      class=\"tree__item tree__item-child-ltr tree__item-child-last-ltr tree__item-horizontal tree__item-horizontal-right\"
      d=\"M12,12.5 H25\"
      stroke=\"#888\"/>
    <path
      class=\"tree__item tree__item-child-rtl tree__item-child-last-rtl tree__item-horizontal tree__horizontal-left\"
      d=\"M0,12.5 H13\"
      stroke=\"#888\"/>
    <path
      class=\"tree__item tree__item-child-ltr tree__item-child-rtl tree__item-child-last-ltr tree__item-child-last-rtl tree__vertical tree__vertical-top\"
      d=\"M12.5,12 v-99\"
      stroke=\"#888\"/>
    <path
      class=\"tree__item tree__item-child-ltr tree__item-child-rtl tree__vertical tree__vertical-bottom\"
      d=\"M12.5,12 v99\"
      stroke=\"#888\"/>
  </svg>
</div>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
    }

    public function getTemplateName()
    {
        return "core/themes/claro/templates/admin/indentation.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 12,);
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/claro/templates/admin/indentation.html.twig", "/var/www/web/core/themes/claro/templates/admin/indentation.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 12, "for" => 12);
        static $filters = array();
        static $functions = array("range" => 12);

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
                [],
                ['range']
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
