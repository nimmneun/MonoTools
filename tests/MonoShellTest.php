<?php

namespace MonoTools;

class MonoShellTest extends \PHPUnit_Framework_TestCase
{
    public function testRun()
    {
        $this->assertEquals(false, \MonoTools\MonoShell::run('qdqwouihqo', 0)->getOut());
    }

    public function testGetOut()
    {
        $this->assertEquals('123', \MonoTools\MonoShell::run('echo 123', 0)->getOut());
    }

    public function testGetCmd()
    {
        $this->assertEquals('ls -al', \MonoTools\MonoShell::run('ls -al', 0)->getCmd());
    }

    public function testFail()
    {
        $this->assertEquals(false, \MonoTools\MonoShell::run('rmdir -rf 123', 0)->getOut());
    }

    public function testExecute()
    {
        $this->assertEquals(false, \MonoTools\MonoShell::run('asdasdav', 0)->getOut());
    }

    public function testExceptionOne()
    {
        $this->setExpectedException('InvalidArgumentException');
        echo \MonoTools\MonoShell::run('erwqetert', 1)->getOut();
    }

    public function testExceptionTwo()
    {
        $this->setExpectedException('InvalidArgumentException');
        echo \MonoTools\MonoShell::run('rmdir 123', 1)->getOut();
    }
}
