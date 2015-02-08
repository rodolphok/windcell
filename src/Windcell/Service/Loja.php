<?php
namespace Windcell\Service;

use Windcell\Model\Loja as LojaModel;

use Exception;


class Loja extends Service{

    public function save($data)
    {
        $data = json_decode($data);

        if (!isset($data->name)) {

            throw new Exception("Invalid Parameters", 1);
        }

        $loja= $this->getLoja($data);

        $loja->setName($data->name);

        try {

            $this->em->persist($loja);
            $this->em->flush();
            return $loja;

        } catch (Exception $e) {

            echo $e->getMessage();

        }
    }


    private function getLoja($data)
    {

        $loja = null;

        if ( isset($data->id) ) {
            $loja = $this->em->getRepository('Windcell\Model\Loja')->find($data->id);

        }

        if (!$loja) {
            $loja = new LojaModel();
        }

        return $loja;
    }

    public function findAll()
    {
        $lojas = $this->em->getRepository('Windcell\Model\Loja')->findAll();

        return $lojas;
    }

    public function findById($lojaId)
    {
        $loja = null;
        $loja = $this->em->getRepository('Windcell\Model\Loja')->find($lojaId);

        return $loja;
    }

    public function delete($lojaId)
    {
        $loja = $this->findById($lojaId);

        try {

            $this->em->remove($loja);
            $this->em->flush();

        } catch (Exception $e) {

            echo $e->getMessage();

        }
    }

}