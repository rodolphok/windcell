<?php

namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Windcell\Service\Dashboard as DashboardService;
use Zend\Crypt\Password\Bcrypt;

class IndexController extends BaseController
{


    public static function getPublicActions()
    {
        return array('getIndex', 'getLogout', 'postLogin');
    }


    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));
        $controller->post('/login', array($this, 'postLogin'));
        $controller->get('/logout', array($this, 'getLogout'));
    }

    public function getIndex(Request $request, Application $app)
    {

        if ($app['session']->get('login') == null ) {
            return $app['twig']->render('login.twig', array());
        }

        if($app['session']->get('role') == 'vendedor'){
            return $app->redirect('vendedor/');
        }

        $lojaId = $app['session']->get('lojaId');
        $data = array('lojaId' => $lojaId);
        $dashboardService = new DashboardService();
        $dashboardService->setEm($app['orm.em']);
        $result = $dashboardService->getData(json_encode($data));

        //var_dump($result);die;
        return $app['twig']->render('index/index.twig', array(
            'result' => $result,
            'active_page' => 'panel'
        ));

    }

    public function postLogin(Request $request, Application $app)
    {

        $data = $request->request->all();

        if (!isset($data['login']) || !isset($data['password'])) {
            $app['session']->getFlashBag()->add('message', 'Login e/ou senha inválidos!');
            return $app->redirect('/');
        }

        $user = $app['orm.em']->getRepository('Windcell\Model\User')->findOneBy(array( 'login' => $data['login'] ));

        if (!$user) {
            $app['session']->getFlashBag()->add('message', 'Usuário inválido!');
            return $app->redirect('/');
        }

        $bcrypt = new Bcrypt;
        $valid = $bcrypt->verify($data['password'], $user->getPassword());

        if (!$valid) {
            $app['session']->getFlashBag()->add('message', 'Login e/ou senha inválidos!');
            return $app->redirect('/');
        }

        $app['session']->set('login', $data['login']);
        $app['session']->set('role', $user->getRole());
        $app['session']->set('name', $user->getName());
        $app['session']->set('userId', $user->getId());
        //$app['session']->set('isAdmin', $user->getAdmin());
        $app['session']->set('lojaId', $user->getLoja()->getId());
        //$app['session']->set('companyLogotype', $user->getCompany()->getLogotype());
        $app['session']->set('lojaName', $user->getLoja()->getName());


        if ($user->getRole() == 'admin') {

            return $app->redirect('/');

        }else if($user->getRole() == 'vendedor'){

            return $app->redirect('/vendedor');
        }

        return $app->redirect('/');

    }

    public function getLogout(Request $request, Application $app)
    {
        $app['session']->clear();
        return $app->redirect('/');
    }
}
