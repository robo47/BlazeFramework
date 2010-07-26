<?php
namespace blazeCMS\requestHandler;
use blaze\lang\Object,
    blazeCMS\WebContext,
    blaze\netlet\http\HttpNetletRequest,
    blaze\netlet\http\HttpNetletResponse;

/**
 * Description of LoginRequestHandler
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class LoginRequestHandler extends Object  implements RequestHandler {

    public function handle(HttpNetletRequest $request, HttpNetletResponse $response) {
        $context = WebContext::getInstance();
        $file = null;
        $contentType = 'text/plain';

        try{
            switch($context->getParameter('module')->toLowerCase()){
                case 'db':
                    break;
                case 'dir':
                    $fis = null;
                    $basedir = null;

                    switch($context->getParameter('module.action')->toLowerCase()->toNative()){
                        case 'js':
                            $basedir = $context->getParameter('js.dir');
                            break;
                        case 'style':
                            $basedir = $context->getParameter('style.dir');
                            break;
                        case 'image':
                            $basedir = $context->getParameter('image.dir');
                            break;
                        default:
                            $basedir = $context->getParameter('file.dir');
                            break;
                    }


                    try{
                        $f = new \blaze\io\File($basedir, $context->getParameter('module.params'));

                        if($f->isChildOf($context->getParameter('work.dir')) && $f->exists()){
                            //$fis = new \blaze\io\FileInputStream($f);
                            $file = file_get_contents($f->getAbsolutePath());//$fis->read($fis->available());
                            $contentType = $this->guessMimeType($f);
                        }
                    }catch(\blaze\lang\Exception $e){
                        $file = null;
                    }

                    if($fis != null)
                        $fis->close();
                    break;
                default:
                    break;
            }
        }catch(\blaze\lang\Exception $e){
            $file = null;
        }

        $response->setContentType($contentType);

        if($file == null)
            $response->sendError(HttpNetletResponse::SC_NOT_FOUND);
        else
            $response->getWriter()->write($file);

        return;
    }
    public function init(RequestHandlerConfig $config) {

    }

    /**
     *
     * @param File $f
     * @return string
     */
    private function guessMimeType(File $f){
        $type = 'text/plain';

        try{
            $suffix = $f->getAbsolutePath()->substring($f->getAbsolutePath()->lastIndexOf('.') + 1)
                                           ->toLowerCase()
                                           ->toNative();

            switch($suffix){
                case 'css':
                    $type = 'text/css';
                    break;
                case 'js':
                    $type = 'application/x-javascript';
                    break;
                case 'pdf':
                    $type = 'application/pdf';
                    break;
                case 'zip':
                    $type = 'application/x-zip-compressed';
                    break;
                case 'rar':
                    $type = 'application/x-rar-compressed';
                    break;
                case 'jpg':
                case 'jpeg':
                    $type = 'image/jpeg';
                    break;
                case 'png':
                    $type = 'image/png';
                    break;
                case 'gif':
                    $type = 'image/gif';
                    break;
                case 'bmp':
                    $type = 'image/bmp';
                    break;
                default:
                    break;
            }
        }catch(\blaze\lang\Exception $e){

        }

        return $type;
    }
}

?>
