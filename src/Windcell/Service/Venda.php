<?php
namespace Windcell\Service;

use Windcell\Model\Venda as VendaModel;
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
        $venda->setSms($sms);
        $venda->setLd($ld);
        $venda->setValorComplemento($valor_complemento);
        $venda->setStatusComplemento(0);
        $venda->setStatus(0);


        try {
           // var_dump($venda);die;
            $this->em->persist($venda);


            $this->em->flush();

            return $venda;

        } catch (Exception $e) {

            echo $e->getMessage();

        }
    }



    public function alterStatus($id,$status){

        $qb =  $this->em->createQueryBuilder();
        $q = $qb->update('Windcell\Model\Venda', 'u')
                ->set('u.status', '?1')
                ->where('u.id = ?3')
                ->setParameter(1, $status )
                ->setParameter(3, $id)
                ->getQuery();
        $p = $q->execute();

        return $p;

    }

    public function alterComplemento($id,$complemento){

        $qb =  $this->em->createQueryBuilder();
        $q = $qb->update('Windcell\Model\Venda', 'u')
                ->set('u.statusCompl', '?1')
                ->where('u.id = ?3')
                ->setParameter(1, $complemento )
                ->setParameter(3, $id)
                ->getQuery();
        $p = $q->execute();

        return $p;

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


}