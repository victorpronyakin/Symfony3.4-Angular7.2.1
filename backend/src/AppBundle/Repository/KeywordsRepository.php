<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Keywords;

/**
 * KeywordsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class KeywordsRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $page_id
     * @param $command
     * @return null
     */
    public function findIsByPageIdAndCommand($page_id, $command){
        if(!empty($command)){
            $result = $this->createQueryBuilder('k')
                ->select('k')
                ->where('k.page_id = :page_id')
                ->setParameter('page_id', $page_id)
                ->andWhere('k.status = :true')
                ->setParameter('true', true)
                ->andWhere("k.command LIKE :command")
                ->setParameter('command',"%".$command."%")
                ->andWhere("k.type = :type")
                ->setParameter('type', 1)
                ->getQuery()
                ->getResult();

            if(!empty($result)){
                foreach ($result as $keyword){
                    if($keyword instanceof Keywords){
                        $commands = array_map('trim', explode(',', $keyword->getCommand()));
                        if(in_array($command, $commands)){
                            return $keyword;
                        }
                    }
                }
            }
        }

        return null;
    }

    /**
     * @param $page_id
     * @param $command
     * @return null
     */
    public function findBeginsByPageIdAndCommand($page_id, $command){
        if(!empty($command)){
            $result = $this->createQueryBuilder('k')
                ->select('k')
                ->where('k.page_id = :page_id')
                ->setParameter('page_id', $page_id)
                ->andWhere('k.status = :true')
                ->setParameter('true', true)
                ->andWhere("k.type = :type")
                ->setParameter('type', 3)
                ->getQuery()
                ->getResult();

            if(!empty($result)){
                foreach ($result as $keyword){
                    if($keyword instanceof Keywords){
                        $commands = array_map('trim', explode(',', $keyword->getCommand()));
                        foreach ($commands as $commandItem){
                            if (strpos($command, $commandItem) === 0) {
                                return $keyword;
                            }
                        }
                    }
                }
            }
        }

        return null;
    }

    /**
     * @param $page_id
     * @param $command
     * @return null
     */
    public function findContainsByPageIdAndCommand($page_id, $command){
        if(!empty($command)){
            $result = $this->createQueryBuilder('k')
                ->select('k')
                ->where('k.page_id = :page_id')
                ->setParameter('page_id', $page_id)
                ->andWhere('k.status = :true')
                ->setParameter('true', true)
                ->andWhere("k.type = :type")
                ->setParameter('type', 2)
                ->getQuery()
                ->getResult();

            if(!empty($result)){
                foreach ($result as $keyword){
                    if($keyword instanceof Keywords){
                        $commands = array_map('trim', explode(',', $keyword->getCommand()));
                        foreach ($commands as $commandItem){
                            if (strpos($command, $commandItem) !== false) {
                                return $keyword;
                            }
                        }
                    }
                }
            }
        }

        return null;
    }
}
