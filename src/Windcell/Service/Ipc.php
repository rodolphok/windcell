<?php
namespace Windcell\Service;

use Windcell\Model\Ipc as IpcModel;

use Exception;


class Ipc extends Service{

    public function save($data)
    {
        $data = json_decode($data);

        if (!isset($data->name) || !isset($data->valor) || !isset($data->comissao)) {

            throw new Exception("Invalid Parameters", 1);
        }

        $ipc= $this->getIpc($data);

        $ipc->setName($data->name);
        $ipc->setValor($data->valor);
        $ipc->setComissao($data->comissao);

        try {

            $this->em->persist($ipc);
            $this->em->flush();
            return $ipc;

        } catch (Exception $e) {

            echo $e->getMessage();

        }
    }


    private function getIpc($data)
    {

        $ipc = null;

        if ( isset($data->id) ) {
            $ipc = $this->em->getRepository('Windcell\Model\Ipc')->find($data->id);

        }

        if (!$ipc) {
            $ipc = new IpcModel();
        }

        return $ipc;
    }

}