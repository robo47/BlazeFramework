<?php
namespace blazeCMS;
use blaze\lang\Object,
    blaze\lang\String,
    blaze\netlet\http\HttpNetletRequest,
    blaze\netlet\http\HttpNetletResponse;

/**
 * Description of WebSetup
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class WebSetup extends Object {

    /**
     *
     * @var blaze\netlet\http\HttpNetletRequest
     */
    private static $request;
    /**
     *
     * @var blaze\netlet\http\HttpNetletResponse
     */
    private static $response;
    /**
     * Immer mit '/' starten
     * @var string
     */
    private static $urlPrefix = '/BlazeFrameworkServer';
    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\lang\Object Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
     public static function init(HttpNetletRequest $request, HttpNetletResponse $response){
         self::$request = $request;
         self::$response = $response;

        self::initDirectoryStructure();
        self::initConfig();
        self::initUrlRewrite();
     }

     public static function initDirectoryStructure(){
         $context = WebContext::getInstance();
         $context->setParameter('work.dir'          , \blaze\lang\ClassLoader::getClassPath().'/blazeCMS');
         $context->setParameter('image.dir'         , $context->getParameter('work.dir').'/image');
         $context->setParameter('style.dir'         , $context->getParameter('work.dir').'/style');
         $context->setParameter('file.dir'          , $context->getParameter('work.dir').'/file');
         $context->setParameter('js.dir'            , $context->getParameter('work.dir').'/js');
     }

     public static function initConfig(){
     }

     public static function initUrlRewrite(){
        $context = WebContext::getInstance();
        $uri = self::$request->getRequestURI();

        if($uri->startsWith(self::$urlPrefix,0,true))
                $uri = $uri->substring(strlen(self::$urlPrefix));

        $uri = $uri->replaceAll('/\/+/','/')->trim('/');
        $requestPieces = $uri->split('/',5);
        /*
         * admin - reserved for cms
         * main - is used for site action which deliver non-Html content
         */
        $context->setParameter('site'         ,isset($requestPieces[0]) ? $requestPieces[0] : 'home');
        /*
         *  show   -
         *  update -
         *  delete -
         *  add    -
         *  image  -
         *  file   -
         */
        $context->setParameter('site.action'  ,isset($requestPieces[1]) ? $requestPieces[1] : 'show');
        $context->setParameter('module'       ,isset($requestPieces[2]) ? $requestPieces[2] : 'index');
        $context->setParameter('module.action',isset($requestPieces[3]) ? $requestPieces[3] : null);
        $context->setParameter('module.params',isset($requestPieces[4]) ? $requestPieces[4] : null);
     }
}

?>
