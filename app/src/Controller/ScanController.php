<?php

namespace App\Controller;

use App\Entity\Scan;
use App\Form\ScanForm;
use App\Repository\ScanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/scan')]
final class ScanController extends AbstractController
{
    #[Route(name: 'app_scan_index', methods: ['GET'])]
    public function index(ScanRepository $scanRepository): Response
    {
        return $this->render('scan/index.html.twig', [
            'scans' => $scanRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_scan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scan = new Scan();
        $form = $this->createForm(ScanForm::class, $scan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($scan);
            $entityManager->flush();

            return $this->redirectToRoute('app_scan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scan/new.html.twig', [
            'scan' => $scan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scan_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Scan $scan): Response
    {
        return $this->render('scan/show.html.twig', [
            'scan' => $scan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_scan_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, Scan $scan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ScanForm::class, $scan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_scan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scan/edit.html.twig', [
            'scan' => $scan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scan_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Scan $scan, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scan->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($scan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_scan_index', [], Response::HTTP_SEE_OTHER);
    }
}
