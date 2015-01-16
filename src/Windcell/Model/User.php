<?php
namespace Windcell\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 */
class User extends Entity
{
    /**
     * @ORM\Column(type="string", length=150)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=11)
     *
     * @var string
     */
    private $celular;

    /**
     * @ORM\Column(type="string", length=150, unique=true)
     *
     * @var string
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity="Loja", inversedBy="lojaCollection", cascade={"persist", "merge", "refresh"})
     *
     * @var Loja
     */
    protected $loja;

    public function __construct()
    {
        $this->setCreated(date('Y-m-d H:i:s'));
    }

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
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @param string $celular
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
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






}
