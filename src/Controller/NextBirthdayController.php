<?php

declare(strict_types=1);


namespace AddressBook\Controller;

use AddressBook\Entity\MonthLookup;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/birthday/next', name: 'app_next_birthday_index', methods: ['GET'])]
class NextBirthdayController extends AbstractController
{
    public function __invoke(Connection $connection): Response
    {
        $qb = $connection->createQueryBuilder();
        $qb
            ->select('a.*')
            ->addSelect('ml.*')
            ->addSelect('IF(ml.bmonth_num < MONTH(CURDATE()) OR ml.bmonth_num = MONTH(CURDATE()) AND a.bday < DAYOFMONTH(CURDATE()), CONCAT(\' \', YEAR(CURDATE()) + 1), \'\') display_year')
            ->addSelect('IF( ml.bmonth_num < MONTH(CURDATE()) OR ml.bmonth_num = MONTH(CURDATE()) AND a.bday < DAYOFMONTH(CURDATE()), ml.bmonth_num + 12, ml.bmonth_num) * 32 + bday prio')
            ->from('addressbook', 'a')
            ->leftJoin('a', 'month_lookup', 'ml', 'a.bmonth = ml.bmonth')
            ->where('a.bday > :bday')
            ->andWhere($qb->expr()->isNull('a.deprecated'))
            ->setParameter('bday', 0)
            ->orderBy('prio', 'ASC');

        return $this->render('next_birthday/index.html.twig', [
            'birthdays' => $qb->fetchAllAssociative(),
        ]);
    }
}
