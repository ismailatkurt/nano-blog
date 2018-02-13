<?php

namespace AppBundle\Entity;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function instance_test()
    {
        // prepare
        // test
        $classUnderTest = new User();

        // verify
        $this->assertInstanceOf(User::class, $classUnderTest);
    }
}
