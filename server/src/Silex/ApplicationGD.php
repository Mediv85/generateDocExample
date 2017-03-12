<?php

namespace GDexample\Silex;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestMatcher;

use Silex\Provider\MonologServiceProvider;
use JDesrosiers\Silex\Provider\CorsServiceProvider;

use GDexample\Silex\Provider\Controller\GDControllerProvider;



class ApplicationGD extends Application
{
    public function __construct(array $values = [])
    {
        parent::__construct($values);


        $this['debug'] = true;

        //set Monolog
        $this->register(new MonologServiceProvider(), array(
            'monolog.logfile' => __DIR__.'/../development.log',
        ));


        //set CORS filter
        $this->register(new CorsServiceProvider(), array(
          "cors.allowOrigin" => "*",
          "cors.allowMethods" => "GET,PUT,POST,DELETE,OPTIONS",
          "cors.exposeHeaders" => "X-CSRF-Token X-Requested-With Accept Accept-Version Content-Length Content-MD5 Content-Type Date X-Api-Version X-HTTP-Method-Override Origin"
        ));

        //imposto lettura json parameter
        $this->before(function (Request $request) {
          if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
          }
        });




      /***                 ***
      *         PDF         *
      ***                 ***/


      //$this['monolog']->info("RENDERNAME: TRUE");

      //PDF and document settings
      \PhpOffice\PhpWord\Settings::setPdfRendererPath(__DIR__.'/../../vendor/mpdf/mpdf');
      \PhpOffice\PhpWord\Settings::setPdfRendererName('MPDF');
      \PhpOffice\PhpWord\Settings::setTempDir(__DIR__.'/../../tmp/');


        //Set CONTROLLERS
        $this->mount('/gen', new GDControllerProvider());


        //enabled CORS autorization defined before
        $this["cors-enabled"]($this);

    }
}



 ?>
