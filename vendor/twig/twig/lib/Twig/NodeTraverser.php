<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) 2009 Fabien Potencier
=======
 * (c) Fabien Potencier
>>>>>>> git-aline/master/master
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Twig_NodeTraverser is a node traverser.
 *
 * It visits all nodes and their children and calls the given visitor for each.
 *
<<<<<<< HEAD
=======
 * @final
 *
>>>>>>> git-aline/master/master
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Twig_NodeTraverser
{
    protected $env;
    protected $visitors = array();

    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param Twig_Environment            $env      A Twig_Environment instance
     * @param Twig_NodeVisitorInterface[] $visitors An array of Twig_NodeVisitorInterface instances
=======
     * @param Twig_Environment            $env
     * @param Twig_NodeVisitorInterface[] $visitors
>>>>>>> git-aline/master/master
     */
    public function __construct(Twig_Environment $env, array $visitors = array())
    {
        $this->env = $env;
        foreach ($visitors as $visitor) {
            $this->addVisitor($visitor);
        }
    }

<<<<<<< HEAD
    /**
     * Adds a visitor.
     *
     * @param Twig_NodeVisitorInterface $visitor A Twig_NodeVisitorInterface instance
     */
=======
>>>>>>> git-aline/master/master
    public function addVisitor(Twig_NodeVisitorInterface $visitor)
    {
        if (!isset($this->visitors[$visitor->getPriority()])) {
            $this->visitors[$visitor->getPriority()] = array();
        }

        $this->visitors[$visitor->getPriority()][] = $visitor;
    }

    /**
     * Traverses a node and calls the registered visitors.
     *
<<<<<<< HEAD
     * @param Twig_NodeInterface $node A Twig_NodeInterface instance
     *
=======
>>>>>>> git-aline/master/master
     * @return Twig_NodeInterface
     */
    public function traverse(Twig_NodeInterface $node)
    {
        ksort($this->visitors);
        foreach ($this->visitors as $visitors) {
            foreach ($visitors as $visitor) {
                $node = $this->traverseForVisitor($visitor, $node);
            }
        }

        return $node;
    }

    protected function traverseForVisitor(Twig_NodeVisitorInterface $visitor, Twig_NodeInterface $node = null)
    {
        if (null === $node) {
            return;
        }

        $node = $visitor->enterNode($node, $this->env);

        foreach ($node as $k => $n) {
<<<<<<< HEAD
            if (false !== $n = $this->traverseForVisitor($visitor, $n)) {
                $node->setNode($k, $n);
=======
            if (false !== $m = $this->traverseForVisitor($visitor, $n)) {
                if ($m !== $n) {
                    $node->setNode($k, $m);
                }
>>>>>>> git-aline/master/master
            } else {
                $node->removeNode($k);
            }
        }

        return $visitor->leaveNode($node, $this->env);
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_NodeTraverser', 'Twig\NodeTraverser', false);
>>>>>>> git-aline/master/master
