<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Serializer\Encoder;

use Symfony\Component\Serializer\Exception\RuntimeException;

/**
 * Decoder delegating the decoding to a chain of decoders.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 * @author Lukas Kahwe Smith <smith@pooteeweet.org>
<<<<<<< HEAD
 */
class ChainDecoder implements DecoderInterface
=======
 *
 * @final since version 3.3.
 */
class ChainDecoder implements DecoderInterface /*, ContextAwareDecoderInterface*/
>>>>>>> git-aline/master/master
{
    protected $decoders = array();
    protected $decoderByFormat = array();

    public function __construct(array $decoders = array())
    {
        $this->decoders = $decoders;
    }

    /**
     * {@inheritdoc}
     */
    final public function decode($data, $format, array $context = array())
    {
<<<<<<< HEAD
        return $this->getDecoder($format)->decode($data, $format, $context);
=======
        return $this->getDecoder($format, $context)->decode($data, $format, $context);
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function supportsDecoding($format)
    {
        try {
            $this->getDecoder($format);
=======
    public function supportsDecoding($format/*, array $context = array()*/)
    {
        $context = \func_num_args() > 1 ? func_get_arg(1) : array();

        try {
            $this->getDecoder($format, $context);
>>>>>>> git-aline/master/master
        } catch (RuntimeException $e) {
            return false;
        }

        return true;
    }

    /**
     * Gets the decoder supporting the format.
     *
     * @param string $format
<<<<<<< HEAD
=======
     * @param array  $context
>>>>>>> git-aline/master/master
     *
     * @return DecoderInterface
     *
     * @throws RuntimeException if no decoder is found
     */
<<<<<<< HEAD
    private function getDecoder($format)
=======
    private function getDecoder($format, array $context)
>>>>>>> git-aline/master/master
    {
        if (isset($this->decoderByFormat[$format])
            && isset($this->decoders[$this->decoderByFormat[$format]])
        ) {
            return $this->decoders[$this->decoderByFormat[$format]];
        }

        foreach ($this->decoders as $i => $decoder) {
<<<<<<< HEAD
            if ($decoder->supportsDecoding($format)) {
=======
            if ($decoder->supportsDecoding($format, $context)) {
>>>>>>> git-aline/master/master
                $this->decoderByFormat[$format] = $i;

                return $decoder;
            }
        }

        throw new RuntimeException(sprintf('No decoder found for format "%s".', $format));
    }
}
