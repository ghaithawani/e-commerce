<?php

namespace App\Repository;

use App\Entity\Response;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Response::class);
    }

    public function findBySearchQuery(string $searchQuery): array
    {
        $qb = $this->createQueryBuilder('r');

        if (!empty($searchQuery)) {
            $qb->where('r.contenurep LIKE :search')
               ->setParameter('search', '%' . $searchQuery . '%');
        }

        return $qb->getQuery()->getResult();
    }


    public function save(Response $response): void
    {
        $this->_em->persist($response);
        $this->_em->flush();
    }

    public function delete(Response $response): void
    {
        $this->_em->remove($response);
        $this->_em->flush();
    }

    public function edit(Response $response): void
    {
        // The 'edit' operation is actually just a save operation in Doctrine
        // because Doctrine automatically tracks changes to objects.
        $this->save($response);
    }

    //total number of responses
    public function countResponses(): int
    {
        return $this->createQueryBuilder('r')
            ->select('COUNT(r.idrep)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    

    // Add custom repository methods here
}
