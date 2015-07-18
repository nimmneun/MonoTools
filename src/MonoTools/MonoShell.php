<?php

namespace MonoTools;

use InvalidArgumentException;

class MonoShell
{
    /**
     * @var string|null|bool
     */
    private $out;

    /**
     * @var string
     */
    private $cmd;

    /**
     * @var bool
     */
    private $exception;

    /**
     * @var array
     */
    private $bad_cmds = array('cp','copy','xcopy','rm','rmdir','mv','wget','mkfs','dd','su','sudo');

    /**
     * @var string
     */
    private $good_chrs = '\w\d\-\s\/\.\+\|';

    /**
     * @param string $cmd
     * @param bool   $exception
     * @return MonoShell
     */
    public static function run($cmd, $exception = true)
    {
        $shell = new self;
        $shell->perform($cmd, $exception);
        return $shell;
    }

    /**
     * @return string|null|bool
     */
    public function getOut()
    {
        return $this->out;
    }

    /**
     * @return string
     */
    public function getCmd()
    {
        return $this->cmd;
    }

    /**
     * @param string $cmd
     * @param bool   $exception
     * @throws InvalidArgumentException
     */
    private function perform($cmd, $exception)
    {
        $this->cmd = $cmd;
        $this->exception = (bool)$exception;
        $this->isCmdAllowed() ? $this->execute() : $this->fail();
    }

    /**
     * Check wether the specified command string is allowed or not.
     *
     * @return bool
     */
    private function isCmdAllowed()
    {
        return 1 !== preg_match('/\b('. implode('|', $this->bad_cmds) .')\b/', $this->cmd, $m)
            && 1 === preg_match('/^['. $this->good_chrs .']+$/', $this->cmd, $m);
    }

    /**
     * Returns false or throws an exception,
     * if the specified cmd string is not allowed.
     *
     * @throws InvalidArgumentException
     */
    private function fail()
    {
        if ($this->exception) {
            throw new InvalidArgumentException(sprintf('Execution of command [%s] denied', $this->cmd));
        } else {
            $this->out = false;
        }
    }

    /**
     * Execute and set $out to output returned by the command.
     * Throw exception or set output to false if cmd fails to execute.
     *
     * @throws InvalidArgumentException
     */
    private function execute()
    {
        exec($this->cmd, $output, $return);

        if (!$return) {
            $this->out = implode("\n", $output);
        } else {
            if ($this->exception) {
                throw new InvalidArgumentException(sprintf('Execution of command [%s] failed', $this->cmd));
            }
            $this->out = false;
        }
    }
}

