<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation;

/**
 * StreamedResponse represents a streamed HTTP response.
 *
 * A StreamedResponse uses a callback for its content.
 *
 * The callback should use the standard PHP functions like echo
 * to stream the response back to the client. The flush() method
 * can also be used if needed.
 *
 * @see flush()
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class StreamedResponse extends Response
{
    protected $callback;
    protected $streamed;
<<<<<<< HEAD

    /**
     * Constructor.
     *
=======
    private $headersSent;

    /**
>>>>>>> git-aline/master/master
     * @param callable|null $callback A valid PHP callback or null to set it later
     * @param int           $status   The response status code
     * @param array         $headers  An array of response headers
     */
<<<<<<< HEAD
    public function __construct($callback = null, $status = 200, $headers = array())
=======
    public function __construct(callable $callback = null, $status = 200, $headers = array())
>>>>>>> git-aline/master/master
    {
        parent::__construct(null, $status, $headers);

        if (null !== $callback) {
            $this->setCallback($callback);
        }
        $this->streamed = false;
<<<<<<< HEAD
=======
        $this->headersSent = false;
>>>>>>> git-aline/master/master
    }

    /**
     * Factory method for chainability.
     *
     * @param callable|null $callback A valid PHP callback or null to set it later
     * @param int           $status   The response status code
     * @param array         $headers  An array of response headers
     *
<<<<<<< HEAD
     * @return StreamedResponse
=======
     * @return static
>>>>>>> git-aline/master/master
     */
    public static function create($callback = null, $status = 200, $headers = array())
    {
        return new static($callback, $status, $headers);
    }

    /**
     * Sets the PHP callback associated with this Response.
     *
     * @param callable $callback A valid PHP callback
     *
<<<<<<< HEAD
     * @throws \LogicException
     */
    public function setCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new \LogicException('The Response callback must be a valid PHP callable.');
        }
        $this->callback = $callback;
=======
     * @return $this
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * This method only sends the headers once.
     *
     * @return $this
     */
    public function sendHeaders()
    {
        if ($this->headersSent) {
            return $this;
        }

        $this->headersSent = true;

        return parent::sendHeaders();
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     *
     * This method only sends the content once.
<<<<<<< HEAD
=======
     *
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function sendContent()
    {
        if ($this->streamed) {
<<<<<<< HEAD
            return;
=======
            return $this;
>>>>>>> git-aline/master/master
        }

        $this->streamed = true;

        if (null === $this->callback) {
            throw new \LogicException('The Response callback must not be null.');
        }

<<<<<<< HEAD
        call_user_func($this->callback);
=======
        \call_user_func($this->callback);

        return $this;
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LogicException when the content is not null
<<<<<<< HEAD
=======
     *
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function setContent($content)
    {
        if (null !== $content) {
            throw new \LogicException('The content cannot be set on a StreamedResponse instance.');
        }
<<<<<<< HEAD
=======

        return $this;
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     *
     * @return false
     */
    public function getContent()
    {
        return false;
    }
<<<<<<< HEAD
=======

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function setNotModified()
    {
        $this->setCallback(function () {});

        return parent::setNotModified();
    }
>>>>>>> git-aline/master/master
}
