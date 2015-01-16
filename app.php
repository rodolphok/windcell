<?php

require_once __DIR__.'/vendor/autoload.php';

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Symfony\Component\HttpFoundation\Response;

$app = new Application();

$app['debug'] = true;

$config = require_once __DIR__ . '/config/config.php';

if (!$config) {
    throw new \Exception("Error Processing Config", 1);
}

//configuration
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->error(function (\Exception $e, $code) use ($app) {
    switch ($code) {
        case 404:
            $message = $app['twig']->render('error404.twig', array('code'=>$code, 'message' => $e->getMessage()));
            break;
        default:
            $message = $e->getMessage() . ' no arquivo ' . $e->getFile() . ', na linha: '. $e->getLine();
            break;
    }
    return new Response($message, $code);
});

$app->before(function (Request $request) use ($app) {

    $target = $request->get('_controller');
    if (is_object($target)) {
        return;
    }

    if (!is_array($target)) {
        $target = explode(':', $target, 2);
    }

    list($controller, $action) = $target;
    $valid = forward_static_call_array(array($controller, 'isPublic'), array($action));

    // If the url is public, the user can access =)
    if ($valid) {
        return;
    }

   // Check if the user is logged in
   if (null === $app['session']->get('login')) {
       return $app->redirect('/');
   }

    // If the user is an admin, he can access anything
    if ($app['session']->get('role') == 'admin') {
        return ;
    }



         // Check if the action is accessible by guest users
         $validVendedor = forward_static_call_array(array($controller, 'isVendedor'), array($action));

         //Common users only access the /project controller
         if (!$validVendedor) {
             return $app->redirect('/vendedor');
         }

});

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'pattern' => '^/',
            'form' => array(
                'login_path' => '/login',
                'check_path' => '/admin/login_check',
                'username_parameter' => 'form[username]',
                'password_parameter' => 'form[password]',
            ),
            'logout'  => true,
            'anonymous' => true,

        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
));

$app->mount('/', new Windcell\Controller\IndexController);
$app->mount('/admin/ddd', new Windcell\Controller\DDDController);
$app->mount('/admin/loja', new Windcell\Controller\LojaController);
$app->mount('/admin/ipc', new Windcell\Controller\IpcController);
$app->mount('/admin/ld', new Windcell\Controller\LdController);
$app->mount('/admin/sms', new Windcell\Controller\SmsController);
$app->mount('/admin/dependente', new Windcell\Controller\DependenteController);
$app->mount('/admin/plano', new Windcell\Controller\PlanoController);
$app->mount('/admin/user', new Windcell\Controller\UserController);
$app->mount('/vendedor', new Windcell\Controller\VendedorController);

//getting the EntityManager
$app->register(new DoctrineServiceProvider, array(
    'db.options' => $config['db.options']
));

$app->register(new DoctrineOrmServiceProvider(), array(
    'orm.proxies_dir' => sys_get_temp_dir() . '/' . md5(__DIR__ . getenv('APPLICATION_ENV')),
    'orm.em.options' => array(
        'mappings' => array(
            array(
                'type' => 'annotation',
                'use_simple_annotation_reader' => false,
                'namespace' => 'Windcell\Model',
                'path' => __DIR__ . '/src'
            )
        )
    ),
    'orm.proxies_namespace' => 'EntityProxy',
    'orm.auto_generate_proxies' => true,
    'orm.default_cache' => $config['db.options']['cache']
));