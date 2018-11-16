<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @see       http://github.com/zendframework/zend-diactoros for the canonical source repository
<<<<<<< HEAD
 * @copyright Copyright (c) 2015 Zend Technologies USA Inc. (http://www.zend.com)
=======
 * @copyright Copyright (c) 2015-2016 Zend Technologies USA Inc. (http://www.zend.com)
>>>>>>> git-aline/master/master
 * @license   https://github.com/zendframework/zend-diactoros/blob/master/LICENSE.md New BSD License
 */

namespace Zend\Diactoros;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
<<<<<<< HEAD
=======
use Psr\Http\Message\UriInterface;
>>>>>>> git-aline/master/master

/**
 * HTTP Request encapsulation
 *
 * Requests are considered immutable; all methods that might change state are
 * implemented such that they retain the internal state of the current
 * message and return a new instance that contains the changed state.
 */
class Request implements RequestInterface
{
<<<<<<< HEAD
    use MessageTrait, RequestTrait;

    /**
     * @param null|string $uri URI for the request, if any.
=======
    use RequestTrait;

    /**
     * @param null|string|UriInterface $uri URI for the request, if any.
>>>>>>> git-aline/master/master
     * @param null|string $method HTTP method for the request, if any.
     * @param string|resource|StreamInterface $body Message body, if any.
     * @param array $headers Headers for the message, if any.
     * @throws \InvalidArgumentException for any invalid value.
     */
    public function __construct($uri = null, $method = null, $body = 'php://temp', array $headers = [])
    {
        $this->initialize($uri, $method, $body, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        $headers = $this->headers;
        if (! $this->hasHeader('host')
<<<<<<< HEAD
            && ($this->uri && $this->uri->getHost())
=======
            && $this->uri->getHost()
>>>>>>> git-aline/master/master
        ) {
            $headers['Host'] = [$this->getHostFromUri()];
        }

        return $headers;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($header)
    {
        if (! $this->hasHeader($header)) {
            if (strtolower($header) === 'host'
<<<<<<< HEAD
                && ($this->uri && $this->uri->getHost())
=======
                && $this->uri->getHost()
>>>>>>> git-aline/master/master
            ) {
                return [$this->getHostFromUri()];
            }

            return [];
        }

        $header = $this->headerNames[strtolower($header)];
<<<<<<< HEAD
        $value  = $this->headers[$header];
        $value  = is_array($value) ? $value : [$value];

        return $value;
=======

        return $this->headers[$header];
>>>>>>> git-aline/master/master
    }
}
