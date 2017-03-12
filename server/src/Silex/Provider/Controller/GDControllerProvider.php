<?php

namespace GDexample\Silex\Provider\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class GDControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->post('/docpdf', function (Request $request) use ($app) {

          $post = array(
            'text'    => $request->request->get('text'));


            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            $this->html2Doc($phpWord, $post['text']);

/*
            $tableStyle = array(
                'borderColor' => '006699',
                'borderSize' => 6,
                'cellMargin' => 50
            );
            $firstRowStyle = array('bgColor' => '66BBFF');
            $phpWord->addTableStyle('myTable', $tableStyle);//, $firstRowStyle);
            $table = $section->addTable('myTable');


            $table->addRow();
            $table->addCell(10)->addText($post['text']);
*/
            // Generate Word2007 file
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save('tmp/helloWorld.docx');

            // Generate ODT file
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
            $objWriter->save('tmp/helloWorld.odt');

            //load file for pdf creator
            //$temp = \PhpOffice\PhpWord\IOFactory::load(__DIR__.'/../../../../tmp/helloWorld.docx');

            //generate PDF file
            $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
            $xmlWriter->save('tmp/sampledocument.pdf');

            $file=__DIR__.'/../../../../tmp/sampledocument.pdf';


               return $app->sendFile($file);
           });


        return $controllers;
    }



    private function html2Doc(\PhpOffice\PhpWord\PhpWord $document, String $html){
        $section = $document->addSection();
        $section->addText("Standard TEXT!!! START ----------------------------------------");

        $section->addLink("http://localhost:8888/", "link me all");//, mixed $fStyle = null, mixed $pStyle = null) : \PhpOffice\PhpWord\Element\Link
        $section->addTitle("I'm entitled", 1);
        $section->addListItem("I'm a cool list item", 0);//, mixed $font = null, mixed $list = null, mixed $para = null);
        $section->addTextBreak(2);

        $section->addText('Basic simple bulleted list.');
        $section->addListItem('List Item 1');
        $section->addListItem('List Item 2');
        $section->addListItem('List Item 3');
        $section->addTextBreak(2);

        $section->addText("Standard TEXT!!! END ------------------------------------------");

        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);

        return $section;
    }
}

 ?>
