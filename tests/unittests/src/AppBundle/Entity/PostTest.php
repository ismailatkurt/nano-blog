<?php

namespace AppBundle\Entity;

use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    /**
     * @test
     */
    public function gettersSetter_test()
    {
        // prepare
        /** @var Post|\PHPUnit_Framework_MockObject_MockObject $translatedPostMock */
        $translatedPostMock = $this->createMock(Post::class);
        /** @var Language|\PHPUnit_Framework_MockObject_MockObject $languageMock */
        $languageMock = $this->createMock(Language::class);
        /** @var User|\PHPUnit_Framework_MockObject_MockObject $userMock */
        $userMock = $this->createMock(User::class);

        $title = 'some title';
        $slug = 'some-slug';
        $content = 'some long content of post is here';
        /** @var \DateTime|\PHPUnit_Framework_MockObject_MockObject $createdAt */
        $createdAt = $this->createMock(\DateTime::class);

        // test
        $classUnderTest = new Post();

        $classUnderTest->setTitle($title);
        $classUnderTest->setSlug($slug);
        $classUnderTest->setContent($content);
        $classUnderTest->setCreatedAt($createdAt);
        $classUnderTest->setAuthor($userMock);
        $classUnderTest->setTranslatedPost($translatedPostMock);
        $classUnderTest->setLanguage($languageMock);

        // verify
        $this->assertEquals(null, $classUnderTest->getId());
        $this->assertEquals($title, $classUnderTest->getTitle());
        $this->assertEquals($slug, $classUnderTest->getSlug());
        $this->assertEquals($content, $classUnderTest->getContent());
        $this->assertEquals($createdAt, $classUnderTest->getCreatedAt());
        $this->assertEquals($userMock, $classUnderTest->getAuthor());
        $this->assertEquals($translatedPostMock, $classUnderTest->getTranslatedPost());
        $this->assertEquals($languageMock, $classUnderTest->getLanguage());
    }
}
