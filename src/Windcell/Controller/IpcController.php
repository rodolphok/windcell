<?php
namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zend\Crypt\Password\Bcrypt;
use Windcell\Service\Ipc as IpcService;

class IpcController extends BaseController
{

    public static function getAdminActions()
    {
        return array('getIndex','create','edit','delete');
    }

    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));
        $controller->post('/create', array($this, 'create'));
        $controller->get('/delete/{ipcId}', array($this, 'delete'));
        $controller->get('/edit/{ipcId}', array($this, 'edit'))->value("ipcId", null);

    }

    public function getIndex(Request $request, Application $app)
    {

        $ipcs = $app['orm.em']->getRepository('Windcell\Model\Ipc')->findAll();

        $data = array(

            'title' => 'Cadastrar IPC',
            'ipcs' => $ipcs,

        );
        return $app['twig']->render('ipc/index.twig', $data);
    }

    public function create(Request $request, Application $app)
    {

        $data = $request->request->all();

        $data = json_encode($data);

        $ipcService = new IpcService();
        $ipcService->setEm($app['orm.em']);
        $ipc = $ipcService->save($data);

        return $app->redirect($_SERVER['HTTP_REFERER']);

    }

    public function edit(Request $request, Application $app, $ipcId)
    {
        if (isset($ipcId)) {
            $ipc = $app['orm.em']->getRepository('Windcell\Model\Ipc')->find($ipcId);

        }
        return $app['twig']->render(
            'ipc/edit.twig',
            array(
                'ipc' => $ipc,
                'active_page' => 'ipc'
            )
        );
    }

    public function delete(Request $request, Application $app, $ipcId)
    {
        $em = $app['orm.em'];
        $ipcs = $em->getRepository('Windcell\Model\Ipc')->find($ipcId);
        $em->remove($ipcs);
        $em->flush();

        return $app->redirect('/ipc');
    }

}