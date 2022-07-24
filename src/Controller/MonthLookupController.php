<?php

namespace AddressBook\Controller;

use AddressBook\Entity\MonthLookup;
use AddressBook\Form\MonthLookupType;
use AddressBook\Repository\MonthLookupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/month/lookup')]
class MonthLookupController extends AbstractController
{
    #[Route('/', name: 'app_month_lookup_index', methods: ['GET'])]
    public function index(MonthLookupRepository $monthLookupRepository): Response
    {
        return $this->render('month_lookup/index.html.twig', [
            'month_lookups' => $monthLookupRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_month_lookup_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MonthLookupRepository $monthLookupRepository): Response
    {
        $monthLookup = new MonthLookup();
        $form = $this->createForm(MonthLookupType::class, $monthLookup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $monthLookupRepository->add($monthLookup, true);

            return $this->redirectToRoute('app_month_lookup_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('month_lookup/new.html.twig', [
            'month_lookup' => $monthLookup,
            'form' => $form,
        ]);
    }

    #[Route('/{bmonthNum}', name: 'app_month_lookup_show', methods: ['GET'])]
    public function show(MonthLookup $monthLookup): Response
    {
        return $this->render('month_lookup/show.html.twig', [
            'month_lookup' => $monthLookup,
        ]);
    }

    #[Route('/{bmonthNum}/edit', name: 'app_month_lookup_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MonthLookup $monthLookup, MonthLookupRepository $monthLookupRepository): Response
    {
        $form = $this->createForm(MonthLookupType::class, $monthLookup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $monthLookupRepository->add($monthLookup, true);

            return $this->redirectToRoute('app_month_lookup_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('month_lookup/edit.html.twig', [
            'month_lookup' => $monthLookup,
            'form' => $form,
        ]);
    }

    #[Route('/{bmonthNum}', name: 'app_month_lookup_delete', methods: ['POST'])]
    public function delete(Request $request, MonthLookup $monthLookup, MonthLookupRepository $monthLookupRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$monthLookup->getBmonthNum(), $request->request->get('_token'))) {
            $monthLookupRepository->remove($monthLookup, true);
        }

        return $this->redirectToRoute('app_month_lookup_index', [], Response::HTTP_SEE_OTHER);
    }
}
