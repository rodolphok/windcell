<?php
namespace Windcell\Model;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="sms")
 */
class Sms extends Entity{


    /**
     * @ORM\Column(type="float")
     *
     * @var float
     */
    private $valor;

    /**
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param float $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }



}