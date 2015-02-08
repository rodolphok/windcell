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

    public function findAll()
    {
        $ddds = $this->em->getRepository('Windcell\Model\DDD')->findAll();

        return $ddds;
    }

    public function findById($dddId)
    {
        $ddd = null;
        $ddd = $this->em->getRepository('Windcell\Model\DDD')->find($dddId);

        return $ddd;
    }

    public function delete($dddId)
    {
        $ddd= $this->findById($dddId);

        try {

            $this->em->remove($ddd);
            $this->em->flush();

        } catch (Exception $e) {

            echo $e->getMessage();

        }
    }

}