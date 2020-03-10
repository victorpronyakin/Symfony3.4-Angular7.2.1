<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SequencesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SequencesRepository extends EntityRepository
{
    /**
     * @param $pageID
     * @param array $params
     * @return mixed
     */
    public function getAllByPageID($pageID, $params=[]){
        $query = $this->createQueryBuilder('s')
            ->select('s')
            ->where("s.page_id = :pageID")
            ->setParameter('pageID', $pageID)
            ->orderBy('s.id', 'DESC');

        if(isset($params['search']) && !empty($params['search'])){
            $query->andWhere('s.title LIKE :title')
                ->setParameter("title", '%'.$params['search'].'%');
        }

        return $query->getQuery()->getResult();
    }

    /**
     * @param $userID
     * @return int
     */
    public function countAllByUserId($userID){
        $result = $this->createQueryBuilder('s')
            ->from("AppBundle:Page", 'p')
            ->select('count(s) as sequences')
            ->where('p.user = :userID')
            ->setParameter('userID', $userID)
            ->andWhere('s.page_id = p.page_id')
            ->getQuery()->getResult();


        return (isset($result[0]['sequences']) && intval($result[0]['sequences'])>0) ? intval($result[0]['sequences']) : 0;
    }
}
