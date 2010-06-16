<?php
namespace blazeCMS\requestHandler;
use blaze\lang\Object,
    blazeCMS\WebContext,
    blazeCMS\UrlMapper,
    blaze\io\File,
    blaze\netlet\http\HttpNetletRequest,
    blaze\netlet\http\HttpNetletResponse;

/**
 * Description of ViewRequestHandler
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ViewRequestHandler extends Object  implements RequestHandler {

    /**
     *
     * @var blaze\lang\String
     */
    private $viewDir;

    public function handle(HttpNetletRequest $request, HttpNetletResponse $response) {
        $context = WebContext::getInstance();
        $f = new File($this->viewDir,$context->getParameter('site')->toUpperCase(true));

        if(!$f->isChildOf($this->viewDir)){
            $response->sendError(HttpNetletResponse::SC_NOT_FOUND);
            return;
        }

        $className = $f->getAbsolutePath()->substring(\blaze\lang\ClassLoader::getClassPath()->length());
        $view = \blaze\lang\ClassWrapper::forName($className)->newInstance();
        $response->getWriter()->write($view->getComponents()->render());
    }
    public function init(RequestHandlerConfig $config) {
        /**
         * @var blazeCMS\UrlMapper
         */
        $mapper = $config->getInitParameter('mapper');

        if($mapper != null)
            $this->viewDir = $mapper->getBasePath();
    }
}

?>
