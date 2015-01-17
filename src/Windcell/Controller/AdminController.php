<?php

namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Orcamentos\Service\Dashboard as DashboardService;
use Zend\Crypt\Password\Bcrypt;

class AdminController extends BaseController
{

    public static function getAdminActions()
    {
        return array('getIndex');
    }

    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));

    }

    public function getIndex(Request $request, Application $app)
    {


        return $app['twig']->render('admin/index.twig');

    }


}
