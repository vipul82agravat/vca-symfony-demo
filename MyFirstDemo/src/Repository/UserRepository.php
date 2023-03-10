<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user_entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($user_entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $user_entity, bool $flush = false): void
    {
        
        $this->getEntityManager()->remove($user_entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return User[] Returns an array of User objects
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

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    //custom quey for get the all user after the match  $id for user table  createQueryBuilder set query  getQuery query and execute query user
    public function findAllUser(): array
    {
        $qb = $this->createQueryBuilder('u')
            // ->where('u.id >= :id')
            // ->setParameter('id', $id)
            ->orderBy('u.name', 'ASC');

        $query = $qb->getQuery();
        return $query->execute();
    }
     //SQl custom quey for get the all user after the match  $id for user table  createQueryBuilder set query  getQuery query and execute query user
     public function findAllUserSql(int $id): array
     {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM user u
            WHERE u.id > :id
            ORDER BY u.name ASC
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
     }
     //SQl custom quey for get the all user after the match  $id for user table  createQueryBuilder set query  getQuery query and execute query user
     public function findAll(): array
     {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM user u
            ORDER BY u.name ASC
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
     }
     //SQl custom quey for get the all user after the match  $id for user table  createQueryBuilder set query  getQuery query and execute query user
     public function getUSerWorks(): array
     {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM `user` LEFT JOIN users_work on user.id=users_work.user_id;
            ';
        // $sql = '
        // SELECT * FROM `user` LEFT JOIN users_work on user.id=users_work.user_id LEFT JOIN country on country.id=user.country_id;
        //     ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
     }
}
