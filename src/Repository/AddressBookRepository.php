<?php

namespace AddressBook\Repository;

use AddressBook\Entity\AddressBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AddressBook>
 *
 * @method AddressBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method AddressBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method AddressBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AddressBook::class);
    }

    /**
     * @return array<AddressBook>
     */
    public function findAll(): array
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where($qb->expr()->isNull('a.deprecated'));

        return $qb->getQuery()->getResult();
    }

    public function add(AddressBook $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AddressBook $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
