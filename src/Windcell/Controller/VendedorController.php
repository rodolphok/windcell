<?php

namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Windcell\Service\Venda as VendaService;

class VendedorController extends BaseController
{

    public static function getVendedorActions()
    {
        return array('getIndex');
    }


    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));
        $controller->post('/create', array($this, 'create'));

    }

    public function getIndex(Request $request, Application $app)
    {

        return $app['twig']->render('vendedor/index.twig');

    }

    public function create(Request $request, Application $app)
    {

        $data = $request->request->all();

        $data = json_encode($data);

        $vendaService = new VendaService();
        $vendaService->setEm($app['orm.em']);
        $vendaService->save($data);

        return $app->redirect('vendedor');

    }


}
