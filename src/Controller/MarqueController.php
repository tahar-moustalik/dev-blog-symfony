<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/marque")
 */
class MarqueController extends AbstractController
{
    /**
     * @Route("/", name="marque_index", methods={"GET"})
     */
    public function index(MarqueRepository $marqueRepository): Response
    {
        return $this->render('marque/index.html.twig', [
            'marques' => $marqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="marque_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($marque);
            $entityManager->flush();

            return $this->redirectToRoute('marque_index');
        }

        return $this->render('marque/new.html.twig', [
            'marque' => $marque,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="marque_show", methods={"GET"})
     * @isGranted("ROLE_USER")
     */
    public function show(Marque $marque): Response
    {
        return $this->render('marque/show.html.twig', [
            'marque' => $marque,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="marque_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Marque $marque): Response
    {
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('marque_index');
        }

        return $this->render('marque/edit.html.twig', [
            'marque' => $marque,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="marque_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Marque $marque): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marque->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($marque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('marque_index');
    }
}
