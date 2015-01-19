<?php
namespace Windcell\Service;

use Windcell\Model\Venda as VendaModel;
use Windcell\Model\ComplementoVenda as ComplementoVendaModel;
use Silex\Application;

use Exception;


class Venda extends Service{

    public function save($data, Application $app)
    {
        $data = json_decode($data);

        if (!isset($data->name) || !isset($data->ddd) || !isset($data->plano) || !isset($data->ipc) || !isset($data->numero) || !isset($data->cpf)) {

            throw new Exception("Invalid Parameters", 1);
        }

        $vendedor = $this->em->getRepository('Windcell\Model\User')->find($app['session']->get('userId'));
        $ddd = $this->em->getRepository('Windcell\Model\DDD')->find($data->ddd);
        $plano = $this->em->getRepository('Windcell\Model\Plano')->find($data->plano);
        $ipc = $this->em->getRepository('Windcell\Model\Ipc')->find($data->ipc);
        $loja = $this->em->getRepository('Windcell\Model\Loja')->find($app['session']->get('lojaId'));


        $sms = false;
        $valor_sms = 0;
        if ( isset($data->sms) ){
            $sms = true;
            $sms_valor = $this->em->getRepository('Windcell\Model\Sms')->find(1);
            $valor_sms = $sms_valor->getValor();
        }

        $ld = false;
        $valor_ld = 0;
        if ( isset($data->ld) ){
            $ld = true;
            $ld_valor = $this->em->getRepository('Windcell\Model\Ld')->find(1);
            $valor_ld = $ld_valor->getValor();
        }

        $valor_complemento = ($valor_sms + $valor_ld);

        $valor_total = ($plano->getValor() + $ipc->getValor() + $valor_complemento);


        $venda = $this->getVenda($data);
        $compl_venda = $this->getComplementoVenda($data);

        if(!$venda->getVendedor()){
            $venda->setVendedor($vendedor);
        }

        if(!$venda->getDdd()){
            $venda->setDdd($ddd);
        }

        if(!$venda->getPlano()){
            $venda->setPlano($plano);
        }

        if(!$venda->getIpc()){
            $venda->setIpc($ipc);
        }

        if(!$venda->getLoja()){
            $venda->setLoja($loja);
        }


        $venda->setName($data->name);
        $venda->setNumero($data->numero);
        $venda->setCpf($data->cpf);
        $venda->setValor($valor_total);

        $compl_venda->setVenda($venda);
        $compl_venda->setSms($sms);
        $compl_venda->setLd($ld);
        $compl_venda->setValor($valor_complemento);


        try {

            $this->em->persist($venda);
            $this->em->persist($compl_venda);

            $this->em->flush();
            return $venda;

        } catch (Exception $e) {

            echo $e->getMessage();

        }
    }

    private function getVenda($data)
    {

        $venda = null;

        if ( isset($data->id) ) {
            $venda = $this->em->getRepository('Windcell\Model\Venda')->find($data->id);

        }

        if (!$venda) {
            $venda = new VendaModel();


        return $venda;
    }
    }

    private function getComplementoVenda()
    {
            $compl_venda = new ComplementoVendaModel();

            return $compl_venda;

    }

}