<?php

namespace MonoTools;

/**
 * @desc dummy class SomeGuy
 */
class SomeGuy
{
    private $firstName = 'John';
    private $lastName = 'Doe';
    private $age = 35;

    public function getFirstName() { return $this->firstName; }
    public function getLastName() { return $this->lastName; }
    public function getAge() { return $this->age; }

    public function setFirstName($firstName) { $this->firstName = $firstName; return $this; }
    public function setLastName($lastName) { $this->lastName = $lastName; return $this; }
    public function setAge($age) { $this->age = $age; return $this; }

    public function toArray() { return get_object_vars($this); }
}
