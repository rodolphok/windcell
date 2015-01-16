<?php
namespace Windcell\Model;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="ipc")
 */
class Ipc extends Entity{

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     *
     * @var float
     */
    private $valor;

    /**
     * @ORM\Column(type="float")
     *
     * @var float
     */
    private $comissao;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

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

    /**
     * @return float
     */
    public function getComissao()
    {
        return $this->comissao;
    }

    /**
     * @param float $comissao
     */
    public function setComissao($comissao)
    {
        $this->comissao = $comissao;
    }





}