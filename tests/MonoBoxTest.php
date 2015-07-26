<?php

namespace MonoTools;

class MonoBoxTest extends \PHPUnit_Framework_TestCase
{
    public function testDecamelize()
    {
        $this->assertEquals('stuffs_about_to_happen', \MonoTools\MonoBox::decamelize('StuffsAboutToHappen'));
    }

    public function testCamelize()
    {
        $this->assertEquals('StuffsAboutToHappen', \MonoTools\MonoBox::camelize('stuffs_about_to_happen'));
    }
}
