<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\TestCase;

class PostRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function instance_test()
    {
        // prepare
        /** @var EntityManager|\PHPUnit_Framework_MockObject_MockObject $entityManagerMock */
        $entityManagerMock = $this->createMock(EntityManager::class);

        /** @var ClassMetadata|\PHPUnit_Framework_MockObject_MockObject $classMock */
        $classMock =$this->createMock(ClassMetadata::class);

        // test
        $classUnderTest = new PostRepository($entityManagerMock, $classMock);

        // verify
        $this->assertInstanceOf(PostRepository::class, $classUnderTest);
    }
}
