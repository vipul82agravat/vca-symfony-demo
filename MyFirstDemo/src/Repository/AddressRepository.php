<?php

namespace App\Repository;

use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Address>
 *
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    public function save(Address $entity, bool $flush = false): void
    {
        
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Address $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Address[] Returns an array of Address objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Address
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
        //createQueryBuilder
        public function findAllUserAddress(): array
        {
            return $this->createQueryBuilder('a')
                ->orderBy('a.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }

        //createQueryBuilder
        public function findOneByIdJoinedToAddress(int $userId): ? array
        {
            return $this->createQueryBuilder('a')
                       ->andWhere('a.user = :id')
                       ->setParameter('id', $userId)
                       ->orderBy('a.id', 'ASC')
                       ->setMaxResults(10)
                       ->getQuery()
                       ->getResult()
                   ;
    
        }
        
        //row query
        public function findAllByJoinedToAddress(): ? array
        {
            $conn = $this->getEntityManager()->getConnection();

            $sql = '
                SELECT * FROM `user` LEFT JOIN address on user.id=address.user_id;
                ';
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            
            return $resultSet->fetchAllAssociative();
    
        }
        //row query
        public function findOneByIdRightJoinedToAddress(int $userId): ? array
        {
            $conn = $this->getEntityManager()->getConnection();

            $sql = '
                SELECT * FROM `user` RIGHT JOIN address on user.id=address.user_id WHERE user.id > :id;
                ';
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery(['id' => $userId]);
            
            return $resultSet->fetchAllAssociative();
    
        }
       
}
