<?php
namespace Windcell\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="complemento_venda")
 */

class ComplementoVenda extends Entity {

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var string
     */
    private $sms;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var string
     */
    private $ld;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $valor;

    /**
     * @ORM\OneToOne(targetEntity="Venda")
     *
     * */
    private $venda;

    /**
     * @return mixed
     */
    public function getSms()
    {
        return $this->sms;
    }

    /**
     * @param mixed $sms
     */
    public function setSms($sms)
    {
        $this->sms = $sms;
    }

    /**
     * @return mixed
     */
    public function getLd()
    {
        return $this->ld;
    }

    /**
     * @param mixed $ld
     */
    public function setLd($ld)
    {
        $this->ld = $ld;
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
    public function getVenda()
    {
        return $this->venda;
    }

    /**
     * @param mixed $venda
     */
    public function setVenda($venda)
    {
        $this->venda = $venda;
    }




}