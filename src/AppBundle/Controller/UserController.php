<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @IsGranted("ROLE_ADMIN", message="No access! Get out!")
 */
class UserController extends Controller
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $entityManager->getRepository(User::class);
    }

    /**
     * @Route("/admin/users", name="users")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $users = $this->userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin/users/create", name="create-user")
     * @Method({"GET"})
     */
    public function createAction()
    {
        $roles = [
            "ROLE_USER" =>"ROLE_USER",
            "ROLE_ADMIN" => "ROLE_ADMIN"
        ];
        return $this->render('user/create.html.twig', [
            'roles' => $roles,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin/users", name="save-user")
     * @Method({"POST"})
     */
    public function saveAction(Request $request)
    {
        $postData = $request->request->all();

        $user = new User();
        $user->setUsername($postData['username']);
        $user->setEmail($postData['email']);
        $user->setPlainPassword($postData['password']);
        $user->setEnabled(true);
        $user->addRole($postData['role']);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
        }

        return $this->redirect('users');
    }

    /**
     * @Route("/admin/users/{id}/edit", name="edit-user")
     * @Method({"GET"})
     */
    public function editAction(Request $request, $id)
    {
        $user = $this->userRepository->find($id);

        $roles = [
            "ROLE_USER" =>"ROLE_USER",
            "ROLE_ADMIN" => "ROLE_ADMIN"
        ];

        return $this->render('user/edit.html.twig', [
            'roles' => $roles,
            'user' => $user,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
//        return $this->redirect('/' . $request->getLocale() . '/admin/users');
    }

    /**
     * @Route("/admin/users/{id}", name="update-user")
     * @Method({"POST"})
     */
    public function updateAction(Request $request, $id)
    {
        $postData = $request->request->all();

        /** @var User $user */
        $user = $this->userRepository->find($id);
        $user->setUsername($postData['username']);
        $user->setEmail($postData['email']);
        if (!empty($postData['password'])){
            $user->setPlainPassword($postData['password']);
        }
        $user->setRoles($postData['role']);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
        }

        return $this->redirect('/' . $request->getLocale() . '/admin/users');
    }
}
