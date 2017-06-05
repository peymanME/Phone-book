<?php
namespace Application\Services\Base;

abstract class  ServiceBase
{
    protected $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    protected function find($entity, $id){
        return $this->entityManager->find($entity, $id);
    }

    protected function getEntity($newEntity, $entity){
        $new = new $newEntity();
        $new->mapFormToObject($entity);
        return $new;
    }
    
    protected function findBy($entity, $array){
        return $this->entityManager->getRepository( $entity )->findBy($array);
    }
    
    protected function save($entity){
        try{
            if ($entity->getid()===null){
                $this->entityManager->persist($entity);
            } 
            $this->entityManager->flush();
            return $entity;
            
        } catch (\Exception $ex) {
           return 301;
        }
    }
    
    protected function remove($entity, $id){
        $removeEntity = $this->find($entity, $id);
        if (isset($removeEntity)) {
            $this->entityManager->remove($removeEntity);
            $this->entityManager->flush();
            return true;
        }
        return false;
    }
}