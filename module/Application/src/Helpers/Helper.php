<?php
namespace Application\Helpers;
class Helper {
    public function ArrayOfObjsToJson ($arrayOfObjects){
        $arrOfObjects = [];
        foreach ($arrayOfObjects as $object){
            $arrayObj = $object->getArrayValue();
            array_push($arrOfObjects, $arrayObj);
        }
        return json_encode($arrOfObjects, JSON_FORCE_OBJECT);
    }
     
}