<?php

namespace blazeServer;

use blaze\web\Application,
 blazeServer\source\BlazeApplication,
 blaze\io\File,
 blaze\lang\String,
 blaze\lang\Object,
 blaze\lang\Exception,
 blaze\lang\ClassNotFoundException,
 blaze\lang\System,
 blaze\web\http\HttpNetletRequestWrapper,
 blaze\web\ApplicationContext,
 blaze\web\http\HttpSession;

/**
 * Description of Main
 *
 * @author Christian Beikov
 */
class Main extends Object {

    public function __construct() {
        
    }

    public static function main($args) {
//        try{
        // HTTP Header capsulation happens in HttpNetletRequestWrapper
        $request = ApplicationContext::getInstance()->getRequest();
        $response = ApplicationContext::getInstance()->getResponse();
        $app = BlazeApplication::getCurrentApplication();

        if ($app == null)
            $response->sendError(HttpNetletResponse::SC_NOT_FOUND);

        // Build the "beacon"-map from web.xml
        $variableMapper = new \blaze\util\HashMap();
        $variableMapper->set('test', new Test());
        \blazeCMS\WebContext::getInstance()->setAttribute('elcontext', new \blaze\web\el\ELContext($variableMapper));

        $requViewClass = $app->getRequestedViewClass();

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
                \blazeCMS\WebContext::getInstance()->getAttribute('elcontext')->getELResolver()->setValue($valueExpr, $paramDef->getValue());
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
                    \blazeCMS\WebContext::getInstance()->getAttribute('elcontext')->getELResolver()->invoke($valueExpr, null);
                }

                $action = $actionDef->getAction();

                if ($action != null) {
                    $actionVal = String::asWrapper($action);
                    if ($actionVal->matches('/^{.*}$/')) {
                        $valueExpr = new \blaze\web\el\Expression($actionVal->substring(1, $actionVal->length() - 1));
                        $navigationMethod = \blazeCMS\WebContext::getInstance()->getAttribute('elcontext')->getELResolver()->invoke($valueExpr, null);
                    } else {
                        $navigationMethod = $actionVal;
                    }
                }
            }
        }



        // Render Response
        $responseWriter = $response->getWriter();
        $responseWriter->write($app->getRequestedView()->getComponents()->render());
        $responseWriter->close();

        /**
         * Start the steps of the lifecycle
         *
         * 1 - HTTP Header capsulation
         * 2 - Parameter mapping and Converting/Validating
         * 3 - Update models
         * 4 - Execute Actions
         * 5 - Render response
         */
//        }catch(Exception $e){
//            echo $e->getMessage();
//        }
    }

}
?>
