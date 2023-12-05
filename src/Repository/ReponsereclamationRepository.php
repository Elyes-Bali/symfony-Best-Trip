<?php

namespace App\Repository;

use App\Entity\Reponsereclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reponsereclamation>
 *
 * @method Reponsereclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reponsereclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reponsereclamation[]    findAll()
 * @method Reponsereclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponsereclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reponsereclamation::class);
    }

//    /**
//     * @return Reponsereclamation[] Returns an array of Reponsereclamation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reponsereclamation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

  // Custom method to fetch all Reclamation records with their associated responses
  public function findAllWithResponses()
  {
      return $this->createQueryBuilder('rr')
          ->leftJoin('rr.idrec', 'r') // Assuming 'idrec' is the association in Reponsereclamation
          ->addSelect('r', 'rr', 'r.emailu', 'r.textrec') // Add other fields as needed
          ->getQuery()
          ->getResult();
  }

  // Custom method to fetch data with associated Reclamation and User
  public function findDataWithReclamationAndUser()
  {
      $sql = 'SELECT user.id, user.Prenom, reclamation.intitule, reponsereclamation.textRepRec, reclamation.idRec
              FROM user
              LEFT JOIN reclamation ON user.id = reclamation.id
              LEFT JOIN reponsereclamation ON reclamation.idRec = reponsereclamation.idRec';

      $em = $this->getEntityManager();
      $query = $em->createNativeQuery($sql, new \Doctrine\ORM\Query\ResultSetMapping());

      return $query->getResult();
  }
}
