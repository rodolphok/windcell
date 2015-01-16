<?php

namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Orcamentos\Service\Dashboard as DashboardService;
use Zend\Crypt\Password\Bcrypt;

class VendedorController extends BaseController
{

    public static function getVendedorActions()
    {
        return array('getIndex');
    }

    public static function onlyVendedor()
    {
        return true;
    }

    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));

    }

    public function getIndex(Request $request, Application $app)
    {


        return $app['twig']->render('vendedor/index.twig');

    }


}
