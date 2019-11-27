<?php

namespace App\Repository;

use App\Entity\Relationship;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RelationshipRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Relationship::class);
    }

    public function getCount($relationship, $id = null)
    {
    	$qb = $this->createQueryBuilder('r');
    	$qb->select('count(r.id)');
    	$qb->where('r.relationship = :relationship')
	    		->setParameter('relationship', $relationship);
	    if ($id) {
	    	$qb->andWhere('r.id != :identifier')
	    		->setParameter('identifier', $id);
	  	}

	    return $qb->getQuery()
	          ->getSingleScalarResult();
    }
}