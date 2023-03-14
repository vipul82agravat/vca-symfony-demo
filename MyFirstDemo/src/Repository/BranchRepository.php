<?php

namespace App\Repository;

use App\Entity\Branch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Branch>
 *
 * @method Branch|null find($id, $lockMode = null, $lockVersion = null)
 * @method Branch|null findOneBy(array $criteria, array $orderBy = null)
 * @method Branch[]    findAll()
 * @method Branch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BranchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Branch::class);
    }

    public function save(Branch $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Branch $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Branch[] Returns an array of Branch objects
//     */
   public function findAllUserBranch(): array
   {
       return $this->createQueryBuilder('b')
        //    ->andWhere('b.exampleField = :val')
        //    ->setParameter('val', $value)
           ->orderBy('b.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

   public function findOneByIdJoinedToBranch($userId): ?array
   {
       return $this->createQueryBuilder('b')
           ->andWhere('b.user = :id')
           ->setParameter('id', $userId)
           ->orderBy('b.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }
   public function findOneByIdleftJoinedToBranch($userId): ?array
   {
        return $this->createQueryBuilder('bb')
        ->from(Branch::class, 'b')
        ->leftJoin('b.user', 'u')
        ->andWhere('b.user = :id')
        ->setParameter('id', $userId)
        ->orderBy('b.id', 'ASC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult()
    ;
   }
        public function saveBranch($branch,int $userId,$status): ? array
        {
            
            
            
        
            $conn = $this->getEntityManager()->getConnection();

            foreach($branch as $name)
            {
                $sql = "INSERT INTO branch (user_id, name, status)
                        VALUES ('$userId', '$name', '$status')
                        ";
                $stmt = $conn->prepare($sql);
                $resultSet = $stmt->executeQuery();
            }
            return ['status'=>1,'message'=>'Branch Value is store'];

        }
    
}
