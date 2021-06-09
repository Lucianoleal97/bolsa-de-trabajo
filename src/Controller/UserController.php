<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use App\Form\UserType;
use App\Form\UserType2;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request/*, UserPasswordEncoderInterface $encoder*/): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
//            $passwordEncoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setRole(['ROLE_USER']);
//            $user->setPassword($passwordEncoded);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user,UserPasswordEncoderInterface $encoder,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UserType2::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //$passwordEncoded = $encoder->encodePassword($user, $user->getPassword());
            //$user->setPassword($passwordEncoded);
            $cvFile = $form->get('cv')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($cvFile) {
                $originalFilename = pathinfo($cvFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$cvFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $cvFile->move(
                        $this->getParameter('cv_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception("ups! ha ocurrido un error, sorry");
                    }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setcv($newFilename);
            }
            $diplomaFile = $form->get('diploma')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($diplomaFile) {
                $originalFilename = pathinfo($diplomaFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$diplomaFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $diplomaFile->move(
                        $this->getParameter('diploma_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception("ups! ha ocurrido un error, sorry");
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setcv($newFilename);
            }

//            $arrayRoles = $form['roles_in_form']->getData();
//            $roles = $entityManager->getRepository(Role::class)->findAll();
//            foreach ($roles as $role) {
//                if (in_array($role->getId(), $arrayRoles)) {
//                    $user->addRole($role);
//                } else {
//                    $user->removeRole($role);
//                }
//            }
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }


        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
