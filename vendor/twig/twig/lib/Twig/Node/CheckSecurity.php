<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) 2015 Fabien Potencier
=======
 * (c) Fabien Potencier
>>>>>>> git-aline/master/master
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Twig_Node_CheckSecurity extends Twig_Node
{
    protected $usedFilters;
    protected $usedTags;
    protected $usedFunctions;

    public function __construct(array $usedFilters, array $usedTags, array $usedFunctions)
    {
        $this->usedFilters = $usedFilters;
        $this->usedTags = $usedTags;
        $this->usedFunctions = $usedFunctions;

        parent::__construct();
    }

    public function compile(Twig_Compiler $compiler)
    {
        $tags = $filters = $functions = array();
        foreach (array('tags', 'filters', 'functions') as $type) {
            foreach ($this->{'used'.ucfirst($type)} as $name => $node) {
                if ($node instanceof Twig_Node) {
<<<<<<< HEAD
                    ${$type}[$name] = $node->getLine();
=======
                    ${$type}[$name] = $node->getTemplateLine();
>>>>>>> git-aline/master/master
                } else {
                    ${$type}[$node] = null;
                }
            }
        }

        $compiler
            ->write('$tags = ')->repr(array_filter($tags))->raw(";\n")
            ->write('$filters = ')->repr(array_filter($filters))->raw(";\n")
            ->write('$functions = ')->repr(array_filter($functions))->raw(";\n\n")
            ->write("try {\n")
            ->indent()
<<<<<<< HEAD
            ->write("\$this->env->getExtension('sandbox')->checkSecurity(\n")
=======
            ->write("\$this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(\n")
>>>>>>> git-aline/master/master
            ->indent()
            ->write(!$tags ? "array(),\n" : "array('".implode("', '", array_keys($tags))."'),\n")
            ->write(!$filters ? "array(),\n" : "array('".implode("', '", array_keys($filters))."'),\n")
            ->write(!$functions ? "array()\n" : "array('".implode("', '", array_keys($functions))."')\n")
            ->outdent()
            ->write(");\n")
            ->outdent()
            ->write("} catch (Twig_Sandbox_SecurityError \$e) {\n")
            ->indent()
<<<<<<< HEAD
            ->write("\$e->setTemplateFile(\$this->getTemplateName());\n\n")
=======
            ->write("\$e->setSourceContext(\$this->getSourceContext());\n\n")
>>>>>>> git-aline/master/master
            ->write("if (\$e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset(\$tags[\$e->getTagName()])) {\n")
            ->indent()
            ->write("\$e->setTemplateLine(\$tags[\$e->getTagName()]);\n")
            ->outdent()
            ->write("} elseif (\$e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset(\$filters[\$e->getFilterName()])) {\n")
            ->indent()
            ->write("\$e->setTemplateLine(\$filters[\$e->getFilterName()]);\n")
            ->outdent()
            ->write("} elseif (\$e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset(\$functions[\$e->getFunctionName()])) {\n")
            ->indent()
            ->write("\$e->setTemplateLine(\$functions[\$e->getFunctionName()]);\n")
            ->outdent()
            ->write("}\n\n")
            ->write("throw \$e;\n")
            ->outdent()
            ->write("}\n\n")
        ;
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_Node_CheckSecurity', 'Twig\Node\CheckSecurityNode', false);
>>>>>>> git-aline/master/master
