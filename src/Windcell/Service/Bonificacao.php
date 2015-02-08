<?php
namespace Windcell\Service;


class Bonificacao extends Service{

    public function getData($data)
    {
        $data = json_decode($data);

        $busca = trim($data->numeros);
        $numeros = explode(" ", $busca);
        $c = count($numeros);

        $array = array();
        $vendas = array();
        for($i=0; $i<$c; $i++){

            $query = $this->em->createQuery("SELECT v FROM Windcell\Model\Venda v WHERE v.numero = :numero");
            $query->setParameter('numero', $numeros[$i]);

            if($query->getResult())
                $array[] = $query->getResult();

        }

        foreach($array as $key => $arr_uni)
        {
            foreach($arr_uni as $key2 => $value)
            {
                $vendas[] = $value;
            }
        }

        //var_dump($vendas);die;
        return $vendas;

    }

}