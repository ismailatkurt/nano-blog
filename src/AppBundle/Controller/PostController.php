<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Language;
use AppBundle\Entity\Post;
use AppBundle\Repository\LanguageRepository;
use AppBundle\Repository\PostRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $entityManager->getRepository(Post::class);
        $this->languageRepository = $entityManager->getRepository(Language::class);
    }

    /**
     * @Route("/admin/posts", name="posts")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $language = $this->getLanguage($request, true);

        $criteria = new Criteria();
        $expr = Criteria::expr();
        $criteria->where($expr->eq('language', $language));

        $posts = $this->postRepository->matching($criteria)->getValues();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin/posts/create", name="create-post")
     * @IsGranted("ROLE_ADMIN", message="No access! Get out!")
     * @Method({"GET"})
     */
    public function createAction(Request $request)
    {
        $language = $this->getLanguage($request, false);

        $criteria = new Criteria();
        $criteria->andWhere(Criteria::expr()->eq('language', $language));
        $criteria->andWhere(Criteria::expr()->isNull('translatedPost'));
        $posts = $this->postRepository->matching($criteria)->getValues();

        $content = '';
        return $this->render('post/create.html.twig', [
            'posts' => $posts,
            'content' => $content,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin/posts", name="save-post")
     * @IsGranted("ROLE_ADMIN", message="No access! Get out!")
     * @Method({"POST"})
     */
    public function saveAction(Request $request)
    {
        $postData = $request->request->all();
        $post = new Post();
        $post->setTitle($postData['title']);
        $post->setSlug(preg_replace('/[^A-Za-z0-9-]+/', '-', $postData['title']));
        $post->setContent($postData['content']);
        $post->setAuthor($this->getUser());
        $post->setCreatedAt(new \DateTime('now'));

        $language = $this->getLanguage($request, true);
        $post->setLanguage($language);

        $translationOfPost = null;
        if (!empty($postData['translationOfPost'])) {
            $translationOfPost = $this->postRepository->find($postData['translationOfPost']);
            $post->setTranslatedPost($translationOfPost);
            $translationOfPost->setTranslatedPost($post);
            $this->entityManager->persist($translationOfPost);
        }

        try {
            $this->entityManager->persist($post);
            $this->entityManager->flush();

        } catch (\Exception $exception) {
        }

        return $this->redirect('posts');
    }

    /**
     * @Route("/admin/posts/{slug}", name="show-post")
     * @Method({"GET"})
     */
    public function showAction(Request $request, $slug)
    {
        $language = $this->getLanguage($request, true);

        $criteria = new Criteria();
        $expr = Criteria::expr();
        $criteria->where($expr->eq('language', $language));
        $criteria->where($expr->eq('slug', $slug));

        /** @var Post $post */
        $post = $this->postRepository->matching($criteria)->getValues()[0];

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin/posts/{slug}/edit", name="edit-post")
     * @Method({"GET"})
     */
    public function editAction(Request $request, $slug)
    {
        $language = $this->getLanguage($request, true);

        $criteria = new Criteria();
        $criteria->andWhere(Criteria::expr()->neq('language', $language));
        $posts = $this->postRepository->matching($criteria)->getValues();

        $criteria = new Criteria();
        $expr = Criteria::expr();
        $criteria->where($expr->eq('language', $language));
        $criteria->where($expr->eq('slug', $slug));

        /** @var Post $post */
        $post = $this->postRepository->matching($criteria)->getValues()[0];

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'posts' => $posts,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin/posts/{id}", name="update-post")
     * @Method({"POST"})
     */
    public function updateAction(Request $request, $id)
    {
        $postData = $request->request->all();

        $post = $this->postRepository->find($id);
        $post->setTitle($postData['title']);
        $post->setSlug(preg_replace('/[^A-Za-z0-9-]+/', '-', $postData['title']));
        $post->setContent($postData['content']);

        $translationOfPost = null;
        if (!empty($postData['translationOfPost'])) {
            $translationOfPost = $this->postRepository->find($postData['translationOfPost']);
            $post->setTranslatedPost($translationOfPost);
            $translationOfPost->setTranslatedPost($post);
            $this->entityManager->persist($translationOfPost);
        } else {
            $post->setTranslatedPost(null);
        }

        try {
            $this->entityManager->persist($post);
            $this->entityManager->flush();

        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
        }

        return $this->redirect('/' . $request->getLocale() . '/admin/posts');
    }

    /**
     * @param Request $request
     * @return Language
     */
    protected function getLanguage(Request $request, $current = true)
    {
        $criteria = new Criteria();

        if ($current) {
            $criteria->where(Criteria::expr()->eq('name', $request->getLocale()));
        } else {
            $criteria->where(Criteria::expr()->neq('name', $request->getLocale()));
        }

        /** @var Language $language */
        $language = $this->languageRepository->matching($criteria)->getValues()[0];

        return $language;
    }
}
