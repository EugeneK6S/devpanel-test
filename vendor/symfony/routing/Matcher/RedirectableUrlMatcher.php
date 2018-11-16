<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Matcher;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Route;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class RedirectableUrlMatcher extends UrlMatcher implements RedirectableUrlMatcherInterface
{
    /**
     * {@inheritdoc}
     */
    public function match($pathinfo)
    {
        try {
            $parameters = parent::match($pathinfo);
        } catch (ResourceNotFoundException $e) {
<<<<<<< HEAD
            if ('/' === substr($pathinfo, -1) || !in_array($this->context->getMethod(), array('HEAD', 'GET'))) {
=======
            if ('/' === substr($pathinfo, -1) || !\in_array($this->context->getMethod(), array('HEAD', 'GET'))) {
>>>>>>> git-aline/master/master
                throw $e;
            }

            try {
<<<<<<< HEAD
                parent::match($pathinfo.'/');

                return $this->redirect($pathinfo.'/', null);
=======
                $parameters = parent::match($pathinfo.'/');

                return array_replace($parameters, $this->redirect($pathinfo.'/', isset($parameters['_route']) ? $parameters['_route'] : null));
>>>>>>> git-aline/master/master
            } catch (ResourceNotFoundException $e2) {
                throw $e;
            }
        }

        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    protected function handleRouteRequirements($pathinfo, $name, Route $route)
    {
        // expression condition
<<<<<<< HEAD
        if ($route->getCondition() && !$this->getExpressionLanguage()->evaluate($route->getCondition(), array('context' => $this->context, 'request' => $this->request))) {
=======
        if ($route->getCondition() && !$this->getExpressionLanguage()->evaluate($route->getCondition(), array('context' => $this->context, 'request' => $this->request ?: $this->createRequest($pathinfo)))) {
>>>>>>> git-aline/master/master
            return array(self::REQUIREMENT_MISMATCH, null);
        }

        // check HTTP scheme requirement
        $scheme = $this->context->getScheme();
        $schemes = $route->getSchemes();
        if ($schemes && !$route->hasScheme($scheme)) {
            return array(self::ROUTE_MATCH, $this->redirect($pathinfo, $name, current($schemes)));
        }

        return array(self::REQUIREMENT_MATCH, null);
    }
}
