<?php

namespace App\Controller;

use App\Entity\ScanRead;
use App\Form\ScanReadForm;
use App\Repository\ScanReadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/scan/read')]
final class ScanReadController extends AbstractController
{
    #[Route(name: 'app_scan_read_index', methods: ['GET'])]
    public function index(ScanReadRepository $scanReadRepository): Response
    {
        $scanReads = $scanReadRepository->findAllByUser($this->getUser());

        return $this->render('scan_read/index.html.twig', [
            'scan_reads' => $scanReads,
        ]);
    }

    #[Route('/new', name: 'app_scan_read_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scanRead = new ScanRead();
        $form = $this->createForm(ScanReadForm::class, $scanRead);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($scanRead);
            $entityManager->flush();

            return $this->redirectToRoute('app_scan_read_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scan_read/new.html.twig', [
            'scan_read' => $scanRead,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scan_read_show', methods: ['GET'])]
    public function show(ScanRead $scanRead): Response
    {
        return $this->render('scan_read/show.html.twig', [
            'scan_read' => $scanRead,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_scan_read_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ScanRead $scanRead, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ScanReadForm::class, $scanRead);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_scan_read_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scan_read/edit.html.twig', [
            'scan_read' => $scanRead,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scan_read_delete', methods: ['POST'])]
    public function delete(Request $request, ScanRead $scanRead, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scanRead->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($scanRead);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_scan_read_index', [], Response::HTTP_SEE_OTHER);
    }
}
