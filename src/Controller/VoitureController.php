<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/voiture")
 */
class VoitureController extends AbstractController
{
    /**
     * @Route("/", name="voiture_index", methods={"GET"})
     */
    public function index(VoitureRepository $voitureRepository): Response
    {
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="voiture_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $publicPath = $this->getParameter('public_path');
            $imageId = uniqid();

            $file = new File($voiture->getPhoto());

            $imageName = $imageId.'.'.$file->guessExtension();
            $file->move(
                $publicPath.'/images',
                $imageName
            );

            $voiture->setPhoto($imageName);
            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('voiture_index');
        }

        return $this->render('voiture/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voiture_show", methods={"GET"})
     */
    public function show(Voiture $voiture): Response
    {
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="voiture_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     *
     * @param mixed $id
     */
    public function edit(Request $request, Voiture $voiture, $id): Response
    {
        $oldImage = $this->getDoctrine()->getRepository(Voiture::class)
            ->find($id)->getPhoto();

        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            if ($oldImage) {
                $oldImage = $this->getDoctrine()->getRepository(Voiture::class)
                    ->find($id)->getPhoto();

                $publicPath = $this->getParameter('public_path');
                $imageId = uniqid();

                $file = new File($voiture->getPhoto());

                $imageName = $imageId.'.'.$file->guessExtension();

                $file->move(
                    $publicPath.'/images',
                    $imageName
                );

                $voiture->setPhoto($imageName);
                unlink($publicPath.'/images/'.$oldImage);
            }

            return $this->redirectToRoute('voiture_index');
        }

        return $this->render('voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voiture_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Voiture $voiture): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voiture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($voiture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('voiture_index');
    }
}
