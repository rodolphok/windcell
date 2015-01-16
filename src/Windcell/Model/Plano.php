<?php
namespace Windcell\Model;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="plano")
 */
class Plano extends Entity
{

    /**
     * @ORM\Column(type="string")
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
     * @ORM\ManyToOne(targetEntity="Loja", cascade={"persist", "merge", "refresh"})
     *
     * @var Loja
     */
    private $loja;


    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $meta01;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $meta02;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $meta03;

    /**
     * @ORM\Column(type="float")
     *
     * @var float
     */
    private $comissao01;

    /**
     * @ORM\Column(type="float")
     *
     * @var float
     */
    private $comissao02;

    /**
     * @ORM\Column(type="float")
     *
     * @var float
     */
    private $comissao03;

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
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return mixed
     */
    public function getComissao()
    {
        return $this->comissao;
    }

    /**
     * @param mixed $comissao
     */
    public function setComissao($comissao)
    {
        $this->comissao = $comissao;
    }

    /**
     * @return mixed
     */
    public function getLoja()
    {
        return $this->loja;
    }

    /**
     * @param mixed $loja
     */
    public function setLoja($loja)
    {
        $this->loja = $loja;
    }

    /**
     * @return mixed
     */
    public function getMeta01()
    {
        return $this->meta01;
    }

    /**
     * @param mixed $meta01
     */
    public function setMeta01($meta01)
    {
        $this->meta01 = $meta01;
    }

    /**
     * @return mixed
     */
    public function getMeta02()
    {
        return $this->meta02;
    }

    /**
     * @param mixed $meta02
     */
    public function setMeta02($meta02)
    {
        $this->meta02 = $meta02;
    }

    /**
     * @return mixed
     */
    public function getMeta03()
    {
        return $this->meta03;
    }

    /**
     * @param mixed $meta03
     */
    public function setMeta03($meta03)
    {
        $this->meta03 = $meta03;
    }

    /**
     * @return mixed
     */
    public function getComissao01()
    {
        return $this->comissao01;
    }

    /**
     * @param mixed $comissao01
     */
    public function setComissao01($comissao01)
    {
        $this->comissao01 = $comissao01;
    }

    /**
     * @return mixed
     */
    public function getComissao02()
    {
        return $this->comissao02;
    }

    /**
     * @param mixed $comissao02
     */
    public function setComissao02($comissao02)
    {
        $this->comissao02 = $comissao02;
    }

    /**
     * @return mixed
     */
    public function getComissao03()
    {
        return $this->comissao03;
    }

    /**
     * @param mixed $comissao03
     */
    public function setComissao03($comissao03)
    {
        $this->comissao03 = $comissao03;
    }




}