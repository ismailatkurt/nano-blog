<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Language;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Repository\LanguageRepository;
use AppBundle\Repository\PostRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class PostControllerTest extends TestCase
{
    /**
     * @test
     */
    public function index_test()
    {
        // prepare
        /** @var EntityManager|\PHPUnit_Framework_MockObject_MockObject $entityManagerMock */
        $entityManagerMock = $this->createMock(EntityManager::class);

        /** @var PostRepository|\PHPUnit_Framework_MockObject_MockObject $postRepositoryMock */
        $postRepositoryMock = $this->createMock(PostRepository::class);

        /** @var Collection|\PHPUnit_Framework_MockObject_MockObject $postCollectionMock */
        $postCollectionMock=$this->createMock(Collection::class);

        $postsMock = [
            $this->createMock(Post::class),
            $this->createMock(Post::class)
        ];
        $postCollectionMock->expects($this->once())
            ->method('getValues')
            ->willReturn([$postsMock]);
        $postRepositoryMock->expects($this->once())
            ->method('matching')
            ->willReturn($postCollectionMock);

        /** @var LanguageRepository|\PHPUnit_Framework_MockObject_MockObject $languageRepositoryMock */
        $languageRepositoryMock = $this->createMock(LanguageRepository::class);

        /** @var Collection|\PHPUnit_Framework_MockObject_MockObject $collectionMock */
        $collectionMock = $this->createMock(Collection::class);
        /** @var Language|\PHPUnit_Framework_MockObject_MockObject $languageMock */
        $languageMock = $this->createMock(Language::class);
        $collectionMock->expects($this->once())
            ->method('getValues')
            ->willReturn([$languageMock]);
        $languageRepositoryMock->expects($this->once())
            ->method('matching')
            ->willReturn($collectionMock);

        $entityManagerMock->expects($this->at(0))
            ->method('getRepository')
            ->with(Post::class)
            ->willReturn($postRepositoryMock);
        $entityManagerMock->expects($this->at(1))
            ->method('getRepository')
            ->with(Language::class)
            ->willReturn($languageRepositoryMock);

        /** @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject $containerMock */
        $containerMock = $this->createMock(ContainerInterface::class);

        $templatingMock =$this->createMock(\Twig_Environment::class);
        $containerMock->expects($this->once())
            ->method('has')
            ->with('templating')
            ->willReturn(true);
        $containerMock->expects($this->once())
            ->method('get')
            ->with('templating')
            ->willReturn($templatingMock);

        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $requestMock */
        $requestMock = $this->createMock(Request::class);

        // test
        $classUnderTest = new PostController($entityManagerMock);
        $classUnderTest->setContainer($containerMock);

        $result = $classUnderTest->indexAction($requestMock);

        // verified with mock calls
    }

    /**
     * @test
     */
    public function createAction_test()
    {
        // prepare
        /** @var EntityManager|\PHPUnit_Framework_MockObject_MockObject $entityManagerMock */
        $entityManagerMock = $this->createMock(EntityManager::class);

        /** @var PostRepository|\PHPUnit_Framework_MockObject_MockObject $postRepositoryMock */
        $postRepositoryMock = $this->createMock(PostRepository::class);

        /** @var Collection|\PHPUnit_Framework_MockObject_MockObject $postCollectionMock */
        $postCollectionMock=$this->createMock(Collection::class);

        $postsMock = [
            $this->createMock(Post::class),
            $this->createMock(Post::class)
        ];
        $postCollectionMock->expects($this->once())
            ->method('getValues')
            ->willReturn([$postsMock]);
        $postRepositoryMock->expects($this->once())
            ->method('matching')
            ->willReturn($postCollectionMock);

        /** @var LanguageRepository|\PHPUnit_Framework_MockObject_MockObject $languageRepositoryMock */
        $languageRepositoryMock = $this->createMock(LanguageRepository::class);

        /** @var Collection|\PHPUnit_Framework_MockObject_MockObject $collectionMock */
        $collectionMock = $this->createMock(Collection::class);
        /** @var Language|\PHPUnit_Framework_MockObject_MockObject $languageMock */
        $languageMock = $this->createMock(Language::class);
        $collectionMock->expects($this->once())
            ->method('getValues')
            ->willReturn([$languageMock]);
        $languageRepositoryMock->expects($this->once())
            ->method('matching')
            ->willReturn($collectionMock);

        $entityManagerMock->expects($this->at(0))
            ->method('getRepository')
            ->with(Post::class)
            ->willReturn($postRepositoryMock);
        $entityManagerMock->expects($this->at(1))
            ->method('getRepository')
            ->with(Language::class)
            ->willReturn($languageRepositoryMock);

        /** @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject $containerMock */
        $containerMock = $this->createMock(ContainerInterface::class);

        $templatingMock =$this->createMock(\Twig_Environment::class);
        $containerMock->expects($this->once())
            ->method('has')
            ->with('templating')
            ->willReturn(true);
        $containerMock->expects($this->once())
            ->method('get')
            ->with('templating')
            ->willReturn($templatingMock);

        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $requestMock */
        $requestMock = $this->createMock(Request::class);

        // test
        $classUnderTest = new PostController($entityManagerMock);
        $classUnderTest->setContainer($containerMock);

        $result = $classUnderTest->createAction($requestMock);

        // verified with mock calls
    }

    /**
     * @test
     */
    public function saveAction_test()
    {
        // prepare
        /** @var EntityManager|\PHPUnit_Framework_MockObject_MockObject $entityManagerMock */
        $entityManagerMock = $this->createMock(EntityManager::class);

        /** @var PostRepository|\PHPUnit_Framework_MockObject_MockObject $postRepositoryMock */
        $postRepositoryMock = $this->createMock(PostRepository::class);

        $translationOfPostMock = $this->createMock(Post::class);
        $translationOfPostMock->expects($this->once())
            ->method('setTranslatedPost')
            ->willReturn(true);

        $postDataMock = [
            'title' => 'some title',
            'content' => 'some content',
            'translationOfPost' => 123
        ];

        $postRepositoryMock->expects($this->once())
            ->method('find')
            ->willReturn($translationOfPostMock);

        /** @var LanguageRepository|\PHPUnit_Framework_MockObject_MockObject $languageRepositoryMock */
        $languageRepositoryMock = $this->createMock(LanguageRepository::class);

        /** @var Collection|\PHPUnit_Framework_MockObject_MockObject $collectionMock */
        $collectionMock = $this->createMock(Collection::class);
        /** @var Language|\PHPUnit_Framework_MockObject_MockObject $languageMock */
        $languageMock = $this->createMock(Language::class);
        $collectionMock->expects($this->once())
            ->method('getValues')
            ->willReturn([$languageMock]);
        $languageRepositoryMock->expects($this->once())
            ->method('matching')
            ->willReturn($collectionMock);

        $entityManagerMock->expects($this->at(0))
            ->method('getRepository')
            ->with(Post::class)
            ->willReturn($postRepositoryMock);
        $entityManagerMock->expects($this->at(1))
            ->method('getRepository')
            ->with(Language::class)
            ->willReturn($languageRepositoryMock);

        /** @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject $containerMock */
        $containerMock = $this->createMock(ContainerInterface::class);

        $containerMock->expects($this->at(0))
            ->method('has')
            ->with('security.token_storage')
            ->willReturn(true);
        $tokenStorageInterface = $this->createMock(TokenStorageInterface::class);
        $tokenInterfaceMock = $this->createMock(TokenInterface::class);
        $tokenInterfaceMock->expects($this->once())
            ->method('getUser')
            ->willReturn($this->createMock(User::class));
        $tokenStorageInterface->expects($this->once())
            ->method('getToken')
            ->willReturn($tokenInterfaceMock);

        $containerMock->expects($this->at(1))
            ->method('get')
            ->with('security.token_storage')
            ->willReturn($tokenStorageInterface);

        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $requestMock */
        $requestMock = $this->createMock(Request::class);

        /** @var ParameterBag|\PHPUnit_Framework_MockObject_MockObject $parameterBagMock */
        $parameterBagMock = $this->createMock(ParameterBag::class);

        $requestMock->request = $parameterBagMock;

        $parameterBagMock->expects($this->once())
            ->method('all')
            ->willReturn($postDataMock);

        // test
        $classUnderTest = new PostController($entityManagerMock);
        $classUnderTest->setContainer($containerMock);

        $result = $classUnderTest->saveAction($requestMock);

        // verified with mock calls
    }

    /**
     * @test
     */
    public function show_test()
    {
        // prepare
        /** @var EntityManager|\PHPUnit_Framework_MockObject_MockObject $entityManagerMock */
        $entityManagerMock = $this->createMock(EntityManager::class);

        /** @var PostRepository|\PHPUnit_Framework_MockObject_MockObject $postRepositoryMock */
        $postRepositoryMock = $this->createMock(PostRepository::class);

        /** @var Collection|\PHPUnit_Framework_MockObject_MockObject $postCollectionMock */
        $postCollectionMock=$this->createMock(Collection::class);

        $postMock = $this->createMock(Post::class);

        $slug = 'some-slug';

        $postCollectionMock->expects($this->once())
            ->method('getValues')
            ->willReturn([$postMock]);
        $postRepositoryMock->expects($this->once())
            ->method('matching')
            ->willReturn($postCollectionMock);

        /** @var LanguageRepository|\PHPUnit_Framework_MockObject_MockObject $languageRepositoryMock */
        $languageRepositoryMock = $this->createMock(LanguageRepository::class);

        /** @var Collection|\PHPUnit_Framework_MockObject_MockObject $collectionMock */
        $collectionMock = $this->createMock(Collection::class);
        /** @var Language|\PHPUnit_Framework_MockObject_MockObject $languageMock */
        $languageMock = $this->createMock(Language::class);
        $collectionMock->expects($this->once())
            ->method('getValues')
            ->willReturn([$languageMock]);
        $languageRepositoryMock->expects($this->once())
            ->method('matching')
            ->willReturn($collectionMock);

        $entityManagerMock->expects($this->at(0))
            ->method('getRepository')
            ->with(Post::class)
            ->willReturn($postRepositoryMock);
        $entityManagerMock->expects($this->at(1))
            ->method('getRepository')
            ->with(Language::class)
            ->willReturn($languageRepositoryMock);

        /** @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject $containerMock */
        $containerMock = $this->createMock(ContainerInterface::class);

        $templatingMock =$this->createMock(\Twig_Environment::class);
        $containerMock->expects($this->once())
            ->method('has')
            ->with('templating')
            ->willReturn(true);
        $containerMock->expects($this->once())
            ->method('get')
            ->with('templating')
            ->willReturn($templatingMock);

        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $requestMock */
        $requestMock = $this->createMock(Request::class);

        // test
        $classUnderTest = new PostController($entityManagerMock);
        $classUnderTest->setContainer($containerMock);

        $result = $classUnderTest->showAction($requestMock, $slug);

        // verified with mock calls
    }

    /**
     * @test
     */
    public function edit_test()
    {
        // prepare
        /** @var EntityManager|\PHPUnit_Framework_MockObject_MockObject $entityManagerMock */
        $entityManagerMock = $this->createMock(EntityManager::class);

        /** @var PostRepository|\PHPUnit_Framework_MockObject_MockObject $postRepositoryMock */
        $postRepositoryMock = $this->createMock(PostRepository::class);

        /** @var Collection|\PHPUnit_Framework_MockObject_MockObject $postCollectionMock */
        $postCollectionMock=$this->createMock(Collection::class);

        $postMock = $this->createMock(Post::class);

        $postsMock = [
            $this->createMock(Post::class),
            $this->createMock(Post::class)
        ];
        $postCollectionMock->expects($this->at(0))
            ->method('getValues')
            ->willReturn([$postsMock]);
        $postRepositoryMock->expects($this->at(0))
            ->method('matching')
            ->willReturn($postCollectionMock);

        $slug = 'some-slug';
        $postCollectionMock->expects($this->at(1))
            ->method('getValues')
            ->willReturn([$postMock]);
        $postRepositoryMock->expects($this->at(1))
            ->method('matching')
            ->willReturn($postCollectionMock);

        /** @var LanguageRepository|\PHPUnit_Framework_MockObject_MockObject $languageRepositoryMock */
        $languageRepositoryMock = $this->createMock(LanguageRepository::class);

        /** @var Collection|\PHPUnit_Framework_MockObject_MockObject $collectionMock */
        $collectionMock = $this->createMock(Collection::class);
        /** @var Language|\PHPUnit_Framework_MockObject_MockObject $languageMock */
        $languageMock = $this->createMock(Language::class);
        $collectionMock->expects($this->once())
            ->method('getValues')
            ->willReturn([$languageMock]);
        $languageRepositoryMock->expects($this->once())
            ->method('matching')
            ->willReturn($collectionMock);

        $entityManagerMock->expects($this->at(0))
            ->method('getRepository')
            ->with(Post::class)
            ->willReturn($postRepositoryMock);
        $entityManagerMock->expects($this->at(1))
            ->method('getRepository')
            ->with(Language::class)
            ->willReturn($languageRepositoryMock);

        /** @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject $containerMock */
        $containerMock = $this->createMock(ContainerInterface::class);

        $templatingMock =$this->createMock(\Twig_Environment::class);
        $containerMock->expects($this->once())
            ->method('has')
            ->with('templating')
            ->willReturn(true);
        $containerMock->expects($this->once())
            ->method('get')
            ->with('templating')
            ->willReturn($templatingMock);

        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $requestMock */
        $requestMock = $this->createMock(Request::class);

        // test
        $classUnderTest = new PostController($entityManagerMock);
        $classUnderTest->setContainer($containerMock);

        $result = $classUnderTest->editAction($requestMock, $slug);

        // verified with mock calls
    }

    /**
     * @test
     */
    public function updateAction_test()
    {
        // prepare
        $postId = 123;

        /** @var EntityManager|\PHPUnit_Framework_MockObject_MockObject $entityManagerMock */
        $entityManagerMock = $this->createMock(EntityManager::class);

        /** @var PostRepository|\PHPUnit_Framework_MockObject_MockObject $postRepositoryMock */
        $postRepositoryMock = $this->createMock(PostRepository::class);

        $translationOfPostMock = $this->createMock(Post::class);
        $translationOfPostMock->expects($this->once())
            ->method('setTranslatedPost')
            ->willReturn(true);

        $postMock = $this->createMock(Post::class);
        $postDataMock = [
            'title' => 'some title',
            'content' => 'some content',
            'translationOfPost' => 123
        ];

        $postRepositoryMock->expects($this->at(0))
            ->method('find')
            ->willReturn($postMock);
        $postRepositoryMock->expects($this->at(1))
            ->method('find')
            ->willReturn($translationOfPostMock);

        /** @var LanguageRepository|\PHPUnit_Framework_MockObject_MockObject $languageRepositoryMock */
        $languageRepositoryMock = $this->createMock(LanguageRepository::class);

        $entityManagerMock->expects($this->at(0))
            ->method('getRepository')
            ->with(Post::class)
            ->willReturn($postRepositoryMock);
        $entityManagerMock->expects($this->at(1))
            ->method('getRepository')
            ->with(Language::class)
            ->willReturn($languageRepositoryMock);

        /** @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject $containerMock */
        $containerMock = $this->createMock(ContainerInterface::class);

        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $requestMock */
        $requestMock = $this->createMock(Request::class);

        /** @var ParameterBag|\PHPUnit_Framework_MockObject_MockObject $parameterBagMock */
        $parameterBagMock = $this->createMock(ParameterBag::class);

        $requestMock->request = $parameterBagMock;

        $parameterBagMock->expects($this->once())
            ->method('all')
            ->willReturn($postDataMock);

        // test
        $classUnderTest = new PostController($entityManagerMock);
        $classUnderTest->setContainer($containerMock);

        $result = $classUnderTest->updateAction($requestMock, $postId);

        // verified with mock calls
    }
}
