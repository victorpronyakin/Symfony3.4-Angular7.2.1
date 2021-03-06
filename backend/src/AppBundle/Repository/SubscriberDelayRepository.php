<?php

namespace AppBundle\Repository;

/**
 * SubscriberDelayRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SubscriberDelayRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function findNeedSendNow(){
        $date = new \DateTime();

        $query = $this->createQueryBuilder('sd')
            ->select('sd')
            ->where("DATE_FORMAT(sd.sendDate, '%Y-%m-%d %H:%i') = :date")
            ->setParameter('date', $date->format('Y-m-d H:i'));

        return $query->getQuery()->getResult();
    }
}
