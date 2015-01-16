<?php
namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zend\Crypt\Password\Bcrypt;
use Windcell\Service\Dependente as DependenteService;

class DependenteController extends BaseController
{

    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));
        $controller->post('/create', array($this, 'create'));

        $controller->get('/edit/{dependenteId}', array($this, 'edit'))->value("dependenteId", null);

    }

    public function getIndex(Request $request, Application $app)
    {

        $dependentes = $app['orm.em']->getRepository('Windcell\Model\Dependente')->findAll();

        $data = array(

            'title' => 'Cadastrar Ld',
            'dependentes' => $dependentes,

        );
        return $app['twig']->render('admin/dependente/index.twig', $data);
    }

    public function create(Request $request, Application $app)
    {

        $data = $request->request->all();

        $data = json_encode($data);

        $dependenteService = new DependenteService();
        $dependenteService->setEm($app['orm.em']);
        $dependente = $dependenteService->save($data);

       return $app->redirect('admin/dependente');

    }

    public function edit(Request $request, Application $app, $dependenteId)
    {
        if (isset($dependenteId)) {
            $dependente = $app['orm.em']->getRepository('Windcell\Model\Dependente')->find($dependenteId);

        }
        return $app['twig']->render(
            'admin/dependente/edit.twig',
            array(
                'dependente' => $dependente,
                'active_page' => 'dependente'
            )
        );
    }


}