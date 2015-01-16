<?php
namespace Windcell\Service;

use Windcell\Model\Ld as LdModel;

use Exception;


class Ld extends Service{

    public function save($data)
    {
        $data = json_decode($data);

        if (!isset($data->valor)) {

            throw new Exception("Invalid Parameters", 1);
        }

        $ld= $this->getLd($data);

        $ld->setValor($data->valor);

        try {

            $this->em->persist($ld);
            $this->em->flush();
            return $ld;

        } catch (Exception $e) {

            echo $e->getMessage();

        }
    }


    private function getLd($data)
    {

        $ld = null;

        if ( isset($data->id) ) {
            $ld = $this->em->getRepository('Windcell\Model\Ld')->find($data->id);

        }

        if (!$ld) {
            $ld = new LdModel();
        }

        return $ld;
    }

}