<?php

namespace Windcell\Service;


use Windcell\Model\Plano as PlanoModel;

use Exception;

class Plano extends Service
{

    public function save($data)
    {
        $data = json_decode($data);


        if (!isset($data->loja) || !isset($data->name) || !isset($data->valor) || !isset($data->comissao)
            || !isset($data->meta01) || !isset($data->meta02) || !isset($data->meta03) || !isset($data->comissao01)
            || !isset($data->comissao02) || !isset($data->comissao03)) {
            throw new Exception("Invalid Parameters", 1);
        }


        $loja = $this->em->getRepository('Windcell\Model\Loja')->find($data->loja);



        $plano = $this->getPlano($data);



        if(!$plano->getLoja()){
            $plano->setLoja($loja);
        }


        $plano->setName($data->name);
        $plano->setValor($data->valor);
        $plano->setComissao($data->comissao);
        $plano->setMeta01($data->meta01);
        $plano->setMeta02($data->meta02);
        $plano->setMeta03($data->meta03);
        $plano->setComissao01($data->comissao01);
        $plano->setComissao02($data->comissao02);
        $plano->setComissao03($data->comissao03);




        try {

            var_dump($this->em->persist($plano));
            $this->em->flush();
            return $plano;
           //

        } catch (Exception $e) {

            echo $e->getMessage();

        }
    }


    private function getPlano($data)
    {

        $plano = null;

        if ( isset($data->id) ) {
            $plano = $this->em->getRepository('Windcell\Model\Plano')->find($data->id);
        }

        if (!$plano) {
            $plano = new PlanoModel();
        }

        return $plano;
    }


}
