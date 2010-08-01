<?php
namespace blazeCMS\requestHandler;
use blaze\lang\Object,
    blazeCMS\WebContext,
    blazeCMS\NavigationHandler,
    blaze\io\File,
    blaze\netlet\http\HttpNetletRequest,
    blaze\netlet\http\HttpNetletResponse;

/**
 * Description of ViewRequestHandler
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
         * @var blazeCMS\NavigationHandler
         */
        $mapper = $config->getInitParameter('mapper');

        if($mapper != null)
            $this->viewDir = $mapper->getBasePath();
    }
}

?>
