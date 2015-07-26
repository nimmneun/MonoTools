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
        $object = new \MonoTools\SomeGuy();
        $dummy = \MonoTools\MonoBox::objectToArray($object);

        $this->assertEquals(
            array(
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'age'        => 35,
                ),
            $dummy
        );
    }

    public function testArrayToObject()
    {
        $arr = array(
            'first_name' => 'Don',
            'last_name'  => 'Joe',
            'age'        => 33,
        );
        $object = \MonoTools\MonoBox::arrayToObject('\MonoTools\SomeGuy', $arr);

        $this->assertInstanceOf('\MonoTools\Someguy', $object);
        $this->assertEquals(33, $object->getAge());
    }
}
