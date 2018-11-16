<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Process\Pipes;

use Symfony\Component\Process\Process;

/**
 * UnixPipes implementation uses unix pipes as handles.
 *
 * @author Romain Neutron <imprec@gmail.com>
 *
 * @internal
 */
class UnixPipes extends AbstractPipes
{
<<<<<<< HEAD
    /** @var bool */
    private $ttyMode;
    /** @var bool */
    private $ptyMode;
    /** @var bool */
    private $disableOutput;

    public function __construct($ttyMode, $ptyMode, $input, $disableOutput)
    {
        $this->ttyMode = (bool) $ttyMode;
        $this->ptyMode = (bool) $ptyMode;
        $this->disableOutput = (bool) $disableOutput;

        if (is_resource($input)) {
            $this->input = $input;
        } else {
            $this->inputBuffer = (string) $input;
        }
=======
    private $ttyMode;
    private $ptyMode;
    private $haveReadSupport;

    public function __construct($ttyMode, $ptyMode, $input, $haveReadSupport)
    {
        $this->ttyMode = (bool) $ttyMode;
        $this->ptyMode = (bool) $ptyMode;
        $this->haveReadSupport = (bool) $haveReadSupport;

        parent::__construct($input);
>>>>>>> git-aline/master/master
    }

    public function __destruct()
    {
        $this->close();
    }

    /**
     * {@inheritdoc}
     */
    public function getDescriptors()
    {
<<<<<<< HEAD
        if ($this->disableOutput) {
=======
        if (!$this->haveReadSupport) {
>>>>>>> git-aline/master/master
            $nullstream = fopen('/dev/null', 'c');

            return array(
                array('pipe', 'r'),
                $nullstream,
                $nullstream,
            );
        }

        if ($this->ttyMode) {
            return array(
                array('file', '/dev/tty', 'r'),
                array('file', '/dev/tty', 'w'),
                array('file', '/dev/tty', 'w'),
            );
        }

        if ($this->ptyMode && Process::isPtySupported()) {
            return array(
                array('pty'),
                array('pty'),
                array('pty'),
            );
        }

        return array(
            array('pipe', 'r'),
            array('pipe', 'w'), // stdout
            array('pipe', 'w'), // stderr
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFiles()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function readAndWrite($blocking, $close = false)
    {
<<<<<<< HEAD
        // only stdin is left open, job has been done !
        // we can now close it
        if (1 === count($this->pipes) && array(0) === array_keys($this->pipes)) {
            fclose($this->pipes[0]);
            unset($this->pipes[0]);
        }

        if (empty($this->pipes)) {
            return array();
        }

        $this->unblock();

        $read = array();

        if (null !== $this->input) {
            // if input is a resource, let's add it to stream_select argument to
            // fill a buffer
            $r = array_merge($this->pipes, array('input' => $this->input));
        } else {
            $r = $this->pipes;
        }
        // discard read on stdin
        unset($r[0]);

        $w = isset($this->pipes[0]) ? array($this->pipes[0]) : null;
        $e = null;

        // let's have a look if something changed in streams
        if (false === $n = @stream_select($r, $w, $e, 0, $blocking ? Process::TIMEOUT_PRECISION * 1E6 : 0)) {
=======
        $this->unblock();
        $w = $this->write();

        $read = $e = array();
        $r = $this->pipes;
        unset($r[0]);

        // let's have a look if something changed in streams
        set_error_handler(array($this, 'handleError'));
        if (($r || $w) && false === stream_select($r, $w, $e, 0, $blocking ? Process::TIMEOUT_PRECISION * 1E6 : 0)) {
            restore_error_handler();
>>>>>>> git-aline/master/master
            // if a system call has been interrupted, forget about it, let's try again
            // otherwise, an error occurred, let's reset pipes
            if (!$this->hasSystemCallBeenInterrupted()) {
                $this->pipes = array();
            }

            return $read;
        }
<<<<<<< HEAD

        // nothing has changed
        if (0 === $n) {
            return $read;
        }
=======
        restore_error_handler();
>>>>>>> git-aline/master/master

        foreach ($r as $pipe) {
            // prior PHP 5.4 the array passed to stream_select is modified and
            // lose key association, we have to find back the key
<<<<<<< HEAD
            $type = (false !== $found = array_search($pipe, $this->pipes)) ? $found : 'input';
            $data = '';
            while ('' !== $dataread = (string) fread($pipe, self::CHUNK_SIZE)) {
                $data .= $dataread;
            }

            if ('' !== $data) {
                if ($type === 'input') {
                    $this->inputBuffer .= $data;
                } else {
                    $read[$type] = $data;
                }
            }

            if (false === $data || (true === $close && feof($pipe) && '' === $data)) {
                if ($type === 'input') {
                    // no more data to read on input resource
                    // use an empty buffer in the next reads
                    $this->input = null;
                } else {
                    fclose($this->pipes[$type]);
                    unset($this->pipes[$type]);
                }
            }
        }

        if (null !== $w && 0 < count($w)) {
            while (strlen($this->inputBuffer)) {
                $written = fwrite($w[0], $this->inputBuffer, 2 << 18); // write 512k
                if ($written > 0) {
                    $this->inputBuffer = (string) substr($this->inputBuffer, $written);
                } else {
                    break;
                }
            }
        }

        // no input to read on resource, buffer is empty and stdin still open
        if ('' === $this->inputBuffer && null === $this->input && isset($this->pipes[0])) {
            fclose($this->pipes[0]);
            unset($this->pipes[0]);
        }

=======
            $read[$type = array_search($pipe, $this->pipes, true)] = '';

            do {
                $data = fread($pipe, self::CHUNK_SIZE);
                $read[$type] .= $data;
            } while (isset($data[0]) && ($close || isset($data[self::CHUNK_SIZE - 1])));

            if (!isset($read[$type][0])) {
                unset($read[$type]);
            }

            if ($close && feof($pipe)) {
                fclose($pipe);
                unset($this->pipes[$type]);
            }
        }

>>>>>>> git-aline/master/master
        return $read;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function areOpen()
    {
        return (bool) $this->pipes;
    }

    /**
     * Creates a new UnixPipes instance.
     *
     * @param Process         $process
     * @param string|resource $input
     *
     * @return UnixPipes
     */
    public static function create(Process $process, $input)
    {
        return new static($process->isTty(), $process->isPty(), $input, $process->isOutputDisabled());
=======
    public function haveReadSupport()
    {
        return $this->haveReadSupport;
    }

    /**
     * {@inheritdoc}
     */
    public function areOpen()
    {
        return (bool) $this->pipes;
>>>>>>> git-aline/master/master
    }
}
