<?php

namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Windcell\Service\Venda as VendaService;

class VendaController extends BaseController
{

    public static function getVendedorActions()
    {
        return array('getIndex','create');
    }


    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));
        $controller->post('/create', array($this, 'create'));

    }

    public function getIndex(Request $request, Application $app)
    {
        $ddds = $app['orm.em']->getRepository('Windcell\Model\DDD')->findAll();
        $planos = $app['orm.em']->getRepository('Windcell\Model\Plano')->findAll();
        $ipcs = $app['orm.em']->getRepository('Windcell\Model\Ipc')->findAll();

        $data = array(


            'ddds' => $ddds,
            'planos' => $planos,
            'ipcs' => $ipcs,

        );

        return $app['twig']->render('vendedor/venda/index.twig',$data);

    }

    public function create(Request $request, Application $app)
    {

        $data = $request->request->all();

        $data = json_encode($data);

        $vendaService = new VendaService();
        $vendaService->setEm($app['orm.em']);
        $venda = $vendaService->save($data, $app);

        return $app->redirect($_SERVER['HTTP_REFERER']);

    }


}
