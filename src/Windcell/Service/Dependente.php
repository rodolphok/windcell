<?php
namespace Windcell\Service;

use Windcell\Model\Dependente as DependenteModel;

use Exception;


class Dependente extends Service{

    public function save($data)
    {
        $data = json_decode($data);

        if (!isset($data->valor)) {

            throw new Exception("Invalid Parameters", 1);
        }

        $dependente= $this->getDependente($data);

        $dependente->setValor($data->valor);

        try {

            $this->em->persist($dependente);
            $this->em->flush();
            return $dependente;

        } catch (Exception $e) {

            echo $e->getMessage();

        }
    }


    private function getDependente($data)
    {

        $dependente = null;

        if ( isset($data->id) ) {
            $dependente = $this->em->getRepository('Windcell\Model\Dependente')->find($data->id);

        }

        if (!$dependente) {
            $dependente = new DependenteModel();
        }

        return $dependente;
    }

}