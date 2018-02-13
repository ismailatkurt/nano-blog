<?php

namespace AppBundle\Entity;

use PHPUnit\Framework\TestCase;

class LanguageTest extends TestCase
{
    /**
     * @test
     */
    public function gettersSetter_test()
    {
        // prepare
        $id = 123;
        $name = 'somename';

        // test
        $classUnderTest = new Language();

        $classUnderTest->setId($id);
        $classUnderTest->setName($name);

        // verify
        $this->assertEquals($id, $classUnderTest->getId());
        $this->assertEquals($name, $classUnderTest->getName());
    }
}
