<?php

namespace App\Repository;

use App\Entity\Location;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 *
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function save(Location $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Location $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Location[] Returns an array of Location objects
//     */
    public function usersLocationId(int $userId): array
    {
        return $this->createQueryBuilder('lu')
        // ->select('location_user')
        // ->from('location_user')
        // ->leftJoin('b.user', 'u')
        // ->andWhere('b.user = :id')
        // ->setParameter('id', $userId)
        // ->orderBy('b.id', 'ASC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult();
       
    }
    

    //createQueryBuilder
    public function findAllLocation(): array
    {

        return $this->createQueryBuilder('l')
            //    ->andWhere('l.exampleField = :val')
            //    ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

   //createQueryBuilder
   public function findOneBySomeField($value): ?Location
   {
       return $this->createQueryBuilder('l')
           ->andWhere('l.exampleField = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
    //row query
    public function findByUserId(int $userId): ? array
    {
        
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM `location_user` LEFT JOIN user on user.id=location_user.user_id LEFT JOIN location on location.id=location_user.location_id WHERE location_user.user_id > :id;
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $userId]);
        
        return $resultSet->fetchAllAssociative();

    }
    //row query
    public function findByUser(): ? array
    {
        
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM `location_user` LEFT JOIN user on user.id=location_user.user_id LEFT JOIN location on location.id=location_user.location_id;
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();

    }
}
