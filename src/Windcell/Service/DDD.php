<?php
namespace Windcell\Service;

use Windcell\Model\DDD as DDDModel;

use Exception;


class DDD extends Service{

    public function save($data)
    {
        $data = json_decode($data);

        if (!isset($data->ddd)) {

            throw new Exception("Invalid Parameters", 1);
        }

        $ddd= $this->getDDD($data);

        $ddd->setDdd($data->ddd);

        try {

            $this->em->persist($ddd);
            $this->em->flush();
            return $ddd;

        } catch (Exception $e) {

            echo $e->getMessage();

        }
    }


    private function getDDD($data)
    {

        $ddd = null;

        if ( isset($data->id) ) {
            $ddd = $this->em->getRepository('Windcell\Model\DDD')->find($data->id);

        }

        if (!$ddd) {
            $ddd = new DDDModel();
        }

        return $ddd;
    }

}