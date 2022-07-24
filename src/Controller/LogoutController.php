<?php

namespace AddressBook\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LogoutController extends AbstractController
{
    /**
     * @throws \RuntimeException
     */
    #[Route('/logout', name: 'app_logout', methods: ['GET', 'POST'])]
    public function index(): void
    {
        throw new \RuntimeException('Don\'t forget to activate logout in security.yaml');
    }
}
