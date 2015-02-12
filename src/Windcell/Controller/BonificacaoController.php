<?php

namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Windcell\Service\Bonificacao as BonificacaoService;
use Windcell\Service\Venda as vendaService;
use Zend\Crypt\Password\Bcrypt;

class BonificacaoController extends BaseController
{

    public static function getAdminActions()
    {
        return array('getIndex','consult','getStatus','getComplemento');
    }

    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));
        $controller->post('/consult', array($this, 'consult'));
        $controller->post('/getStatus', array($this, 'getStatus'));
        $controller->post('/getComplemento', array($this, 'getComplemento'));

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

    public function getStatus(Application $app, Request $request)
    {
        if( isset( $_POST['status'] ) )
            $status = $_POST['status'];
            $id = $_POST['id'];
            $vendaService = new VendaService();
            $vendaService->setEm($app['orm.em']);
            $vendaService->alterStatus($id,$status);


    }

    public function getComplemento(Application $app, Request $request)
    {
        if( isset( $_POST['complemento'] ) )
            $complemento = $_POST['complemento'];
        $id = $_POST['id'];
        $vendaService = new VendaService();
        $vendaService->setEm($app['orm.em']);
        $vendaService->alterComplemento($id,$complemento);


    }



}