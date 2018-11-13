<?php

namespace BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ViaRepository extends EntityRepository {

    public function findAllByText($text) {
        return $this->getEntityManager()
                        ->createQuery(
                                'SELECT s FROM BackBundle:Via s WHERE s.name like lower(:text)'
                        )->setParameter("text","%" . $text . "%")
                        ->setMaxResults(15)
                        ->getResult();
    }

}
