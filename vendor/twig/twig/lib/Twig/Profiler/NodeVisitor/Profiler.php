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
<<<<<<< HEAD
=======
 *
 * @final
>>>>>>> git-aline/master/master
 */
class Twig_Profiler_NodeVisitor_Profiler extends Twig_BaseNodeVisitor
{
    private $extensionName;

    public function __construct($extensionName)
    {
        $this->extensionName = $extensionName;
    }

<<<<<<< HEAD
    /**
     * {@inheritdoc}
     */
=======
>>>>>>> git-aline/master/master
    protected function doEnterNode(Twig_Node $node, Twig_Environment $env)
    {
        return $node;
    }

<<<<<<< HEAD
    /**
     * {@inheritdoc}
     */
=======
>>>>>>> git-aline/master/master
    protected function doLeaveNode(Twig_Node $node, Twig_Environment $env)
    {
        if ($node instanceof Twig_Node_Module) {
            $varName = $this->getVarName();
<<<<<<< HEAD
            $node->setNode('display_start', new Twig_Node(array(new Twig_Profiler_Node_EnterProfile($this->extensionName, Twig_Profiler_Profile::TEMPLATE, $node->getAttribute('filename'), $varName), $node->getNode('display_start'))));
=======
            $node->setNode('display_start', new Twig_Node(array(new Twig_Profiler_Node_EnterProfile($this->extensionName, Twig_Profiler_Profile::TEMPLATE, $node->getTemplateName(), $varName), $node->getNode('display_start'))));
>>>>>>> git-aline/master/master
            $node->setNode('display_end', new Twig_Node(array(new Twig_Profiler_Node_LeaveProfile($varName), $node->getNode('display_end'))));
        } elseif ($node instanceof Twig_Node_Block) {
            $varName = $this->getVarName();
            $node->setNode('body', new Twig_Node_Body(array(
                new Twig_Profiler_Node_EnterProfile($this->extensionName, Twig_Profiler_Profile::BLOCK, $node->getAttribute('name'), $varName),
                $node->getNode('body'),
                new Twig_Profiler_Node_LeaveProfile($varName),
            )));
        } elseif ($node instanceof Twig_Node_Macro) {
            $varName = $this->getVarName();
            $node->setNode('body', new Twig_Node_Body(array(
                new Twig_Profiler_Node_EnterProfile($this->extensionName, Twig_Profiler_Profile::MACRO, $node->getAttribute('name'), $varName),
                $node->getNode('body'),
                new Twig_Profiler_Node_LeaveProfile($varName),
            )));
        }

        return $node;
    }

    private function getVarName()
    {
<<<<<<< HEAD
        return sprintf('__internal_%s', hash('sha256', uniqid(mt_rand(), true), false));
    }

    /**
     * {@inheritdoc}
     */
=======
        return sprintf('__internal_%s', hash('sha256', $this->extensionName));
    }

>>>>>>> git-aline/master/master
    public function getPriority()
    {
        return 0;
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_Profiler_NodeVisitor_Profiler', 'Twig\Profiler\NodeVisitor\ProfilerNodeVisitor', false);
>>>>>>> git-aline/master/master
