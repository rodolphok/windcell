<?php
namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zend\Crypt\Password\Bcrypt;
use Windcell\Service\DDD as DDDService;

class DDDController extends BaseController
{

    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));
        $controller->post('/create', array($this, 'create'));
        $controller->get('/delete/{dddId}', array($this, 'delete'));
        $controller->get('/edit/{dddId}', array($this, 'edit'))->value("dddId", null);

    }

    public function getIndex(Request $request, Application $app)
    {

        $ddds = $app['orm.em']->getRepository('Windcell\Model\DDD')->findAll();

        $data = array(

            'title' => 'Cadastrar DDD',
            'ddds' => $ddds,

        );
        return $app['twig']->render('admin/ddd/index.twig', $data);
    }

    public function create(Request $request, Application $app)
    {

        $data = $request->request->all();
        $data = json_encode($data);

        $dddService = new DDDService();
        $dddService->setEm($app['orm.em']);
        $ddd = $dddService->save($data);

       return $app->redirect('admin/ddd');

    }

    public function edit(Request $request, Application $app, $dddId)
    {
        if (isset($dddId)) {
            $ddd = $app['orm.em']->getRepository('Windcell\Model\DDD')->find($dddId);

        }
        return $app['twig']->render(
            'admin/ddd/edit.twig',
            array(
                'ddd' => $ddd,
                'active_page' => 'ddd'
            )
        );
    }

    public function delete(Request $request, Application $app, $dddId)
    {
        $em = $app['orm.em'];
        $ddds = $em->getRepository('Windcell\Model\DDD')->find($dddId);
        $em->remove($ddds);
        $em->flush();

        return $app->redirect('admin/ddd');
    }

}