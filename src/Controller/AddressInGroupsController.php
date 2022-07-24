<?php

namespace AddressBook\Controller;

use AddressBook\Entity\AddressInGroups;
use AddressBook\Form\AddressInGroupsType;
use AddressBook\Repository\AddressInGroupsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/address/in/groups')]
class AddressInGroupsController extends AbstractController
{
    #[Route('/', name: 'app_address_in_groups_index', methods: ['GET'])]
    public function index(AddressInGroupsRepository $addressInGroupsRepository): Response
    {
        return $this->render('address_in_groups/index.html.twig', [
            'address_in_groups' => $addressInGroupsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_address_in_groups_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AddressInGroupsRepository $addressInGroupsRepository): Response
    {
        $addressInGroup = new AddressInGroups();
        $form = $this->createForm(AddressInGroupsType::class, $addressInGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addressInGroupsRepository->add($addressInGroup, true);

            return $this->redirectToRoute('app_address_in_groups_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address_in_groups/new.html.twig', [
            'address_in_group' => $addressInGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_address_in_groups_show', methods: ['GET'])]
    public function show(AddressInGroups $addressInGroup): Response
    {
        return $this->render('address_in_groups/show.html.twig', [
            'address_in_group' => $addressInGroup,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_address_in_groups_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AddressInGroups $addressInGroup, AddressInGroupsRepository $addressInGroupsRepository): Response
    {
        $form = $this->createForm(AddressInGroupsType::class, $addressInGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addressInGroupsRepository->add($addressInGroup, true);

            return $this->redirectToRoute('app_address_in_groups_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address_in_groups/edit.html.twig', [
            'address_in_group' => $addressInGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_address_in_groups_delete', methods: ['POST'])]
    public function delete(Request $request, AddressInGroups $addressInGroup, AddressInGroupsRepository $addressInGroupsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$addressInGroup->getId(), $request->request->get('_token'))) {
            $addressInGroupsRepository->remove($addressInGroup, true);
        }

        return $this->redirectToRoute('app_address_in_groups_index', [], Response::HTTP_SEE_OTHER);
    }
}
