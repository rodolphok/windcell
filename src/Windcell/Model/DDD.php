<?php
namespace Windcell\Model;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="ddd")
 */
class DDD extends Entity
{
    /**
     * @ORM\Column(type="string", length=2)
     *
     * @var string
     */
    private $ddd;

    /**
     * @return string
     */
    public function getDdd()
    {
        return $this->ddd;
    }

    /**
     * @param string $ddd
     */
    public function setDdd($ddd)
    {
        $this->ddd = $ddd;
    }



}