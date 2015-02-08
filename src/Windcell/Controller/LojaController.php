<?php
namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zend\Crypt\Password\Bcrypt;
use Windcell\Service\Loja as LojaService;

class LojaController extends BaseController
{
    public static function getAdminActions()
    {
        return array('getIndex','create','edit','delete');
    }

    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));
        $controller->post('/create', array($this, 'create'));
        $controller->get('/delete/{lojaId}', array($this, 'delete'));
        $controller->get('/edit/{lojaId}', array($this, 'edit'))->value("lojaId", null);

    }

    public function getIndex(Request $request, Application $app)
    {

        $lojas = $app['orm.em']->getRepository('Windcell\Model\Loja')->findAll();

        $data = array(

            'title' => 'Cadastrar Loja',
            'lojas' => $lojas,

        );
        return $app['twig']->render('loja/index.twig', $data);
    }

    public function create(Request $request, Application $app)
    {

        $data = $request->request->all();

        $data = json_encode($data);

        $lojaService = new LojaService();
        $lojaService->setEm($app['orm.em']);
        $loja = $lojaService->save($data);

       return $app->redirect('/loja');

    }

    public function edit(Request $request, Application $app, $lojaId)
    {
        if (isset($lojaId)) {
            $lojaService = new LojaService();
            $lojaService->setEm($app['orm.em']);
            $loja = $lojaService->findById($lojaId);
            $lojas = $lojaService->findAll();


        }
        return $app['twig']->render(
            'loja/edit.twig',
            array(
                'loja' => $loja,
                'active_page' => 'loja'
            )
        );
    }

    public function delete(Request $request, Application $app, $lojaId)
    {
        $lojaService = new LojaService();
        $lojaService->setEm($app['orm.em']);
        $loja = $lojaService->delete($lojaId);

        return $app->redirect('/loja');
    }

}