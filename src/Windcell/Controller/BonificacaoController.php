<?php

namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Windcell\Service\Bonificacao as BonificacaoService;
use Zend\Crypt\Password\Bcrypt;

class BonificacaoController extends BaseController
{

    public static function getAdminActions()
    {
        return array('getIndex','consult');
    }

    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));
        $controller->post('/consult', array($this, 'consult'));

    }

    public function getIndex(Request $request, Application $app)
    {

        return $app['twig']->render('bonificacao/index.twig' );

    }

    public function consult(Request $request, Application $app)
    {
        $data = $request->request->all();
        $data = json_encode($data);

        $bonificacaoService = new BonificacaoService();
        $bonificacaoService->setEm($app['orm.em']);
        $result = $bonificacaoService->getData($data);



        return $app['twig']->render('bonificacao/index.twig', array(
            'result' => $result,
        ));
    }

}