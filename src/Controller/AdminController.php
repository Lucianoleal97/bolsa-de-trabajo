<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType2;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(UserRepository $userRepository,  PaginatorInterface $paginator, Request $request, SessionInterface $session): Response
    {
        $pagination = $this->pagination($paginator, $request, $session, 0);
        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
            'pagination' => $pagination,
            'page'=>$pagination->getCurrentPageNumber(),
        ]);
    }

    #[Route('/admin/{page<\d*>}', name: 'admin_page')]
    public function index_page(UserRepository $userRepository,  PaginatorInterface $paginator, Request $request, SessionInterface $session, int $page): Response
    {
        $pagination = $this->pagination($paginator, $request, $session, $page);
        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
            'pagination' => $pagination,
            'page'=>$pagination->getCurrentPageNumber(),
        ]);
    }
    /**
     * @Route("/{id}", name="admin_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/list", name="admin_list")
     */
    public function list( Request $request, PaginatorInterface $paginator, SessionInterface $session )
    {

        $pagination = $this->pagination( $paginator, $request, $session, 0 );

        // Render the twig view
        /*return $this->render('usuario/index.twig',
                ['pagination' => $pagination]
            );*/
        return $this->render('admin/index.twig',
            ['pagination' => $pagination, 'page'=>$pagination->getCurrentPageNumber() ]
        );


    }

    /**
     * @Route("/list/{page<\d*>}", name="admin_list_page")
     */
    public function list_page( Request $request, PaginatorInterface $paginator, SessionInterface $session, int $page )
    {

        $pagination = $this->pagination( $paginator, $request, $session, $page );

        // Render the twig view
        /*return $this->render('usuario/index.twig',
                ['pagination' => $pagination]
            );*/
        return $this->render('admin/index.twig',
            ['pagination' => $pagination, 'page'=>$page ]
        );


    }

    function pagination( PaginatorInterface $paginator, Request $request, SessionInterface $session, int $page)
    {
        //$session = new Session();
        //$session->start();

        //$page=$paginator->getCurrentPageNumber();
        //echo "page ".$page."<br>";

        // Retrieve the entity manager of Doctrine
        $em = $this->getDoctrine()->getManager();

        // Get some repository of data, in our case we have an Appointments entity
        $usuariosRepository = $em->getRepository(user::class);

        // Find all the data on the Appointments table, filter your query as you need
        //->where('p.activo != :activo')
        //->setParameter('activo', '1')

        $allUsuariosQuery = $usuariosRepository->createQueryBuilder('p')
            ->orderBy('p.nombre')
            ->getQuery();

        //echo "request ".$request->query->getInt('page', 1)."<br>";
        //echo "page1 ".$page."<br>";
        if( $page >0 )
            $indice=$page;
        else
            $indice=$request->query->getInt('page', 1);

        // Paginate the results of the query
        $pagination = $paginator->paginate(
        // Doctrine Query, not results
            $allUsuariosQuery,
            // Define the page parameter
            $indice,
            // Items per page
            10
        );

        $pagination->setTemplate('admin/my_pagination.html.twig');

        return $pagination;

    }
}
