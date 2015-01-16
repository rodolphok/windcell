<?php

namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Windcell\Service\Plano as PlanoService;
use DateTime;
use Windcell\Controller\BaseController;

use \IntlDateFormatter;

class PlanoController extends BaseController
{

    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));
        $controller->post('/create', array($this, 'create'));
        $controller->get('/edit/{planoId}', array($this, 'edit'))->value("planoId", null);
        $controller->get('/delete/{planoId}', array($this, 'delete'));

    }


    public function getIndex(Request $request, Application $app)
    {

        $planos = $app['orm.em']->getRepository('Windcell\Model\Plano')->findAll();
        $lojas = $app['orm.em']->getRepository('Windcell\Model\Loja')->findAll();

        $data = array(

            'title' => 'Cadastrar Plano',
            'planos' =>  $planos,
            'lojas' => $lojas,

        );
        return $app['twig']->render('plano/index.twig', $data);
    }

    public function create(Request $request, Application $app)
    {
        $data = $request->request->all();

        $data = json_encode($data);
        $planoService = new PlanoService();
        $planoService->setEm($app['orm.em']);
        $plano = $planoService->save($data);
        return $app->redirect('admin/plano');
    }

    public function edit(Request $request, Application $app, $planoId)
    {
        if (isset($planoId)) {
            $plano = $app['orm.em']->getRepository('Windcell\Model\Plano')->find($planoId);
            $lojas = $app['orm.em']->getRepository('Windcell\Model\Loja')->findAll();

        }
        return $app['twig']->render(
            'admin/plano/edit.twig',
            array(
                'plano' => $plano,
                'lojas' => $lojas,
                'active_page' => 'plano'
            )
        );
    }

    public function delete(Request $request, Application $app, $planoId)
    {
        $em = $app['orm.em'];
        $plano = $em->getRepository('Windcell\Model\Plano')->find($planoId);
        $lojaId = $plano->getLoja()->getId();
        $em->remove($plano);
        $em->flush();

        return $app->redirect($_SERVER['HTTP_REFERER']);
    }




}
