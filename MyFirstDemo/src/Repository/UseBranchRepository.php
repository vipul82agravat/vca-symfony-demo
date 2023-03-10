<?php

namespace App\Repository;

use App\Entity\UseBranch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UseBranch>
 *
 * @method UseBranch|null find($id, $lockMode = null, $lockVersion = null)
 * @method UseBranch|null findOneBy(array $criteria, array $orderBy = null)
 * @method UseBranch[]    findAll()
 * @method UseBranch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UseBranchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UseBranch::class);
    }

    public function save(UseBranch $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UseBranch $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UseBranch[] Returns an array of UseBranch objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UseBranch
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
   public function findAllBranch($value): array
   {
       return $this->createQueryBuilder('u')
        //    ->andWhere('u.exampleField = :val')
        //    ->setParameter('val', $value)
           ->orderBy('u.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

}
