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
    blaze\web\http\Session;

/**
 * Description of Main
 *
 * @author RedShadow
 */
class Main{
    public static function main($args){
//        try{
            // HTTP Header capsulation happens in HttpNetletRequestWrapper
            $request = ApplicationContext::getInstance()->getRequest();
            $response = ApplicationContext::getInstance()->getResponse();
            $app = BlazeApplication::getCurrentApplication();
            
            if($app == null)
                $response->sendError(HttpNetletResponse::SC_NOT_FOUND);

            $responseWriter = $response->getWriter();

            $responseWriter->write($app->getRequestedView()->getComponents()->render());
            $responseWriter->close();

            /**
             * Start the steps of the lifecycle
             *
             * 1 - HTTP Header capsulation
             * 2 - Converting/Validating
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
