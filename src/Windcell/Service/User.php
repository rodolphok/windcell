<?php

namespace Windcell\Service;

use Windcell\Model\User as UserModel;
use Zend\Crypt\Password\Bcrypt;
use Exception;


class User extends Service
{

    public function save($data)
    {
        $data = json_decode($data);

        if (!isset($data->name) || !isset($data->celular) ||
            !isset($data->login) || !isset($data->password) || !isset($data->role) || !isset($data->loja)) {
            throw new Exception("Invalid Parameters", 1);
        }

        $user = $this->getUser($data);

        $user->setName($data->name);
        $user->setCelular($data->celular);
        $user->setLogin($data->login);
        $user->setRole($data->role);

        $password = $user->getPassword();

        if( !isset($password) || $password != $data->password ) {
            $bcrypt = new Bcrypt;
            $password = $bcrypt->create($data->password);
        }

        $user->setPassword($password);

        /*
        $admin = false;
        if ( isset($data->admin) ){
            $admin = true;
        }
        */


        //$user->setAdmin($admin);

        $loja = $this->em->getRepository('Windcell\Model\Loja')->find($data->loja);

        if (!isset($loja)) {
            throw new Exception("Empresa não encontrada", 1);
        }

        $user->setLoja($loja);

        try {
            $this->em->persist($user);
            $this->em->flush();
            return $user;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    private function getUser($data)
    {

        $user = null;

        $user = $this->em->getRepository('Windcell\Model\User')->findOneBy(array('login' => $data->login));


        if ($user && $user->getId() != $data->id){
            throw new Exception("Usuário com este login já cadastrado", 1);
        }

        if ( isset($data->id) ) {
            $user = $this->em->getRepository('Windcell\Model\User')->find($data->id);
        }

        if (!$user) {
            $user = new UserModel();
        }

        return $user;
    }
}
