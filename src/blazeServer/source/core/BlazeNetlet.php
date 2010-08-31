<?php

namespace blazeServer\source\core;
use blaze\lang\Object,
    blaze\lang\System,
    blaze\lang\StaticInitialization,
    blaze\io\File,
    blaze\lang\String,
    blaze\lang\ClassWrapper,
    blaze\lang\ClassLoader,
    blaze\web\application\Application,
    blaze\web\application\BlazeContext,
    blaze\web\ApplicationError,
    blaze\netlet\http\HttpNetlet,
    blaze\netlet\NetletConfig,
    blaze\netlet\NetletRequest,
    blaze\netlet\NetletResponse,
    blaze\netlet\http\HttpNetletRequest,
    blaze\netlet\http\HttpNetletResponse,
    blaze\netlet\http\HttpUserAgent;

/**
 * Description of NetletContainer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class BlazeNetlet extends HttpNetlet{

    private $config;
    private $context;
    private $application;
    private $lifecycle;
    private $sessionHandlerClass;

    public function __construct(){ }

    public function destroy() { }

    public function init(NetletConfig $config) {
        $this->config = $config;
        $this->context = $config->getNetletContext();
        $netletApp = $this->context->getNetletApplication();

        if($netletApp == null){
            throw new \blaze\lang\Exception('No NetletApplication found!');
        }

        $this->lifecycle = new \blazeServer\source\web\lifecycle\LifecycleImpl();
        $this->application = new BlazeApplication($netletApp, $this->lifecycle);
        $confMap = $this->application->getConfig()->getConfigurationMap();
        
        if(array_key_exists('sessionHandler',$confMap)){
            $this->sessionHandlerClass = ClassWrapper::forName($confMap['sessionHandler']);
        }
    }

    /**
     *
     * @param HttpNetletRequest $request
     * @param HttpNetletResponse $response
     */
    public function service(NetletRequest $request, NetletResponse $response) {
        if($this->sessionHandlerClass != null)
                $request->setSessionHandler($this->sessionHandlerClass->newInstance());
        $appContext = new BlazeContext($this->application, $request, $response);
        $appContext->getELContext()->getContext(\blaze\web\el\ELContext::SCOPE_REQUEST)->resetValues($appContext);
        $this->application->getNavigationHandler()->pushBindings($appContext, $request);

        //$appContext->setExceptionHandler(new \blaze\web\application\ExceptionHandler());

        /**
         * Start the steps of the lifecycle
         *
         * 1 - Restore View
         * 2 - Apply Request Values
         * 3 - Converting/Validating
         * 4 - Update models
         * 5 - Execute Actions
         * 6 - Render response
         */
        $this->lifecycle->execute($appContext);
        $this->lifecycle->render($appContext);
    }

}
?>
