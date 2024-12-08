<?php

namespace App\Repository;

use App\Entity\Reclamation;
use App\Entity\Response;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @method Reclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamation[]    findAll()
 * @method Reclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }

    /**
     * Save a Reclamation entity.
     *
     * @param Reclamation $reclamation
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Reclamation $reclamation): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($reclamation);
        $entityManager->flush();
    }

    /**
     * Delete a Reclamation entity.
     *
     * @param Reclamation $reclamation
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Reclamation $reclamation): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($reclamation);
        $entityManager->flush();
    }

    // Example custom query: Find reclamations by status
    public function findByStatus(string $status): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.statutrec = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult();
    }

    public function findBySearchQuery(string $searchQuery)
    {
        return $this->createQueryBuilder('r')
            ->where('r.name LIKE :search OR r.lastname LIKE :search OR r.descrirec LIKE :search')
            ->setParameter('search', '%'.$searchQuery.'%')
            ->getQuery()
            ->getResult();
    }

  
    //set response to reclamation
    public function setResponse(Reclamation $reclamation, Response $response): void
    {
        $entityManager = $this->getEntityManager();
        $reclamation->addResponse($response);
        $entityManager->persist($reclamation);
        $entityManager->flush();

    }
    

    //total count of reclamations
    public function countReclamations(): int
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.idrec)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    //count of reclamations by status
    public function countReclamationsByStatus(string $status): int
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.idrec)')
            ->andWhere('r.statutrec = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getSingleScalarResult();
    }

    //count of reclamations for every month of 10 last months
    public function countReclamationsByMonth(): array
    {
        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $months = [];
    
        // Initialize months with 0 for the last 10 months
        for ($i = 9; $i >= 0; $i--) {
            $months[date('Y-m', strtotime("-$i months"))] = 0;
        }
    
        $sql = 'SELECT COUNT(r.idrec) AS reclamationCount, 
                       DATE_FORMAT(r.daterec, \'%Y-%m\') AS month
                FROM reclamation r
                WHERE r.daterec >= :startDate
                GROUP BY month
                ORDER BY month ASC';
    
        // Calculate the start date as the first day, 10 months ago
        $startDate = new \DateTime();
        $startDate->modify('-9 months');
        $startDate->setDate($startDate->format('Y'), $startDate->format('m'), 1);
    
        // Execute the query and get a Result object
        $result = $connection->executeQuery($sql, [
            'startDate' => $startDate->format('Y-m-d')
        ]);
    
        // Iterate over results and update the months array
        while ($row = $result->fetchAssociative()) {
            $months[$row['month']] = (int) $row['reclamationCount'];
        }
    
        return $months;
    }
   






}
