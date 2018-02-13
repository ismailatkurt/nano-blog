<?php

namespace AppBundle;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundleTest extends TestCase
{
    /**
     * @test
     */
    public function instance_test()
    {
        $classUnderTest = new AppBundle();

        $this->assertInstanceOf(Bundle::class, $classUnderTest);
    }
}