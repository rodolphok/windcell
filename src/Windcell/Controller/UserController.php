<?php

namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Windcell\Service\User as UserService;

use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap3View;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;

class UserController extends BaseController
{
    public static function getAdminActions()
    {
        return array('getIndex','create','edit','delete');
    }

    public static function onlyAdmin()
    {
        return true;
    }


    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));
        $controller->get('/edit/{userId}', array($this, 'edit'))->value("userId", null);
        $controller->post('/create', array($this, 'create'));
        $controller->get('/delete/{userId}', array($this, 'delete'));
        //$controller->get('/{page}', array($this, 'index'))->value('page', 1);
    }

    public function getIndex(Request $request, Application $app)
    {
        $users = $app['orm.em']->getRepository('Windcell\Model\User')->findAll();
        $lojas = $app['orm.em']->getRepository('Windcell\Model\Loja')->findAll();

        $data = array(

            'title' => 'Cadastrar User',
            'users' =>  $users,
            'lojas' => $lojas,

        );
        return $app['twig']->render('admin/user/index.twig', $data);
    }

    public function edit(Request $request, Application $app, $userId)
    {
        $user = null;
        if (isset($userId)) {
            $user = $app['orm.em']->getRepository('Windcell\Model\User')->find($userId);
        }
        return $app['twig']->render(
            'admin/user/edit.twig',
            array(
                'user' => $user,
                'active_page' => 'user'
            )
        );
    }

    // Funcao usada para criar o cliente, via post
    public function create(Request $request, Application $app)
    {
        $data = $request->request->all();

        $data = json_encode($data);
        $userService = new UserService();
        $userService->setEm($app['orm.em']);
        $user = $userService->save($data);
        return $app->redirect('admin/user');
    }


    public function delete(Request $request, Application $app, $userId)
    {
        $em = $app['orm.em'];
        $users = $em->getRepository('Windcell\Model\User')->find($userId);
        $em->remove($users);
        $em->flush();

        return $app->redirect('admin/user');
    }
}
