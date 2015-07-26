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
    
    public function testObjectToArray()
    {
        $dummy = new SomeGuy();
        
        $this->assertEquals(
            array(
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'age'        => 35,
                ),
            \MonoTools\MonoBox::objectToArray($dummy)
        );
    }
}
