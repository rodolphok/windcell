<?php
namespace Windcell\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="venda")
 */
class Venda extends Entity{

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10)
     *
     * @var string
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=11)
     *
     * @var string
     */
    private $cpf;

    /**
     * @ORM\ManyToOne(targetEntity="user", cascade={"persist", "merge", "refresh"})
     *
     * @var User
     */
    private $vendedor;

    /**
     * @ORM\ManyToOne(targetEntity="ddd", cascade={"persist", "merge", "refresh"})
     *
     * @var Ddd
     */
    private $ddd;

    /**
     * @ORM\ManyToOne(targetEntity="plano", cascade={"persist", "merge", "refresh"})
     *
     * @var Plano
     */
    private $plano;

    /**
     * @ORM\ManyToOne(targetEntity="ipc", cascade={"persist", "merge", "refresh"})
     *
     * @var Ipc
     */
    private $ipc;

    /**
     * @ORM\ManyToOne(targetEntity="loja", cascade={"persist", "merge", "refresh"})
     *
     * @var Loja
     */
    private $loja;


    /**
     * @ORM\Column(type="float")
     *
     * @var float
     */
    private $valor;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return User
     */
    public function getVendedor()
    {
        return $this->vendedor;
    }

    /**
     * @param User $vendedor
     */
    public function setVendedor($vendedor)
    {
        $this->vendedor = $vendedor;
    }

    /**
     * @return Ddd
     */
    public function getDdd()
    {
        return $this->ddd;
    }

    /**
     * @param Ddd $ddd
     */
    public function setDdd($ddd)
    {
        $this->ddd = $ddd;
    }

    /**
     * @return Plano
     */
    public function getPlano()
    {
        return $this->plano;
    }

    /**
     * @param Plano $plano
     */
    public function setPlano($plano)
    {
        $this->plano = $plano;
    }

    /**
     * @return Ipc
     */
    public function getIpc()
    {
        return $this->ipc;
    }

    /**
     * @param Ipc $ipc
     */
    public function setIpc($ipc)
    {
        $this->ipc = $ipc;
    }

    /**
     * @return Loja
     */
    public function getLoja()
    {
        return $this->loja;
    }

    /**
     * @param Loja $loja
     */
    public function setLoja($loja)
    {
        $this->loja = $loja;
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


}