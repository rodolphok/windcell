<?php
namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zend\Crypt\Password\Bcrypt;
use Windcell\Service\Ld as LdService;

class LdController extends BaseController
{
    public static function getAdminActions()
    {
        return array('getIndex','create','edit');
    }

    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));
        $controller->post('/create', array($this, 'create'));

        $controller->get('/edit/{ldId}', array($this, 'edit'))->value("ldId", null);

    }

    public function getIndex(Request $request, Application $app)
    {

        $lds = $app['orm.em']->getRepository('Windcell\Model\Ld')->findAll();

        $data = array(

            'title' => 'Cadastrar Ld',
            'lds' => $lds,

        );
        return $app['twig']->render('ld/index.twig', $data);
    }

    public function create(Request $request, Application $app)
    {

        $data = $request->request->all();

        $data = json_encode($data);

        $ldService = new LdService();
        $ldService->setEm($app['orm.em']);
        $ld = $ldService->save($data);

       return $app->redirect('/ld');

    }

    public function edit(Request $request, Application $app, $ldId)
    {
        if (isset($ldId)) {
            $ld = $app['orm.em']->getRepository('Windcell\Model\Ld')->find($ldId);

        }
        return $app['twig']->render(
            'ld/edit.twig',
            array(
                'ld' => $ld,
                'active_page' => 'ld'
            )
        );
    }


}