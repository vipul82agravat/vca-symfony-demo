<?php

namespace App\Repository;

use App\Entity\UsersWork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsersWork>
 *
 * @method UsersWork|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersWork|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersWork[]    findAll()
 * @method UsersWork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersWorkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersWork::class);
    }

    public function save(UsersWork $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UsersWork $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UsersWork[] Returns an array of UsersWork objects
//     */
    public function findByUserId($value): array
    {
        
        return $this->createQueryBuilder('u')
            ->andWhere('u.user_id = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?UsersWork
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
