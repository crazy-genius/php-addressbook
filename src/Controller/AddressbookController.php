<?php

namespace AddressBook\Controller;

use AddressBook\Entity\AddressBook;
use AddressBook\Form\AddressbookType;
use AddressBook\Repository\AddressBookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/addressbook')]
class AddressbookController extends AbstractController
{
    #[Route('/', name: 'app_addressbook_index', methods: ['GET'])]
    public function index(AddressBookRepository $addressBookRepository): Response
    {
        return $this->render('addressbook/index.html.twig', [
            'group_id' => 0,
            'addressbooks' => $addressBookRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_addressbook_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AddressBookRepository $addressbookRepository): Response
    {
        $addressbook = new AddressBook();
        $form = $this->createForm(AddressbookType::class, $addressbook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addressbookRepository->add($addressbook, true);

            return $this->redirectToRoute('app_addressbook_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('addressbook/new.html.twig', [
            'addressbook' => $addressbook,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_addressbook_show', methods: ['GET'])]
    public function show(AddressBook $addressbook): Response
    {
        return $this->render('addressbook/show.html.twig', [
            'addressbook' => $addressbook,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_addressbook_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AddressBook $addressbook, AddressBookRepository $addressbookRepository): Response
    {
        $form = $this->createForm(AddressbookType::class, $addressbook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addressbookRepository->add($addressbook, true);

            return $this->redirectToRoute('app_addressbook_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('addressbook/edit.html.twig', [
            'addressbook' => $addressbook,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_addressbook_delete', methods: ['POST'])]
    public function delete(Request $request, AddressBook $addressbook, AddressBookRepository $addressbookRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$addressbook->getId(), $request->request->get('_token'))) {
            $addressbookRepository->remove($addressbook, true);
        }

        return $this->redirectToRoute('app_addressbook_index', [], Response::HTTP_SEE_OTHER);
    }
}
