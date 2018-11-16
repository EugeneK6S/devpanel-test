<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Fragment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
<<<<<<< HEAD
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\UriSigner;
=======
use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\UriSigner;
use Symfony\Component\Templating\EngineInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Loader\ExistsLoaderInterface;
>>>>>>> git-aline/master/master

/**
 * Implements the Hinclude rendering strategy.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class HIncludeFragmentRenderer extends RoutableFragmentRenderer
{
    private $globalDefaultTemplate;
    private $signer;
    private $templating;
    private $charset;

    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param EngineInterface|\Twig_Environment $templating            An EngineInterface or a \Twig_Environment instance
     * @param UriSigner                         $signer                A UriSigner instance
     * @param string                            $globalDefaultTemplate The global default content (it can be a template name or the content)
     * @param string                            $charset
=======
     * @param EngineInterface|Environment $templating            An EngineInterface or a Twig instance
     * @param UriSigner                   $signer                A UriSigner instance
     * @param string                      $globalDefaultTemplate The global default content (it can be a template name or the content)
     * @param string                      $charset
>>>>>>> git-aline/master/master
     */
    public function __construct($templating = null, UriSigner $signer = null, $globalDefaultTemplate = null, $charset = 'utf-8')
    {
        $this->setTemplating($templating);
        $this->globalDefaultTemplate = $globalDefaultTemplate;
        $this->signer = $signer;
        $this->charset = $charset;
    }

    /**
     * Sets the templating engine to use to render the default content.
     *
<<<<<<< HEAD
     * @param EngineInterface|\Twig_Environment|null $templating An EngineInterface or a \Twig_Environment instance
=======
     * @param EngineInterface|Environment|null $templating An EngineInterface or an Environment instance
>>>>>>> git-aline/master/master
     *
     * @throws \InvalidArgumentException
     */
    public function setTemplating($templating)
    {
<<<<<<< HEAD
        if (null !== $templating && !$templating instanceof EngineInterface && !$templating instanceof \Twig_Environment) {
            throw new \InvalidArgumentException('The hinclude rendering strategy needs an instance of \Twig_Environment or Symfony\Component\Templating\EngineInterface');
=======
        if (null !== $templating && !$templating instanceof EngineInterface && !$templating instanceof Environment) {
            throw new \InvalidArgumentException('The hinclude rendering strategy needs an instance of Twig\Environment or Symfony\Component\Templating\EngineInterface');
>>>>>>> git-aline/master/master
        }

        $this->templating = $templating;
    }

    /**
     * Checks if a templating engine has been set.
     *
     * @return bool true if the templating engine has been set, false otherwise
     */
    public function hasTemplating()
    {
        return null !== $this->templating;
    }

    /**
     * {@inheritdoc}
     *
     * Additional available options:
     *
     *  * default:    The default content (it can be a template name or the content)
     *  * id:         An optional hx:include tag id attribute
     *  * attributes: An optional array of hx:include tag attributes
     */
    public function render($uri, Request $request, array $options = array())
    {
        if ($uri instanceof ControllerReference) {
            if (null === $this->signer) {
                throw new \LogicException('You must use a proper URI when using the Hinclude rendering strategy or set a URL signer.');
            }

            // we need to sign the absolute URI, but want to return the path only.
<<<<<<< HEAD
            $uri = substr($this->signer->sign($this->generateFragmentUri($uri, $request, true)), strlen($request->getSchemeAndHttpHost()));
=======
            $uri = substr($this->signer->sign($this->generateFragmentUri($uri, $request, true)), \strlen($request->getSchemeAndHttpHost()));
>>>>>>> git-aline/master/master
        }

        // We need to replace ampersands in the URI with the encoded form in order to return valid html/xml content.
        $uri = str_replace('&', '&amp;', $uri);

        $template = isset($options['default']) ? $options['default'] : $this->globalDefaultTemplate;
        if (null !== $this->templating && $template && $this->templateExists($template)) {
            $content = $this->templating->render($template);
        } else {
            $content = $template;
        }

<<<<<<< HEAD
        $attributes = isset($options['attributes']) && is_array($options['attributes']) ? $options['attributes'] : array();
=======
        $attributes = isset($options['attributes']) && \is_array($options['attributes']) ? $options['attributes'] : array();
>>>>>>> git-aline/master/master
        if (isset($options['id']) && $options['id']) {
            $attributes['id'] = $options['id'];
        }
        $renderedAttributes = '';
<<<<<<< HEAD
        if (count($attributes) > 0) {
            if (PHP_VERSION_ID >= 50400) {
                $flags = ENT_QUOTES | ENT_SUBSTITUTE;
            } else {
                $flags = ENT_QUOTES;
            }
=======
        if (\count($attributes) > 0) {
            $flags = ENT_QUOTES | ENT_SUBSTITUTE;
>>>>>>> git-aline/master/master
            foreach ($attributes as $attribute => $value) {
                $renderedAttributes .= sprintf(
                    ' %s="%s"',
                    htmlspecialchars($attribute, $flags, $this->charset, false),
                    htmlspecialchars($value, $flags, $this->charset, false)
                );
            }
        }

        return new Response(sprintf('<hx:include src="%s"%s>%s</hx:include>', $uri, $renderedAttributes, $content));
    }

    /**
     * @param string $template
     *
     * @return bool
     */
    private function templateExists($template)
    {
        if ($this->templating instanceof EngineInterface) {
            try {
                return $this->templating->exists($template);
<<<<<<< HEAD
            } catch (\InvalidArgumentException $e) {
=======
            } catch (\Exception $e) {
>>>>>>> git-aline/master/master
                return false;
            }
        }

        $loader = $this->templating->getLoader();
<<<<<<< HEAD
        if ($loader instanceof \Twig_ExistsLoaderInterface) {
=======
        if ($loader instanceof ExistsLoaderInterface || method_exists($loader, 'exists')) {
>>>>>>> git-aline/master/master
            return $loader->exists($template);
        }

        try {
<<<<<<< HEAD
            $loader->getSource($template);

            return true;
        } catch (\Twig_Error_Loader $e) {
=======
            if (method_exists($loader, 'getSourceContext')) {
                $loader->getSourceContext($template);
            } else {
                $loader->getSource($template);
            }

            return true;
        } catch (LoaderError $e) {
>>>>>>> git-aline/master/master
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hinclude';
    }
}
