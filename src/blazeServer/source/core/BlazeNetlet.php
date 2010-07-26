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
    blaze\web\application\ApplicationContext,
    blaze\web\ApplicationError,
    blaze\netlet\http\HttpNetlet,
    blaze\netlet\NetletConfig,
    blaze\netlet\NetletRequest,
    blaze\netlet\NetletResponse;

/**
 * Description of NetletContainer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class BlazeNetlet extends HttpNetlet{

    private $config;

    public function __construct(){ }

    public function destroy() { }

    public function init(NetletConfig $config) {
        $this->config = $config;
    }

    private function getViewClass(\blaze\netlet\http\HttpNetletRequest $request, Application $app){
        // remove the prefix of the url e.g. BlazeFrameworkServer/
        $reqUrl = $request->getRequestURI()->getPath()->trim('/')->replace($app->getUrl(),'');

        // Requesturl has always to start with a '/'
        if($reqUrl->length() == 0 || $reqUrl->charAt(0) != '/')
            $reqUrl = new String('/'.$reqUrl->toNative());

        $navigationMap = $app->getConfig()->getNavigationMap();
        foreach ($navigationMap as $key => $value) {
            if($reqUrl->startsWith($key)){
                // Returns an instance of the requested view
                return ClassWrapper::forName($value['view']);
            }
        }
        return null;
    }

    public function service(NetletRequest $request, NetletResponse $response) {
        $app = new BlazeApplication(NetletApplication::getApplication($request));
        $appContext = new ApplicationContext($app);

        $responseViewClass = $requViewClass = $this->getViewClass($request, $app);

        // Parameter mapping, converting and validating parameters
        $paramDefs = $requViewClass->getMethod('getParamDefinitions')->invoke(null, null);
        foreach ($paramDefs as $paramDef) {
            $val = $request->getParameter($paramDef->getName());
            if ($val != null) {
                $conv = $paramDef->getConverter();

                if ($conv != null)
                    $val = $conv->toObject($val);

                $validator = $paramDef->getValidator();

                if ($validator != null)
                    $validator->validate($val);

                $paramDef->setValue($val);
            }
        }

        // Update Model
        foreach ($paramDefs as $paramDef) {
            $expr = String::asWrapper($paramDef->getExpression());
            if ($expr != null) {
                $valueExpr = new \blaze\web\el\Expression($expr->substring(1, $expr->length() - 1));
                $appContext->getElContext()->getELResolver()->setValue($valueExpr, $paramDef->getValue());
            }
        }

        // Action
        // 1. ActionListener 2. Action
        $navigationMethod = null;
        $actionDefs = $requViewClass->getMethod('getActionDefinitions')->invoke(null, null);

        foreach ($actionDefs as $actionDef) {
            $val = $request->getParameter($actionDef->getName());
            if ($val != null) {
                $actionListener = $actionDef->getActionListener();

                if ($actionListener != null) {
                    $actionListVal = String::asWrapper($actionListener);
                    $valueExpr = new \blaze\web\el\Expression($actionListVal->substring(1, $actionListVal->length() - 1));
                    $appContext->getElContext()->getELResolver()->invoke($valueExpr, null);
                }

                $action = $actionDef->getAction();

                if ($action != null) {
                    $actionVal = String::asWrapper($action);
                    if ($actionVal->matches('/^{.*}$/')) {
                        $valueExpr = new \blaze\web\el\Expression($actionVal->substring(1, $actionVal->length() - 1));
                        $navigationMethod = $appContext->getElContext()->getELResolver()->invoke($valueExpr, null);
                    } else {
                        $navigationMethod = $actionVal;
                    }
                }
            }
        }

        if($navigationMethod != null){

        }

        $responseWriter = $response->getWriter();
        $responseWriter->write($responseViewClass->newInstance()->getComponents()->render());
        $response->getWriter()->write('Working');
    }

}
?>
