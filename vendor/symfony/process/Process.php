<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Process;

use Symfony\Component\Process\Exception\InvalidArgumentException;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Pipes\PipesInterface;
use Symfony\Component\Process\Pipes\UnixPipes;
use Symfony\Component\Process\Pipes\WindowsPipes;

/**
 * Process is a thin wrapper around proc_* functions to easily
 * start independent PHP processes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Romain Neutron <imprec@gmail.com>
 */
<<<<<<< HEAD
class Process
=======
class Process implements \IteratorAggregate
>>>>>>> git-aline/master/master
{
    const ERR = 'err';
    const OUT = 'out';

    const STATUS_READY = 'ready';
    const STATUS_STARTED = 'started';
    const STATUS_TERMINATED = 'terminated';

    const STDIN = 0;
    const STDOUT = 1;
    const STDERR = 2;

    // Timeout Precision in seconds.
    const TIMEOUT_PRECISION = 0.2;

<<<<<<< HEAD
    private $callback;
=======
    const ITER_NON_BLOCKING = 1; // By default, iterating over outputs is a blocking call, use this flag to make it non-blocking
    const ITER_KEEP_OUTPUT = 2;  // By default, outputs are cleared while iterating, use this flag to keep them in memory
    const ITER_SKIP_OUT = 4;     // Use this flag to skip STDOUT while iterating
    const ITER_SKIP_ERR = 8;     // Use this flag to skip STDERR while iterating

    private $callback;
    private $hasCallback = false;
>>>>>>> git-aline/master/master
    private $commandline;
    private $cwd;
    private $env;
    private $input;
    private $starttime;
    private $lastOutputTime;
    private $timeout;
    private $idleTimeout;
<<<<<<< HEAD
    private $options;
    private $exitcode;
    private $fallbackExitcode;
=======
    private $options = array('suppress_errors' => true);
    private $exitcode;
    private $fallbackStatus = array();
>>>>>>> git-aline/master/master
    private $processInformation;
    private $outputDisabled = false;
    private $stdout;
    private $stderr;
    private $enhanceWindowsCompatibility = true;
    private $enhanceSigchildCompatibility;
    private $process;
    private $status = self::STATUS_READY;
    private $incrementalOutputOffset = 0;
    private $incrementalErrorOutputOffset = 0;
    private $tty;
    private $pty;
<<<<<<< HEAD
=======
    private $inheritEnv = false;
>>>>>>> git-aline/master/master

    private $useFileHandles = false;
    /** @var PipesInterface */
    private $processPipes;

    private $latestSignal;

    private static $sigchild;

    /**
     * Exit codes translation table.
     *
     * User-defined errors must use exit codes in the 64-113 range.
<<<<<<< HEAD
     *
     * @var array
=======
>>>>>>> git-aline/master/master
     */
    public static $exitCodes = array(
        0 => 'OK',
        1 => 'General error',
        2 => 'Misuse of shell builtins',

        126 => 'Invoked command cannot execute',
        127 => 'Command not found',
        128 => 'Invalid exit argument',

        // signals
        129 => 'Hangup',
        130 => 'Interrupt',
        131 => 'Quit and dump core',
        132 => 'Illegal instruction',
        133 => 'Trace/breakpoint trap',
        134 => 'Process aborted',
        135 => 'Bus error: "access to undefined portion of memory object"',
        136 => 'Floating point exception: "erroneous arithmetic operation"',
        137 => 'Kill (terminate immediately)',
        138 => 'User-defined 1',
        139 => 'Segmentation violation',
        140 => 'User-defined 2',
        141 => 'Write to pipe with no one reading',
        142 => 'Signal raised by alarm',
        143 => 'Termination (request to terminate)',
        // 144 - not defined
        145 => 'Child process terminated, stopped (or continued*)',
        146 => 'Continue if stopped',
        147 => 'Stop executing temporarily',
        148 => 'Terminal stop signal',
        149 => 'Background process attempting to read from tty ("in")',
        150 => 'Background process attempting to write to tty ("out")',
        151 => 'Urgent data available on socket',
        152 => 'CPU time limit exceeded',
        153 => 'File size limit exceeded',
        154 => 'Signal raised by timer counting virtual time: "virtual timer expired"',
        155 => 'Profiling timer expired',
        // 156 - not defined
        157 => 'Pollable event',
        // 158 - not defined
        159 => 'Bad syscall',
    );

    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param string         $commandline The command line to run
     * @param string|null    $cwd         The working directory or null to use the working dir of the current PHP process
     * @param array|null     $env         The environment variables or null to use the same environment as the current PHP process
     * @param string|null    $input       The input
=======
     * @param string|array   $commandline The command line to run
     * @param string|null    $cwd         The working directory or null to use the working dir of the current PHP process
     * @param array|null     $env         The environment variables or null to use the same environment as the current PHP process
     * @param mixed|null     $input       The input as stream resource, scalar or \Traversable, or null for no input
>>>>>>> git-aline/master/master
     * @param int|float|null $timeout     The timeout in seconds or null to disable
     * @param array          $options     An array of options for proc_open
     *
     * @throws RuntimeException When proc_open is not installed
     */
<<<<<<< HEAD
    public function __construct($commandline, $cwd = null, array $env = null, $input = null, $timeout = 60, array $options = array())
    {
        if (!function_exists('proc_open')) {
=======
    public function __construct($commandline, $cwd = null, array $env = null, $input = null, $timeout = 60, array $options = null)
    {
        if (!\function_exists('proc_open')) {
>>>>>>> git-aline/master/master
            throw new RuntimeException('The Process class relies on proc_open, which is not available on your PHP installation.');
        }

        $this->commandline = $commandline;
        $this->cwd = $cwd;

        // on Windows, if the cwd changed via chdir(), proc_open defaults to the dir where PHP was started
        // on Gnu/Linux, PHP builds with --enable-maintainer-zts are also affected
        // @see : https://bugs.php.net/bug.php?id=51800
        // @see : https://bugs.php.net/bug.php?id=50524
<<<<<<< HEAD
        if (null === $this->cwd && (defined('ZEND_THREAD_SAFE') || '\\' === DIRECTORY_SEPARATOR)) {
=======
        if (null === $this->cwd && (\defined('ZEND_THREAD_SAFE') || '\\' === \DIRECTORY_SEPARATOR)) {
>>>>>>> git-aline/master/master
            $this->cwd = getcwd();
        }
        if (null !== $env) {
            $this->setEnv($env);
        }

<<<<<<< HEAD
        $this->input = $input;
        $this->setTimeout($timeout);
        $this->useFileHandles = '\\' === DIRECTORY_SEPARATOR;
        $this->pty = false;
        $this->enhanceWindowsCompatibility = true;
        $this->enhanceSigchildCompatibility = '\\' !== DIRECTORY_SEPARATOR && $this->isSigchildEnabled();
        $this->options = array_replace(array('suppress_errors' => true, 'binary_pipes' => true), $options);
=======
        $this->setInput($input);
        $this->setTimeout($timeout);
        $this->useFileHandles = '\\' === \DIRECTORY_SEPARATOR;
        $this->pty = false;
        $this->enhanceSigchildCompatibility = '\\' !== \DIRECTORY_SEPARATOR && $this->isSigchildEnabled();
        if (null !== $options) {
            @trigger_error(sprintf('The $options parameter of the %s constructor is deprecated since Symfony 3.3 and will be removed in 4.0.', __CLASS__), E_USER_DEPRECATED);
            $this->options = array_replace($this->options, $options);
        }
>>>>>>> git-aline/master/master
    }

    public function __destruct()
    {
<<<<<<< HEAD
        // stop() will check if we have a process running.
        $this->stop();
=======
        $this->stop(0);
>>>>>>> git-aline/master/master
    }

    public function __clone()
    {
        $this->resetProcessData();
    }

    /**
     * Runs the process.
     *
     * The callback receives the type of output (out or err) and
     * some bytes from the output in real-time. It allows to have feedback
     * from the independent process during execution.
     *
     * The STDOUT and STDERR are also available after the process is finished
     * via the getOutput() and getErrorOutput() methods.
     *
     * @param callable|null $callback A PHP callback to run whenever there is some
     *                                output available on STDOUT or STDERR
<<<<<<< HEAD
=======
     * @param array         $env      An array of additional env vars to set when running the process
>>>>>>> git-aline/master/master
     *
     * @return int The exit status code
     *
     * @throws RuntimeException When process can't be launched
     * @throws RuntimeException When process stopped after receiving signal
     * @throws LogicException   In case a callback is provided and output has been disabled
<<<<<<< HEAD
     */
    public function run($callback = null)
    {
        $this->start($callback);
=======
     *
     * @final since version 3.3
     */
    public function run($callback = null/*, array $env = array()*/)
    {
        $env = 1 < \func_num_args() ? func_get_arg(1) : null;
        $this->start($callback, $env);
>>>>>>> git-aline/master/master

        return $this->wait();
    }

    /**
     * Runs the process.
     *
     * This is identical to run() except that an exception is thrown if the process
     * exits with a non-zero exit code.
     *
     * @param callable|null $callback
<<<<<<< HEAD
=======
     * @param array         $env      An array of additional env vars to set when running the process
>>>>>>> git-aline/master/master
     *
     * @return self
     *
     * @throws RuntimeException       if PHP was compiled with --enable-sigchild and the enhanced sigchild compatibility mode is not enabled
     * @throws ProcessFailedException if the process didn't terminate successfully
<<<<<<< HEAD
     */
    public function mustRun($callback = null)
    {
        if ($this->isSigchildEnabled() && !$this->enhanceSigchildCompatibility) {
            throw new RuntimeException('This PHP has been compiled with --enable-sigchild. You must use setEnhanceSigchildCompatibility() to use this method.');
        }

        if (0 !== $this->run($callback)) {
=======
     *
     * @final since version 3.3
     */
    public function mustRun(callable $callback = null/*, array $env = array()*/)
    {
        if (!$this->enhanceSigchildCompatibility && $this->isSigchildEnabled()) {
            throw new RuntimeException('This PHP has been compiled with --enable-sigchild. You must use setEnhanceSigchildCompatibility() to use this method.');
        }
        $env = 1 < \func_num_args() ? func_get_arg(1) : null;

        if (0 !== $this->run($callback, $env)) {
>>>>>>> git-aline/master/master
            throw new ProcessFailedException($this);
        }

        return $this;
    }

    /**
     * Starts the process and returns after writing the input to STDIN.
     *
     * This method blocks until all STDIN data is sent to the process then it
     * returns while the process runs in the background.
     *
     * The termination of the process can be awaited with wait().
     *
     * The callback receives the type of output (out or err) and some bytes from
     * the output in real-time while writing the standard input to the process.
     * It allows to have feedback from the independent process during execution.
<<<<<<< HEAD
     * If there is no callback passed, the wait() method can be called
     * with true as a second parameter then the callback will get all data occurred
     * in (and since) the start call.
     *
     * @param callable|null $callback A PHP callback to run whenever there is some
     *                                output available on STDOUT or STDERR
=======
     *
     * @param callable|null $callback A PHP callback to run whenever there is some
     *                                output available on STDOUT or STDERR
     * @param array         $env      An array of additional env vars to set when running the process
>>>>>>> git-aline/master/master
     *
     * @throws RuntimeException When process can't be launched
     * @throws RuntimeException When process is already running
     * @throws LogicException   In case a callback is provided and output has been disabled
     */
<<<<<<< HEAD
    public function start($callback = null)
=======
    public function start(callable $callback = null/*, array $env = array()*/)
>>>>>>> git-aline/master/master
    {
        if ($this->isRunning()) {
            throw new RuntimeException('Process is already running');
        }
<<<<<<< HEAD
        if ($this->outputDisabled && null !== $callback) {
            throw new LogicException('Output has been disabled, enable it to allow the use of a callback.');
=======
        if (2 <= \func_num_args()) {
            $env = func_get_arg(1);
        } else {
            if (__CLASS__ !== static::class) {
                $r = new \ReflectionMethod($this, __FUNCTION__);
                if (__CLASS__ !== $r->getDeclaringClass()->getName() && (2 > $r->getNumberOfParameters() || 'env' !== $r->getParameters()[1]->name)) {
                    @trigger_error(sprintf('The %s::start() method expects a second "$env" argument since Symfony 3.3. It will be made mandatory in 4.0.', static::class), E_USER_DEPRECATED);
                }
            }
            $env = null;
>>>>>>> git-aline/master/master
        }

        $this->resetProcessData();
        $this->starttime = $this->lastOutputTime = microtime(true);
        $this->callback = $this->buildCallback($callback);
<<<<<<< HEAD
        $descriptors = $this->getDescriptors();

        $commandline = $this->commandline;

        if ('\\' === DIRECTORY_SEPARATOR && $this->enhanceWindowsCompatibility) {
            $commandline = 'cmd /V:ON /E:ON /D /C "('.$commandline.')';
            foreach ($this->processPipes->getFiles() as $offset => $filename) {
                $commandline .= ' '.$offset.'>'.ProcessUtils::escapeArgument($filename);
            }
            $commandline .= '"';

            if (!isset($this->options['bypass_shell'])) {
                $this->options['bypass_shell'] = true;
            }
        }

        $this->process = proc_open($commandline, $descriptors, $this->processPipes->pipes, $this->cwd, $this->env, $this->options);

        if (!is_resource($this->process)) {
=======
        $this->hasCallback = null !== $callback;
        $descriptors = $this->getDescriptors();
        $inheritEnv = $this->inheritEnv;

        if (\is_array($commandline = $this->commandline)) {
            $commandline = implode(' ', array_map(array($this, 'escapeArgument'), $commandline));

            if ('\\' !== \DIRECTORY_SEPARATOR) {
                // exec is mandatory to deal with sending a signal to the process
                $commandline = 'exec '.$commandline;
            }
        }

        if (null === $env) {
            $env = $this->env;
        } else {
            if ($this->env) {
                $env += $this->env;
            }
            $inheritEnv = true;
        }

        if (null !== $env && $inheritEnv) {
            $env += $this->getDefaultEnv();
        } elseif (null !== $env) {
            @trigger_error('Not inheriting environment variables is deprecated since Symfony 3.3 and will always happen in 4.0. Set "Process::inheritEnvironmentVariables()" to true instead.', E_USER_DEPRECATED);
        } else {
            $env = $this->getDefaultEnv();
        }
        if ('\\' === \DIRECTORY_SEPARATOR && $this->enhanceWindowsCompatibility) {
            $this->options['bypass_shell'] = true;
            $commandline = $this->prepareWindowsCommandLine($commandline, $env);
        } elseif (!$this->useFileHandles && $this->enhanceSigchildCompatibility && $this->isSigchildEnabled()) {
            // last exit code is output on the fourth pipe and caught to work around --enable-sigchild
            $descriptors[3] = array('pipe', 'w');

            // See https://unix.stackexchange.com/questions/71205/background-process-pipe-input
            $commandline = '{ ('.$commandline.') <&3 3<&- 3>/dev/null & } 3<&0;';
            $commandline .= 'pid=$!; echo $pid >&3; wait $pid; code=$?; echo $code >&3; exit $code';

            // Workaround for the bug, when PTS functionality is enabled.
            // @see : https://bugs.php.net/69442
            $ptsWorkaround = fopen(__FILE__, 'r');
        }
        if (\defined('HHVM_VERSION')) {
            $envPairs = $env;
        } else {
            $envPairs = array();
            foreach ($env as $k => $v) {
                if (false !== $v) {
                    $envPairs[] = $k.'='.$v;
                }
            }
        }

        if (!is_dir($this->cwd)) {
            @trigger_error('The provided cwd does not exist. Command is currently ran against getcwd(). This behavior is deprecated since Symfony 3.4 and will be removed in 4.0.', E_USER_DEPRECATED);
        }

        $this->process = proc_open($commandline, $descriptors, $this->processPipes->pipes, $this->cwd, $envPairs, $this->options);

        if (!\is_resource($this->process)) {
>>>>>>> git-aline/master/master
            throw new RuntimeException('Unable to launch a new process.');
        }
        $this->status = self::STATUS_STARTED;

<<<<<<< HEAD
=======
        if (isset($descriptors[3])) {
            $this->fallbackStatus['pid'] = (int) fgets($this->processPipes->pipes[3]);
        }

>>>>>>> git-aline/master/master
        if ($this->tty) {
            return;
        }

        $this->updateStatus(false);
        $this->checkTimeout();
    }

    /**
     * Restarts the process.
     *
     * Be warned that the process is cloned before being started.
     *
     * @param callable|null $callback A PHP callback to run whenever there is some
     *                                output available on STDOUT or STDERR
<<<<<<< HEAD
     *
     * @return Process The new process
=======
     * @param array         $env      An array of additional env vars to set when running the process
     *
     * @return $this
>>>>>>> git-aline/master/master
     *
     * @throws RuntimeException When process can't be launched
     * @throws RuntimeException When process is already running
     *
     * @see start()
<<<<<<< HEAD
     */
    public function restart($callback = null)
=======
     *
     * @final since version 3.3
     */
    public function restart(callable $callback = null/*, array $env = array()*/)
>>>>>>> git-aline/master/master
    {
        if ($this->isRunning()) {
            throw new RuntimeException('Process is already running');
        }
<<<<<<< HEAD

        $process = clone $this;
        $process->start($callback);
=======
        $env = 1 < \func_num_args() ? func_get_arg(1) : null;

        $process = clone $this;
        $process->start($callback, $env);
>>>>>>> git-aline/master/master

        return $process;
    }

    /**
     * Waits for the process to terminate.
     *
     * The callback receives the type of output (out or err) and some bytes
     * from the output in real-time while writing the standard input to the process.
     * It allows to have feedback from the independent process during execution.
     *
     * @param callable|null $callback A valid PHP callback
     *
     * @return int The exitcode of the process
     *
     * @throws RuntimeException When process timed out
     * @throws RuntimeException When process stopped after receiving signal
     * @throws LogicException   When process is not yet started
     */
<<<<<<< HEAD
    public function wait($callback = null)
=======
    public function wait(callable $callback = null)
>>>>>>> git-aline/master/master
    {
        $this->requireProcessIsStarted(__FUNCTION__);

        $this->updateStatus(false);
<<<<<<< HEAD
        if (null !== $callback) {
=======

        if (null !== $callback) {
            if (!$this->processPipes->haveReadSupport()) {
                $this->stop(0);
                throw new \LogicException('Pass the callback to the Process::start method or enableOutput to use a callback with Process::wait');
            }
>>>>>>> git-aline/master/master
            $this->callback = $this->buildCallback($callback);
        }

        do {
            $this->checkTimeout();
<<<<<<< HEAD
            $running = '\\' === DIRECTORY_SEPARATOR ? $this->isRunning() : $this->processPipes->areOpen();
            $close = '\\' !== DIRECTORY_SEPARATOR || !$running;
            $this->readPipes(true, $close);
=======
            $running = '\\' === \DIRECTORY_SEPARATOR ? $this->isRunning() : $this->processPipes->areOpen();
            $this->readPipes($running, '\\' !== \DIRECTORY_SEPARATOR || !$running);
>>>>>>> git-aline/master/master
        } while ($running);

        while ($this->isRunning()) {
            usleep(1000);
        }

        if ($this->processInformation['signaled'] && $this->processInformation['termsig'] !== $this->latestSignal) {
            throw new RuntimeException(sprintf('The process has been signaled with signal "%s".', $this->processInformation['termsig']));
        }

        return $this->exitcode;
    }

    /**
     * Returns the Pid (process identifier), if applicable.
     *
     * @return int|null The process id if running, null otherwise
<<<<<<< HEAD
     *
     * @throws RuntimeException In case --enable-sigchild is activated
     */
    public function getPid()
    {
        if ($this->isSigchildEnabled()) {
            throw new RuntimeException('This PHP has been compiled with --enable-sigchild. The process identifier can not be retrieved.');
        }

        $this->updateStatus(false);

=======
     */
    public function getPid()
    {
>>>>>>> git-aline/master/master
        return $this->isRunning() ? $this->processInformation['pid'] : null;
    }

    /**
     * Sends a POSIX signal to the process.
     *
     * @param int $signal A valid POSIX signal (see http://www.php.net/manual/en/pcntl.constants.php)
     *
<<<<<<< HEAD
     * @return Process
     *
     * @throws LogicException   In case the process is not running
     * @throws RuntimeException In case --enable-sigchild is activated
=======
     * @return $this
     *
     * @throws LogicException   In case the process is not running
     * @throws RuntimeException In case --enable-sigchild is activated and the process can't be killed
>>>>>>> git-aline/master/master
     * @throws RuntimeException In case of failure
     */
    public function signal($signal)
    {
        $this->doSignal($signal, true);

        return $this;
    }

    /**
     * Disables fetching output and error output from the underlying process.
     *
<<<<<<< HEAD
     * @return Process
=======
     * @return $this
>>>>>>> git-aline/master/master
     *
     * @throws RuntimeException In case the process is already running
     * @throws LogicException   if an idle timeout is set
     */
    public function disableOutput()
    {
        if ($this->isRunning()) {
            throw new RuntimeException('Disabling output while the process is running is not possible.');
        }
        if (null !== $this->idleTimeout) {
            throw new LogicException('Output can not be disabled while an idle timeout is set.');
        }

        $this->outputDisabled = true;

        return $this;
    }

    /**
     * Enables fetching output and error output from the underlying process.
     *
<<<<<<< HEAD
     * @return Process
=======
     * @return $this
>>>>>>> git-aline/master/master
     *
     * @throws RuntimeException In case the process is already running
     */
    public function enableOutput()
    {
        if ($this->isRunning()) {
            throw new RuntimeException('Enabling output while the process is running is not possible.');
        }

        $this->outputDisabled = false;

        return $this;
    }

    /**
     * Returns true in case the output is disabled, false otherwise.
     *
     * @return bool
     */
    public function isOutputDisabled()
    {
        return $this->outputDisabled;
    }

    /**
     * Returns the current output of the process (STDOUT).
     *
     * @return string The process output
     *
     * @throws LogicException in case the output has been disabled
     * @throws LogicException In case the process is not started
     */
    public function getOutput()
    {
<<<<<<< HEAD
        if ($this->outputDisabled) {
            throw new LogicException('Output has been disabled.');
        }

        $this->requireProcessIsStarted(__FUNCTION__);

        $this->readPipes(false, '\\' === DIRECTORY_SEPARATOR ? !$this->processInformation['running'] : true);

        return $this->stdout;
=======
        $this->readPipesForOutput(__FUNCTION__);

        if (false === $ret = stream_get_contents($this->stdout, -1, 0)) {
            return '';
        }

        return $ret;
>>>>>>> git-aline/master/master
    }

    /**
     * Returns the output incrementally.
     *
     * In comparison with the getOutput method which always return the whole
     * output, this one returns the new output since the last call.
     *
<<<<<<< HEAD
     * @throws LogicException in case the output has been disabled
     * @throws LogicException In case the process is not started
     *
     * @return string The process output since the last call
     */
    public function getIncrementalOutput()
    {
        $this->requireProcessIsStarted(__FUNCTION__);

        $data = $this->getOutput();

        $latest = substr($data, $this->incrementalOutputOffset);
=======
     * @return string The process output since the last call
     *
     * @throws LogicException in case the output has been disabled
     * @throws LogicException In case the process is not started
     */
    public function getIncrementalOutput()
    {
        $this->readPipesForOutput(__FUNCTION__);

        $latest = stream_get_contents($this->stdout, -1, $this->incrementalOutputOffset);
        $this->incrementalOutputOffset = ftell($this->stdout);
>>>>>>> git-aline/master/master

        if (false === $latest) {
            return '';
        }

<<<<<<< HEAD
        $this->incrementalOutputOffset = strlen($data);

=======
>>>>>>> git-aline/master/master
        return $latest;
    }

    /**
<<<<<<< HEAD
     * Clears the process output.
     *
     * @return Process
     */
    public function clearOutput()
    {
        $this->stdout = '';
=======
     * Returns an iterator to the output of the process, with the output type as keys (Process::OUT/ERR).
     *
     * @param int $flags A bit field of Process::ITER_* flags
     *
     * @throws LogicException in case the output has been disabled
     * @throws LogicException In case the process is not started
     *
     * @return \Generator
     */
    public function getIterator($flags = 0)
    {
        $this->readPipesForOutput(__FUNCTION__, false);

        $clearOutput = !(self::ITER_KEEP_OUTPUT & $flags);
        $blocking = !(self::ITER_NON_BLOCKING & $flags);
        $yieldOut = !(self::ITER_SKIP_OUT & $flags);
        $yieldErr = !(self::ITER_SKIP_ERR & $flags);

        while (null !== $this->callback || ($yieldOut && !feof($this->stdout)) || ($yieldErr && !feof($this->stderr))) {
            if ($yieldOut) {
                $out = stream_get_contents($this->stdout, -1, $this->incrementalOutputOffset);

                if (isset($out[0])) {
                    if ($clearOutput) {
                        $this->clearOutput();
                    } else {
                        $this->incrementalOutputOffset = ftell($this->stdout);
                    }

                    yield self::OUT => $out;
                }
            }

            if ($yieldErr) {
                $err = stream_get_contents($this->stderr, -1, $this->incrementalErrorOutputOffset);

                if (isset($err[0])) {
                    if ($clearOutput) {
                        $this->clearErrorOutput();
                    } else {
                        $this->incrementalErrorOutputOffset = ftell($this->stderr);
                    }

                    yield self::ERR => $err;
                }
            }

            if (!$blocking && !isset($out[0]) && !isset($err[0])) {
                yield self::OUT => '';
            }

            $this->checkTimeout();
            $this->readPipesForOutput(__FUNCTION__, $blocking);
        }
    }

    /**
     * Clears the process output.
     *
     * @return $this
     */
    public function clearOutput()
    {
        ftruncate($this->stdout, 0);
        fseek($this->stdout, 0);
>>>>>>> git-aline/master/master
        $this->incrementalOutputOffset = 0;

        return $this;
    }

    /**
     * Returns the current error output of the process (STDERR).
     *
     * @return string The process error output
     *
     * @throws LogicException in case the output has been disabled
     * @throws LogicException In case the process is not started
     */
    public function getErrorOutput()
    {
<<<<<<< HEAD
        if ($this->outputDisabled) {
            throw new LogicException('Output has been disabled.');
        }

        $this->requireProcessIsStarted(__FUNCTION__);

        $this->readPipes(false, '\\' === DIRECTORY_SEPARATOR ? !$this->processInformation['running'] : true);

        return $this->stderr;
=======
        $this->readPipesForOutput(__FUNCTION__);

        if (false === $ret = stream_get_contents($this->stderr, -1, 0)) {
            return '';
        }

        return $ret;
>>>>>>> git-aline/master/master
    }

    /**
     * Returns the errorOutput incrementally.
     *
     * In comparison with the getErrorOutput method which always return the
     * whole error output, this one returns the new error output since the last
     * call.
     *
<<<<<<< HEAD
     * @throws LogicException in case the output has been disabled
     * @throws LogicException In case the process is not started
     *
     * @return string The process error output since the last call
     */
    public function getIncrementalErrorOutput()
    {
        $this->requireProcessIsStarted(__FUNCTION__);

        $data = $this->getErrorOutput();

        $latest = substr($data, $this->incrementalErrorOutputOffset);
=======
     * @return string The process error output since the last call
     *
     * @throws LogicException in case the output has been disabled
     * @throws LogicException In case the process is not started
     */
    public function getIncrementalErrorOutput()
    {
        $this->readPipesForOutput(__FUNCTION__);

        $latest = stream_get_contents($this->stderr, -1, $this->incrementalErrorOutputOffset);
        $this->incrementalErrorOutputOffset = ftell($this->stderr);
>>>>>>> git-aline/master/master

        if (false === $latest) {
            return '';
        }

<<<<<<< HEAD
        $this->incrementalErrorOutputOffset = strlen($data);

=======
>>>>>>> git-aline/master/master
        return $latest;
    }

    /**
     * Clears the process output.
     *
<<<<<<< HEAD
     * @return Process
     */
    public function clearErrorOutput()
    {
        $this->stderr = '';
=======
     * @return $this
     */
    public function clearErrorOutput()
    {
        ftruncate($this->stderr, 0);
        fseek($this->stderr, 0);
>>>>>>> git-aline/master/master
        $this->incrementalErrorOutputOffset = 0;

        return $this;
    }

    /**
     * Returns the exit code returned by the process.
     *
     * @return null|int The exit status code, null if the Process is not terminated
     *
     * @throws RuntimeException In case --enable-sigchild is activated and the sigchild compatibility mode is disabled
     */
    public function getExitCode()
    {
<<<<<<< HEAD
        if ($this->isSigchildEnabled() && !$this->enhanceSigchildCompatibility) {
=======
        if (!$this->enhanceSigchildCompatibility && $this->isSigchildEnabled()) {
>>>>>>> git-aline/master/master
            throw new RuntimeException('This PHP has been compiled with --enable-sigchild. You must use setEnhanceSigchildCompatibility() to use this method.');
        }

        $this->updateStatus(false);

        return $this->exitcode;
    }

    /**
     * Returns a string representation for the exit code returned by the process.
     *
     * This method relies on the Unix exit code status standardization
     * and might not be relevant for other operating systems.
     *
<<<<<<< HEAD
     * @return null|string A string representation for the exit status code, null if the Process is not terminated.
     *
     * @throws RuntimeException In case --enable-sigchild is activated and the sigchild compatibility mode is disabled
=======
     * @return null|string A string representation for the exit status code, null if the Process is not terminated
>>>>>>> git-aline/master/master
     *
     * @see http://tldp.org/LDP/abs/html/exitcodes.html
     * @see http://en.wikipedia.org/wiki/Unix_signal
     */
    public function getExitCodeText()
    {
        if (null === $exitcode = $this->getExitCode()) {
            return;
        }

        return isset(self::$exitCodes[$exitcode]) ? self::$exitCodes[$exitcode] : 'Unknown error';
    }

    /**
     * Checks if the process ended successfully.
     *
     * @return bool true if the process ended successfully, false otherwise
     */
    public function isSuccessful()
    {
        return 0 === $this->getExitCode();
    }

    /**
     * Returns true if the child process has been terminated by an uncaught signal.
     *
     * It always returns false on Windows.
     *
     * @return bool
     *
     * @throws RuntimeException In case --enable-sigchild is activated
     * @throws LogicException   In case the process is not terminated
     */
    public function hasBeenSignaled()
    {
        $this->requireProcessIsTerminated(__FUNCTION__);

<<<<<<< HEAD
        if ($this->isSigchildEnabled()) {
            throw new RuntimeException('This PHP has been compiled with --enable-sigchild. Term signal can not be retrieved.');
        }

        $this->updateStatus(false);

=======
        if (!$this->enhanceSigchildCompatibility && $this->isSigchildEnabled()) {
            throw new RuntimeException('This PHP has been compiled with --enable-sigchild. Term signal can not be retrieved.');
        }

>>>>>>> git-aline/master/master
        return $this->processInformation['signaled'];
    }

    /**
     * Returns the number of the signal that caused the child process to terminate its execution.
     *
     * It is only meaningful if hasBeenSignaled() returns true.
     *
     * @return int
     *
     * @throws RuntimeException In case --enable-sigchild is activated
     * @throws LogicException   In case the process is not terminated
     */
    public function getTermSignal()
    {
        $this->requireProcessIsTerminated(__FUNCTION__);

<<<<<<< HEAD
        if ($this->isSigchildEnabled()) {
            throw new RuntimeException('This PHP has been compiled with --enable-sigchild. Term signal can not be retrieved.');
        }

        $this->updateStatus(false);

=======
        if ($this->isSigchildEnabled() && (!$this->enhanceSigchildCompatibility || -1 === $this->processInformation['termsig'])) {
            throw new RuntimeException('This PHP has been compiled with --enable-sigchild. Term signal can not be retrieved.');
        }

>>>>>>> git-aline/master/master
        return $this->processInformation['termsig'];
    }

    /**
     * Returns true if the child process has been stopped by a signal.
     *
     * It always returns false on Windows.
     *
     * @return bool
     *
     * @throws LogicException In case the process is not terminated
     */
    public function hasBeenStopped()
    {
        $this->requireProcessIsTerminated(__FUNCTION__);

<<<<<<< HEAD
        $this->updateStatus(false);

=======
>>>>>>> git-aline/master/master
        return $this->processInformation['stopped'];
    }

    /**
     * Returns the number of the signal that caused the child process to stop its execution.
     *
     * It is only meaningful if hasBeenStopped() returns true.
     *
     * @return int
     *
     * @throws LogicException In case the process is not terminated
     */
    public function getStopSignal()
    {
        $this->requireProcessIsTerminated(__FUNCTION__);

<<<<<<< HEAD
        $this->updateStatus(false);

=======
>>>>>>> git-aline/master/master
        return $this->processInformation['stopsig'];
    }

    /**
     * Checks if the process is currently running.
     *
     * @return bool true if the process is currently running, false otherwise
     */
    public function isRunning()
    {
        if (self::STATUS_STARTED !== $this->status) {
            return false;
        }

        $this->updateStatus(false);

        return $this->processInformation['running'];
    }

    /**
     * Checks if the process has been started with no regard to the current state.
     *
     * @return bool true if status is ready, false otherwise
     */
    public function isStarted()
    {
<<<<<<< HEAD
        return $this->status != self::STATUS_READY;
=======
        return self::STATUS_READY != $this->status;
>>>>>>> git-aline/master/master
    }

    /**
     * Checks if the process is terminated.
     *
     * @return bool true if process is terminated, false otherwise
     */
    public function isTerminated()
    {
        $this->updateStatus(false);

<<<<<<< HEAD
        return $this->status == self::STATUS_TERMINATED;
=======
        return self::STATUS_TERMINATED == $this->status;
>>>>>>> git-aline/master/master
    }

    /**
     * Gets the process status.
     *
     * The status is one of: ready, started, terminated.
     *
     * @return string The current process status
     */
    public function getStatus()
    {
        $this->updateStatus(false);

        return $this->status;
    }

    /**
     * Stops the process.
     *
     * @param int|float $timeout The timeout in seconds
<<<<<<< HEAD
     * @param int       $signal  A POSIX signal to send in case the process has not stop at timeout, default is SIGKILL
     *
     * @return int The exit-code of the process
     *
     * @throws RuntimeException if the process got signaled
=======
     * @param int       $signal  A POSIX signal to send in case the process has not stop at timeout, default is SIGKILL (9)
     *
     * @return int The exit-code of the process
>>>>>>> git-aline/master/master
     */
    public function stop($timeout = 10, $signal = null)
    {
        $timeoutMicro = microtime(true) + $timeout;
        if ($this->isRunning()) {
<<<<<<< HEAD
            if ('\\' === DIRECTORY_SEPARATOR && !$this->isSigchildEnabled()) {
                exec(sprintf('taskkill /F /T /PID %d 2>&1', $this->getPid()), $output, $exitCode);
                if ($exitCode > 0) {
                    throw new RuntimeException('Unable to kill the process');
                }
            }
=======
>>>>>>> git-aline/master/master
            // given `SIGTERM` may not be defined and that `proc_terminate` uses the constant value and not the constant itself, we use the same here
            $this->doSignal(15, false);
            do {
                usleep(1000);
            } while ($this->isRunning() && microtime(true) < $timeoutMicro);

<<<<<<< HEAD
            if ($this->isRunning() && !$this->isSigchildEnabled()) {
                if (null !== $signal || defined('SIGKILL')) {
                    // avoid exception here :
                    // process is supposed to be running, but it might have stop
                    // just after this line.
                    // in any case, let's silently discard the error, we can not do anything
                    $this->doSignal($signal ?: SIGKILL, false);
                }
            }
        }

        $this->updateStatus(false);
        if ($this->processInformation['running']) {
=======
            if ($this->isRunning()) {
                // Avoid exception here: process is supposed to be running, but it might have stopped just
                // after this line. In any case, let's silently discard the error, we cannot do anything.
                $this->doSignal($signal ?: 9, false);
            }
        }

        if ($this->isRunning()) {
            if (isset($this->fallbackStatus['pid'])) {
                unset($this->fallbackStatus['pid']);

                return $this->stop(0, $signal);
            }
>>>>>>> git-aline/master/master
            $this->close();
        }

        return $this->exitcode;
    }

    /**
     * Adds a line to the STDOUT stream.
     *
<<<<<<< HEAD
=======
     * @internal
     *
>>>>>>> git-aline/master/master
     * @param string $line The line to append
     */
    public function addOutput($line)
    {
        $this->lastOutputTime = microtime(true);
<<<<<<< HEAD
        $this->stdout .= $line;
=======

        fseek($this->stdout, 0, SEEK_END);
        fwrite($this->stdout, $line);
        fseek($this->stdout, $this->incrementalOutputOffset);
>>>>>>> git-aline/master/master
    }

    /**
     * Adds a line to the STDERR stream.
     *
<<<<<<< HEAD
=======
     * @internal
     *
>>>>>>> git-aline/master/master
     * @param string $line The line to append
     */
    public function addErrorOutput($line)
    {
        $this->lastOutputTime = microtime(true);
<<<<<<< HEAD
        $this->stderr .= $line;
=======

        fseek($this->stderr, 0, SEEK_END);
        fwrite($this->stderr, $line);
        fseek($this->stderr, $this->incrementalErrorOutputOffset);
>>>>>>> git-aline/master/master
    }

    /**
     * Gets the command line to be executed.
     *
     * @return string The command to execute
     */
    public function getCommandLine()
    {
<<<<<<< HEAD
        return $this->commandline;
=======
        return \is_array($this->commandline) ? implode(' ', array_map(array($this, 'escapeArgument'), $this->commandline)) : $this->commandline;
>>>>>>> git-aline/master/master
    }

    /**
     * Sets the command line to be executed.
     *
<<<<<<< HEAD
     * @param string $commandline The command to execute
=======
     * @param string|array $commandline The command to execute
>>>>>>> git-aline/master/master
     *
     * @return self The current Process instance
     */
    public function setCommandLine($commandline)
    {
        $this->commandline = $commandline;

        return $this;
    }

    /**
     * Gets the process timeout (max. runtime).
     *
     * @return float|null The timeout in seconds or null if it's disabled
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Gets the process idle timeout (max. time since last output).
     *
     * @return float|null The timeout in seconds or null if it's disabled
     */
    public function getIdleTimeout()
    {
        return $this->idleTimeout;
    }

    /**
     * Sets the process timeout (max. runtime).
     *
     * To disable the timeout, set this value to null.
     *
     * @param int|float|null $timeout The timeout in seconds
     *
     * @return self The current Process instance
     *
     * @throws InvalidArgumentException if the timeout is negative
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $this->validateTimeout($timeout);

        return $this;
    }

    /**
     * Sets the process idle timeout (max. time since last output).
     *
     * To disable the timeout, set this value to null.
     *
     * @param int|float|null $timeout The timeout in seconds
     *
<<<<<<< HEAD
     * @return self The current Process instance.
=======
     * @return self The current Process instance
>>>>>>> git-aline/master/master
     *
     * @throws LogicException           if the output is disabled
     * @throws InvalidArgumentException if the timeout is negative
     */
    public function setIdleTimeout($timeout)
    {
        if (null !== $timeout && $this->outputDisabled) {
            throw new LogicException('Idle timeout can not be set while the output is disabled.');
        }

        $this->idleTimeout = $this->validateTimeout($timeout);

        return $this;
    }

    /**
     * Enables or disables the TTY mode.
     *
     * @param bool $tty True to enabled and false to disable
     *
     * @return self The current Process instance
     *
     * @throws RuntimeException In case the TTY mode is not supported
     */
    public function setTty($tty)
    {
<<<<<<< HEAD
        if ('\\' === DIRECTORY_SEPARATOR && $tty) {
            throw new RuntimeException('TTY mode is not supported on Windows platform.');
        }
        if ($tty && (!file_exists('/dev/tty') || !is_readable('/dev/tty'))) {
            throw new RuntimeException('TTY mode requires /dev/tty to be readable.');
=======
        if ('\\' === \DIRECTORY_SEPARATOR && $tty) {
            throw new RuntimeException('TTY mode is not supported on Windows platform.');
        }
        if ($tty) {
            static $isTtySupported;

            if (null === $isTtySupported) {
                $isTtySupported = (bool) @proc_open('echo 1 >/dev/null', array(array('file', '/dev/tty', 'r'), array('file', '/dev/tty', 'w'), array('file', '/dev/tty', 'w')), $pipes);
            }

            if (!$isTtySupported) {
                throw new RuntimeException('TTY mode requires /dev/tty to be read/writable.');
            }
>>>>>>> git-aline/master/master
        }

        $this->tty = (bool) $tty;

        return $this;
    }

    /**
     * Checks if the TTY mode is enabled.
     *
     * @return bool true if the TTY mode is enabled, false otherwise
     */
    public function isTty()
    {
        return $this->tty;
    }

    /**
     * Sets PTY mode.
     *
     * @param bool $bool
     *
     * @return self
     */
    public function setPty($bool)
    {
        $this->pty = (bool) $bool;

        return $this;
    }

    /**
     * Returns PTY state.
     *
     * @return bool
     */
    public function isPty()
    {
        return $this->pty;
    }

    /**
     * Gets the working directory.
     *
     * @return string|null The current working directory or null on failure
     */
    public function getWorkingDirectory()
    {
        if (null === $this->cwd) {
            // getcwd() will return false if any one of the parent directories does not have
            // the readable or search mode set, even if the current directory does
            return getcwd() ?: null;
        }

        return $this->cwd;
    }

    /**
     * Sets the current working directory.
     *
     * @param string $cwd The new working directory
     *
     * @return self The current Process instance
     */
    public function setWorkingDirectory($cwd)
    {
        $this->cwd = $cwd;

        return $this;
    }

    /**
     * Gets the environment variables.
     *
     * @return array The current environment variables
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * Sets the environment variables.
     *
<<<<<<< HEAD
     * An environment variable value should be a string.
     * If it is an array, the variable is ignored.
=======
     * Each environment variable value should be a string.
     * If it is an array, the variable is ignored.
     * If it is false or null, it will be removed when
     * env vars are otherwise inherited.
>>>>>>> git-aline/master/master
     *
     * That happens in PHP when 'argv' is registered into
     * the $_ENV array for instance.
     *
     * @param array $env The new environment variables
     *
     * @return self The current Process instance
     */
    public function setEnv(array $env)
    {
        // Process can not handle env values that are arrays
        $env = array_filter($env, function ($value) {
<<<<<<< HEAD
            return !is_array($value);
        });

        $this->env = array();
        foreach ($env as $key => $value) {
            $this->env[$key] = (string) $value;
        }
=======
            return !\is_array($value);
        });

        $this->env = $env;
>>>>>>> git-aline/master/master

        return $this;
    }

    /**
<<<<<<< HEAD
     * Gets the contents of STDIN.
     *
     * @return string|null The current contents
     *
     * @deprecated since version 2.5, to be removed in 3.0.
     *             Use setInput() instead.
     *             This method is deprecated in favor of getInput.
     */
    public function getStdin()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.5 and will be removed in 3.0. Use the getInput() method instead.', E_USER_DEPRECATED);

        return $this->getInput();
    }

    /**
     * Gets the Process input.
     *
     * @return null|string The Process input
=======
     * Gets the Process input.
     *
     * @return resource|string|\Iterator|null The Process input
>>>>>>> git-aline/master/master
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
<<<<<<< HEAD
     * Sets the contents of STDIN.
     *
     * @param string|null $stdin The new contents
     *
     * @return self The current Process instance
     *
     * @deprecated since version 2.5, to be removed in 3.0.
     *             Use setInput() instead.
     *
     * @throws LogicException           In case the process is running
     * @throws InvalidArgumentException In case the argument is invalid
     */
    public function setStdin($stdin)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.5 and will be removed in 3.0. Use the setInput() method instead.', E_USER_DEPRECATED);

        return $this->setInput($stdin);
    }

    /**
=======
>>>>>>> git-aline/master/master
     * Sets the input.
     *
     * This content will be passed to the underlying process standard input.
     *
<<<<<<< HEAD
     * @param mixed $input The content
=======
     * @param string|int|float|bool|resource|\Traversable|null $input The content
>>>>>>> git-aline/master/master
     *
     * @return self The current Process instance
     *
     * @throws LogicException In case the process is running
<<<<<<< HEAD
     *
     * Passing an object as an input is deprecated since version 2.5 and will be removed in 3.0.
=======
>>>>>>> git-aline/master/master
     */
    public function setInput($input)
    {
        if ($this->isRunning()) {
            throw new LogicException('Input can not be set while the process is running.');
        }

<<<<<<< HEAD
        $this->input = ProcessUtils::validateInput(sprintf('%s::%s', __CLASS__, __FUNCTION__), $input);
=======
        $this->input = ProcessUtils::validateInput(__METHOD__, $input);
>>>>>>> git-aline/master/master

        return $this;
    }

    /**
     * Gets the options for proc_open.
     *
     * @return array The current options
<<<<<<< HEAD
     */
    public function getOptions()
    {
=======
     *
     * @deprecated since version 3.3, to be removed in 4.0.
     */
    public function getOptions()
    {
        @trigger_error(sprintf('The %s() method is deprecated since Symfony 3.3 and will be removed in 4.0.', __METHOD__), E_USER_DEPRECATED);

>>>>>>> git-aline/master/master
        return $this->options;
    }

    /**
     * Sets the options for proc_open.
     *
     * @param array $options The new options
     *
     * @return self The current Process instance
<<<<<<< HEAD
     */
    public function setOptions(array $options)
    {
=======
     *
     * @deprecated since version 3.3, to be removed in 4.0.
     */
    public function setOptions(array $options)
    {
        @trigger_error(sprintf('The %s() method is deprecated since Symfony 3.3 and will be removed in 4.0.', __METHOD__), E_USER_DEPRECATED);

>>>>>>> git-aline/master/master
        $this->options = $options;

        return $this;
    }

    /**
     * Gets whether or not Windows compatibility is enabled.
     *
     * This is true by default.
     *
     * @return bool
<<<<<<< HEAD
     */
    public function getEnhanceWindowsCompatibility()
    {
=======
     *
     * @deprecated since version 3.3, to be removed in 4.0. Enhanced Windows compatibility will always be enabled.
     */
    public function getEnhanceWindowsCompatibility()
    {
        @trigger_error(sprintf('The %s() method is deprecated since Symfony 3.3 and will be removed in 4.0. Enhanced Windows compatibility will always be enabled.', __METHOD__), E_USER_DEPRECATED);

>>>>>>> git-aline/master/master
        return $this->enhanceWindowsCompatibility;
    }

    /**
     * Sets whether or not Windows compatibility is enabled.
     *
     * @param bool $enhance
     *
     * @return self The current Process instance
<<<<<<< HEAD
     */
    public function setEnhanceWindowsCompatibility($enhance)
    {
=======
     *
     * @deprecated since version 3.3, to be removed in 4.0. Enhanced Windows compatibility will always be enabled.
     */
    public function setEnhanceWindowsCompatibility($enhance)
    {
        @trigger_error(sprintf('The %s() method is deprecated since Symfony 3.3 and will be removed in 4.0. Enhanced Windows compatibility will always be enabled.', __METHOD__), E_USER_DEPRECATED);

>>>>>>> git-aline/master/master
        $this->enhanceWindowsCompatibility = (bool) $enhance;

        return $this;
    }

    /**
     * Returns whether sigchild compatibility mode is activated or not.
     *
     * @return bool
<<<<<<< HEAD
     */
    public function getEnhanceSigchildCompatibility()
    {
=======
     *
     * @deprecated since version 3.3, to be removed in 4.0. Sigchild compatibility will always be enabled.
     */
    public function getEnhanceSigchildCompatibility()
    {
        @trigger_error(sprintf('The %s() method is deprecated since Symfony 3.3 and will be removed in 4.0. Sigchild compatibility will always be enabled.', __METHOD__), E_USER_DEPRECATED);

>>>>>>> git-aline/master/master
        return $this->enhanceSigchildCompatibility;
    }

    /**
     * Activates sigchild compatibility mode.
     *
     * Sigchild compatibility mode is required to get the exit code and
     * determine the success of a process when PHP has been compiled with
     * the --enable-sigchild option
     *
     * @param bool $enhance
     *
     * @return self The current Process instance
<<<<<<< HEAD
     */
    public function setEnhanceSigchildCompatibility($enhance)
    {
=======
     *
     * @deprecated since version 3.3, to be removed in 4.0.
     */
    public function setEnhanceSigchildCompatibility($enhance)
    {
        @trigger_error(sprintf('The %s() method is deprecated since Symfony 3.3 and will be removed in 4.0. Sigchild compatibility will always be enabled.', __METHOD__), E_USER_DEPRECATED);

>>>>>>> git-aline/master/master
        $this->enhanceSigchildCompatibility = (bool) $enhance;

        return $this;
    }

    /**
<<<<<<< HEAD
=======
     * Sets whether environment variables will be inherited or not.
     *
     * @param bool $inheritEnv
     *
     * @return self The current Process instance
     */
    public function inheritEnvironmentVariables($inheritEnv = true)
    {
        if (!$inheritEnv) {
            @trigger_error('Not inheriting environment variables is deprecated since Symfony 3.3 and will always happen in 4.0. Set "Process::inheritEnvironmentVariables()" to true instead.', E_USER_DEPRECATED);
        }

        $this->inheritEnv = (bool) $inheritEnv;

        return $this;
    }

    /**
     * Returns whether environment variables will be inherited or not.
     *
     * @return bool
     *
     * @deprecated since version 3.3, to be removed in 4.0. Environment variables will always be inherited.
     */
    public function areEnvironmentVariablesInherited()
    {
        @trigger_error(sprintf('The %s() method is deprecated since Symfony 3.3 and will be removed in 4.0. Environment variables will always be inherited.', __METHOD__), E_USER_DEPRECATED);

        return $this->inheritEnv;
    }

    /**
>>>>>>> git-aline/master/master
     * Performs a check between the timeout definition and the time the process started.
     *
     * In case you run a background process (with the start method), you should
     * trigger this method regularly to ensure the process timeout
     *
     * @throws ProcessTimedOutException In case the timeout was reached
     */
    public function checkTimeout()
    {
<<<<<<< HEAD
        if ($this->status !== self::STATUS_STARTED) {
=======
        if (self::STATUS_STARTED !== $this->status) {
>>>>>>> git-aline/master/master
            return;
        }

        if (null !== $this->timeout && $this->timeout < microtime(true) - $this->starttime) {
            $this->stop(0);

            throw new ProcessTimedOutException($this, ProcessTimedOutException::TYPE_GENERAL);
        }

        if (null !== $this->idleTimeout && $this->idleTimeout < microtime(true) - $this->lastOutputTime) {
            $this->stop(0);

            throw new ProcessTimedOutException($this, ProcessTimedOutException::TYPE_IDLE);
        }
    }

    /**
     * Returns whether PTY is supported on the current operating system.
     *
     * @return bool
     */
    public static function isPtySupported()
    {
        static $result;

        if (null !== $result) {
            return $result;
        }

<<<<<<< HEAD
        if ('\\' === DIRECTORY_SEPARATOR) {
            return $result = false;
        }

        $proc = @proc_open('echo 1', array(array('pty'), array('pty'), array('pty')), $pipes);
        if (is_resource($proc)) {
            proc_close($proc);

            return $result = true;
        }

        return $result = false;
=======
        if ('\\' === \DIRECTORY_SEPARATOR) {
            return $result = false;
        }

        return $result = (bool) @proc_open('echo 1 >/dev/null', array(array('pty'), array('pty'), array('pty')), $pipes);
>>>>>>> git-aline/master/master
    }

    /**
     * Creates the descriptors needed by the proc_open.
     *
     * @return array
     */
    private function getDescriptors()
    {
<<<<<<< HEAD
        if ('\\' === DIRECTORY_SEPARATOR) {
            $this->processPipes = WindowsPipes::create($this, $this->input);
        } else {
            $this->processPipes = UnixPipes::create($this, $this->input);
        }
        $descriptors = $this->processPipes->getDescriptors($this->outputDisabled);

        if (!$this->useFileHandles && $this->enhanceSigchildCompatibility && $this->isSigchildEnabled()) {
            // last exit code is output on the fourth pipe and caught to work around --enable-sigchild
            $descriptors = array_merge($descriptors, array(array('pipe', 'w')));

            $this->commandline = '('.$this->commandline.') 3>/dev/null; code=$?; echo $code >&3; exit $code';
        }

        return $descriptors;
=======
        if ($this->input instanceof \Iterator) {
            $this->input->rewind();
        }
        if ('\\' === \DIRECTORY_SEPARATOR) {
            $this->processPipes = new WindowsPipes($this->input, !$this->outputDisabled || $this->hasCallback);
        } else {
            $this->processPipes = new UnixPipes($this->isTty(), $this->isPty(), $this->input, !$this->outputDisabled || $this->hasCallback);
        }

        return $this->processPipes->getDescriptors();
>>>>>>> git-aline/master/master
    }

    /**
     * Builds up the callback used by wait().
     *
     * The callbacks adds all occurred output to the specific buffer and calls
     * the user callback (if present) with the received output.
     *
     * @param callable|null $callback The user defined PHP callback
     *
     * @return \Closure A PHP closure
     */
<<<<<<< HEAD
    protected function buildCallback($callback)
    {
        $that = $this;
        $out = self::OUT;
        $callback = function ($type, $data) use ($that, $callback, $out) {
            if ($out == $type) {
                $that->addOutput($data);
            } else {
                $that->addErrorOutput($data);
            }

            if (null !== $callback) {
                call_user_func($callback, $type, $data);
            }
        };

        return $callback;
=======
    protected function buildCallback(callable $callback = null)
    {
        if ($this->outputDisabled) {
            return function ($type, $data) use ($callback) {
                if (null !== $callback) {
                    \call_user_func($callback, $type, $data);
                }
            };
        }

        $out = self::OUT;

        return function ($type, $data) use ($callback, $out) {
            if ($out == $type) {
                $this->addOutput($data);
            } else {
                $this->addErrorOutput($data);
            }

            if (null !== $callback) {
                \call_user_func($callback, $type, $data);
            }
        };
>>>>>>> git-aline/master/master
    }

    /**
     * Updates the status of the process, reads pipes.
     *
<<<<<<< HEAD
     * @param bool $blocking Whether to use a blocking read call.
=======
     * @param bool $blocking Whether to use a blocking read call
>>>>>>> git-aline/master/master
     */
    protected function updateStatus($blocking)
    {
        if (self::STATUS_STARTED !== $this->status) {
            return;
        }

        $this->processInformation = proc_get_status($this->process);
<<<<<<< HEAD
        $this->captureExitCode();

        $this->readPipes($blocking, '\\' === DIRECTORY_SEPARATOR ? !$this->processInformation['running'] : true);

        if (!$this->processInformation['running']) {
=======
        $running = $this->processInformation['running'];

        $this->readPipes($running && $blocking, '\\' !== \DIRECTORY_SEPARATOR || !$running);

        if ($this->fallbackStatus && $this->enhanceSigchildCompatibility && $this->isSigchildEnabled()) {
            $this->processInformation = $this->fallbackStatus + $this->processInformation;
        }

        if (!$running) {
>>>>>>> git-aline/master/master
            $this->close();
        }
    }

    /**
     * Returns whether PHP has been compiled with the '--enable-sigchild' option or not.
     *
     * @return bool
     */
    protected function isSigchildEnabled()
    {
        if (null !== self::$sigchild) {
            return self::$sigchild;
        }

<<<<<<< HEAD
        if (!function_exists('phpinfo')) {
=======
        if (!\function_exists('phpinfo') || \defined('HHVM_VERSION')) {
>>>>>>> git-aline/master/master
            return self::$sigchild = false;
        }

        ob_start();
        phpinfo(INFO_GENERAL);

        return self::$sigchild = false !== strpos(ob_get_clean(), '--enable-sigchild');
    }

    /**
<<<<<<< HEAD
=======
     * Reads pipes for the freshest output.
     *
     * @param string $caller   The name of the method that needs fresh outputs
     * @param bool   $blocking Whether to use blocking calls or not
     *
     * @throws LogicException in case output has been disabled or process is not started
     */
    private function readPipesForOutput($caller, $blocking = false)
    {
        if ($this->outputDisabled) {
            throw new LogicException('Output has been disabled.');
        }

        $this->requireProcessIsStarted($caller);

        $this->updateStatus($blocking);
    }

    /**
>>>>>>> git-aline/master/master
     * Validates and returns the filtered timeout.
     *
     * @param int|float|null $timeout
     *
     * @return float|null
     *
     * @throws InvalidArgumentException if the given timeout is a negative number
     */
    private function validateTimeout($timeout)
    {
        $timeout = (float) $timeout;

        if (0.0 === $timeout) {
            $timeout = null;
        } elseif ($timeout < 0) {
            throw new InvalidArgumentException('The timeout value must be a valid positive integer or float number.');
        }

        return $timeout;
    }

    /**
     * Reads pipes, executes callback.
     *
<<<<<<< HEAD
     * @param bool $blocking Whether to use blocking calls or not.
     * @param bool $close    Whether to close file handles or not.
=======
     * @param bool $blocking Whether to use blocking calls or not
     * @param bool $close    Whether to close file handles or not
>>>>>>> git-aline/master/master
     */
    private function readPipes($blocking, $close)
    {
        $result = $this->processPipes->readAndWrite($blocking, $close);

        $callback = $this->callback;
        foreach ($result as $type => $data) {
<<<<<<< HEAD
            if (3 == $type) {
                $this->fallbackExitcode = (int) $data;
            } else {
                $callback($type === self::STDOUT ? self::OUT : self::ERR, $data);
=======
            if (3 !== $type) {
                $callback(self::STDOUT === $type ? self::OUT : self::ERR, $data);
            } elseif (!isset($this->fallbackStatus['signaled'])) {
                $this->fallbackStatus['exitcode'] = (int) $data;
>>>>>>> git-aline/master/master
            }
        }
    }

    /**
<<<<<<< HEAD
     * Captures the exitcode if mentioned in the process information.
     */
    private function captureExitCode()
    {
        if (isset($this->processInformation['exitcode']) && -1 != $this->processInformation['exitcode']) {
            $this->exitcode = $this->processInformation['exitcode'];
        }
    }

    /**
=======
>>>>>>> git-aline/master/master
     * Closes process resource, closes file handles, sets the exitcode.
     *
     * @return int The exitcode
     */
    private function close()
    {
        $this->processPipes->close();
<<<<<<< HEAD
        if (is_resource($this->process)) {
            $exitcode = proc_close($this->process);
        } else {
            $exitcode = -1;
        }

        $this->exitcode = -1 !== $exitcode ? $exitcode : (null !== $this->exitcode ? $this->exitcode : -1);
        $this->status = self::STATUS_TERMINATED;

        if (-1 === $this->exitcode && null !== $this->fallbackExitcode) {
            $this->exitcode = $this->fallbackExitcode;
        } elseif (-1 === $this->exitcode && $this->processInformation['signaled'] && 0 < $this->processInformation['termsig']) {
            // if process has been signaled, no exitcode but a valid termsig, apply Unix convention
            $this->exitcode = 128 + $this->processInformation['termsig'];
        }

=======
        if (\is_resource($this->process)) {
            proc_close($this->process);
        }
        $this->exitcode = $this->processInformation['exitcode'];
        $this->status = self::STATUS_TERMINATED;

        if (-1 === $this->exitcode) {
            if ($this->processInformation['signaled'] && 0 < $this->processInformation['termsig']) {
                // if process has been signaled, no exitcode but a valid termsig, apply Unix convention
                $this->exitcode = 128 + $this->processInformation['termsig'];
            } elseif ($this->enhanceSigchildCompatibility && $this->isSigchildEnabled()) {
                $this->processInformation['signaled'] = true;
                $this->processInformation['termsig'] = -1;
            }
        }

        // Free memory from self-reference callback created by buildCallback
        // Doing so in other contexts like __destruct or by garbage collector is ineffective
        // Now pipes are closed, so the callback is no longer necessary
        $this->callback = null;

>>>>>>> git-aline/master/master
        return $this->exitcode;
    }

    /**
     * Resets data related to the latest run of the process.
     */
    private function resetProcessData()
    {
        $this->starttime = null;
        $this->callback = null;
        $this->exitcode = null;
<<<<<<< HEAD
        $this->fallbackExitcode = null;
        $this->processInformation = null;
        $this->stdout = null;
        $this->stderr = null;
=======
        $this->fallbackStatus = array();
        $this->processInformation = null;
        $this->stdout = fopen('php://temp/maxmemory:'.(1024 * 1024), 'wb+');
        $this->stderr = fopen('php://temp/maxmemory:'.(1024 * 1024), 'wb+');
>>>>>>> git-aline/master/master
        $this->process = null;
        $this->latestSignal = null;
        $this->status = self::STATUS_READY;
        $this->incrementalOutputOffset = 0;
        $this->incrementalErrorOutputOffset = 0;
    }

    /**
     * Sends a POSIX signal to the process.
     *
     * @param int  $signal         A valid POSIX signal (see http://www.php.net/manual/en/pcntl.constants.php)
     * @param bool $throwException Whether to throw exception in case signal failed
     *
     * @return bool True if the signal was sent successfully, false otherwise
     *
     * @throws LogicException   In case the process is not running
<<<<<<< HEAD
     * @throws RuntimeException In case --enable-sigchild is activated
=======
     * @throws RuntimeException In case --enable-sigchild is activated and the process can't be killed
>>>>>>> git-aline/master/master
     * @throws RuntimeException In case of failure
     */
    private function doSignal($signal, $throwException)
    {
<<<<<<< HEAD
        if (!$this->isRunning()) {
=======
        if (null === $pid = $this->getPid()) {
>>>>>>> git-aline/master/master
            if ($throwException) {
                throw new LogicException('Can not send signal on a non running process.');
            }

            return false;
        }

<<<<<<< HEAD
        if ($this->isSigchildEnabled()) {
            if ($throwException) {
                throw new RuntimeException('This PHP has been compiled with --enable-sigchild. The process can not be signaled.');
            }

            return false;
        }

        if (true !== @proc_terminate($this->process, $signal)) {
            if ($throwException) {
                throw new RuntimeException(sprintf('Error while sending signal `%s`.', $signal));
            }

            return false;
        }

        $this->latestSignal = $signal;
=======
        if ('\\' === \DIRECTORY_SEPARATOR) {
            exec(sprintf('taskkill /F /T /PID %d 2>&1', $pid), $output, $exitCode);
            if ($exitCode && $this->isRunning()) {
                if ($throwException) {
                    throw new RuntimeException(sprintf('Unable to kill the process (%s).', implode(' ', $output)));
                }

                return false;
            }
        } else {
            if (!$this->enhanceSigchildCompatibility || !$this->isSigchildEnabled()) {
                $ok = @proc_terminate($this->process, $signal);
            } elseif (\function_exists('posix_kill')) {
                $ok = @posix_kill($pid, $signal);
            } elseif ($ok = proc_open(sprintf('kill -%d %d', $signal, $pid), array(2 => array('pipe', 'w')), $pipes)) {
                $ok = false === fgets($pipes[2]);
            }
            if (!$ok) {
                if ($throwException) {
                    throw new RuntimeException(sprintf('Error while sending signal `%s`.', $signal));
                }

                return false;
            }
        }

        $this->latestSignal = (int) $signal;
        $this->fallbackStatus['signaled'] = true;
        $this->fallbackStatus['exitcode'] = -1;
        $this->fallbackStatus['termsig'] = $this->latestSignal;
>>>>>>> git-aline/master/master

        return true;
    }

<<<<<<< HEAD
    /**
     * Ensures the process is running or terminated, throws a LogicException if the process has a not started.
     *
     * @param string $functionName The function name that was called.
     *
     * @throws LogicException If the process has not run.
=======
    private function prepareWindowsCommandLine($cmd, array &$env)
    {
        $uid = uniqid('', true);
        $varCount = 0;
        $varCache = array();
        $cmd = preg_replace_callback(
            '/"(?:(
                [^"%!^]*+
                (?:
                    (?: !LF! | "(?:\^[%!^])?+" )
                    [^"%!^]*+
                )++
            ) | [^"]*+ )"/x',
            function ($m) use (&$env, &$varCache, &$varCount, $uid) {
                if (!isset($m[1])) {
                    return $m[0];
                }
                if (isset($varCache[$m[0]])) {
                    return $varCache[$m[0]];
                }
                if (false !== strpos($value = $m[1], "\0")) {
                    $value = str_replace("\0", '?', $value);
                }
                if (false === strpbrk($value, "\"%!\n")) {
                    return '"'.$value.'"';
                }

                $value = str_replace(array('!LF!', '"^!"', '"^%"', '"^^"', '""'), array("\n", '!', '%', '^', '"'), $value);
                $value = '"'.preg_replace('/(\\\\*)"/', '$1$1\\"', $value).'"';
                $var = $uid.++$varCount;

                $env[$var] = $value;

                return $varCache[$m[0]] = '!'.$var.'!';
            },
            $cmd
        );

        $cmd = 'cmd /V:ON /E:ON /D /C ('.str_replace("\n", ' ', $cmd).')';
        foreach ($this->processPipes->getFiles() as $offset => $filename) {
            $cmd .= ' '.$offset.'>"'.$filename.'"';
        }

        return $cmd;
    }

    /**
     * Ensures the process is running or terminated, throws a LogicException if the process has a not started.
     *
     * @param string $functionName The function name that was called
     *
     * @throws LogicException if the process has not run
>>>>>>> git-aline/master/master
     */
    private function requireProcessIsStarted($functionName)
    {
        if (!$this->isStarted()) {
            throw new LogicException(sprintf('Process must be started before calling %s.', $functionName));
        }
    }

    /**
     * Ensures the process is terminated, throws a LogicException if the process has a status different than `terminated`.
     *
<<<<<<< HEAD
     * @param string $functionName The function name that was called.
     *
     * @throws LogicException If the process is not yet terminated.
=======
     * @param string $functionName The function name that was called
     *
     * @throws LogicException if the process is not yet terminated
>>>>>>> git-aline/master/master
     */
    private function requireProcessIsTerminated($functionName)
    {
        if (!$this->isTerminated()) {
            throw new LogicException(sprintf('Process must be terminated before calling %s.', $functionName));
        }
    }
<<<<<<< HEAD
=======

    /**
     * Escapes a string to be used as a shell argument.
     *
     * @param string $argument The argument that will be escaped
     *
     * @return string The escaped argument
     */
    private function escapeArgument($argument)
    {
        if ('\\' !== \DIRECTORY_SEPARATOR) {
            return "'".str_replace("'", "'\\''", $argument)."'";
        }
        if ('' === $argument = (string) $argument) {
            return '""';
        }
        if (false !== strpos($argument, "\0")) {
            $argument = str_replace("\0", '?', $argument);
        }
        if (!preg_match('/[\/()%!^"<>&|\s]/', $argument)) {
            return $argument;
        }
        $argument = preg_replace('/(\\\\+)$/', '$1$1', $argument);

        return '"'.str_replace(array('"', '^', '%', '!', "\n"), array('""', '"^^"', '"^%"', '"^!"', '!LF!'), $argument).'"';
    }

    private function getDefaultEnv()
    {
        $env = array();

        foreach ($_SERVER as $k => $v) {
            if (\is_string($v) && false !== $v = getenv($k)) {
                $env[$k] = $v;
            }
        }

        foreach ($_ENV as $k => $v) {
            if (\is_string($v)) {
                $env[$k] = $v;
            }
        }

        return $env;
    }
>>>>>>> git-aline/master/master
}
