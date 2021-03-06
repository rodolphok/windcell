<?php
namespace Windcell\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zend\Crypt\Password\Bcrypt;
use Windcell\Service\Sms as SmsService;

class SmsController extends BaseController
{

    public static function getAdminActions()
    {
        return array('getIndex','create','edit','delete');
    }

    public function mount($controller)
    {
        $controller->get('/', array($this, 'getIndex'));
        $controller->post('/create', array($this, 'create'));
        $controller->get('/edit/{smsId}', array($this, 'edit'))->value("smsId", null);
    }

    public function getIndex(Request $request, Application $app)
    {

        $smss = $app['orm.em']->getRepository('Windcell\Model\Sms')->findAll();

        $data = array(

            'title' => 'Cadastrar Ld',
            'smss' => $smss,

        );
        return $app['twig']->render('sms/index.twig', $data);
    }

    public function create(Request $request, Application $app)
    {

        $data = $request->request->all();

        $data = json_encode($data);

        $smsService = new SmsService();
        $smsService->setEm($app['orm.em']);
        $smsService->save($data);

       return $app->redirect('/sms');

    }

    public function edit(Request $request, Application $app, $smsId)
    {
        if (isset($smsId)) {
            $sms = $app['orm.em']->getRepository('Windcell\Model\Sms')->find($smsId);

        }
        return $app['twig']->render(
            'sms/edit.twig',
            array(
                'sms' => $sms,
                'active_page' => 'sms'
            )
        );
    }

}