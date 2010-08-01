<?php

namespace blazeServer\source\netlet;

use blaze\lang\Object,
 blazeServer\source\netlet\http\HttpNetletRequestImpl,
 blazeServer\source\netlet\http\HttpNetletResponseImpl,
 blaze\lang\ClassWrapper;

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
class NetletContainer extends Object {

    const DEBUG = true;
    
    public function __construct() { }

    public static function main($args) {
        $container = new NetletContainer();
        $request = new HttpNetletRequestImpl();
        $response = new HttpNetletResponseImpl();
        $response->setHeader('X-Powered-By','BlazeServer');

        ob_start();

        $container->process($request, $response);

        if(self::DEBUG)
            $response->getWriter()->write(ob_get_clean());
        else
            ob_end_clean();
        
        $container->finish($response);
    }

    /**
     * This method wrapps the HTTP-Request and Response and executes the netlets
     * of a running web application or throws an error if the request does not
     * fit to any application.
     */
    public function process(\blaze\netlet\http\HttpNetletRequest $request, \blaze\netlet\http\HttpNetletResponse $response) {
        
        try{
            // Get application and the configuration class of the application
            $app = NetletApplication::getApplication($request);

            if($app == null){
                $response->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND, 'There was no application for the request found.');
                return;
            }

            $netletConfMap = $app->getConfig()->getNetletConfigurationMap();

            // Create a new NetletContext for the Netlet
            $netletContext = new NetletContextImpl(array(), $app);


            // Making sure that the Url ends with a '/'
            $uri = $request->getRequestURI()->getPath();
            if (!$uri->endsWith('/'))
                $uri = $uri->concat('/');

            // Get the Name of the requested netlet by URL Mapping
            $netletName = $this->getRequestedNetletName($uri, $netletConfMap['netletMapping']);

            // Throw an error if no netlet was found
            if($netletName == null){
                $response->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND, 'There was no netlet for the request found.');
                return;
            }

            // Get the ClassWrapper object of the netlet
            $netlet = $this->getNetletClassByName($netletName, $netletConfMap['netlets']);

            // Throw an error if the class could not be found
            if($netlet == null){
                $response->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND, 'There was no netlet for the given netlet name found.');
                return;
            }

            // Get all filters for the request by URL mapping
            $filterNames = $this->getRequestedFilterNames($uri, $netletConfMap['filterMapping']);
            $filters = array();

            foreach($filterNames as $filterName){
                // Get the ClassWrapper objects of the filter
                $filter = $this->getFilterClassByName($filterName, $netletConfMap['filters']);
                
                if($filter == null){
                    $response->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND, 'There was no filter for the given filter name found.');
                    return;
                }else{
                    $filters[$filterName] = $filter;
                }
            }

            // Filters which will be registered in the FilterChain
            $registeredFilters = array();

            foreach($filters as $filterName => $filter){
                $conf = new FilterConfigImpl($filterName, $netletContext, $this->getFilterInitParams($filterName, $netletConfMap['filters']));
                $filterObj = $filter->newInstance();
                $filterObj->init($conf);
                $registeredFilters[] = $filterObj;
            }

            // Create and let the FilterChain run
            $filterChain = new FilterChainImpl($registeredFilters);
            $filterChain->doFilter($request, $response);

            // Create a NetletConfig for the Netlet
            $netletConfig = new NetletConfigImpl($netletName, $netletContext, $this->getNetletInitParams($netletName, $netletConfMap['netlets']));

            // Make an instance of the netlet, call the init and then the service method
            $netlet = $netlet->newInstance();
            $netlet->init($netletConfig);
            $netlet->service($request, $response);
        }catch(Exception $e){
            // Error in the netlet which was not caught
            $response->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND);
        }
    }

    private function finish(\blaze\netlet\http\HttpNetletResponse $response){
        try{
            $responseWriter = $response->getWriter();
            $responseWriter->close();
        }catch(Exception $e){
            // Error of the NetletOutputStream
            var_dump('UNEXPECTED ERROR: '.$e->getMessage());
        }
    }

    private function getNetletClassByName($name, $netlets){
        foreach($netlets as $netletConf){
            if($netletConf['name'] == $name){
                // Get the ClassWrapper object for the netlet class
                return ClassWrapper::forName($netletConf['class']);
            }
        }

        return null;
    }

    private function getFilterClassByName($name, $filters){
        foreach($filters as $filterConf){
            if($filterConf['name'] == $name){
                // Get the ClassWrapper object for the filter class
                return ClassWrapper::forName($filterConf['class']);
            }
        }

        return null;
    }

    private function getRequestedNetletName($uri, $netletMapping){
        // Looking in the netlet mapping for a netlet that fits the url
        foreach ($netletMapping as $key => $value) {
            // Make a regex placeholders of the wildcards
            $regex = '/' . strtolower(str_replace(array('/', '*'), array('\/', '.*'), $key)) . '/';

            // Check if the requested url fits a netlet mapping
            if ($uri->matches($regex)) {
                return $value;
            }
        }

        return null;
    }

    private function getRequestedFilterNames($uri, $filterMapping){
        $filters = array();

        // Looking in the filter mapping for a filter that fits the url
        foreach ($filterMapping as $key => $value) {
            // Make a regex placeholders of the wildcards
            $regex = '/' . strtolower(str_replace(array('/', '*'), array('\/', '.*'), $key)) . '/';

            // Check if the requested url fits a netlet mapping
            if ($uri->matches($regex)) {
                $filters[] = $value;
            }
        }

        return $filters;
    }


    private function getNetletInitParams($name, $netlets){
        foreach ($netlets as $key => $value) {
            if($key == 'name' && $value == $name)
                return $netlets['initParams'];
        }

        return array();
    }

    private function getFilterInitParams($name, $filters){
        foreach ($filters as $key => $value) {
            if($key == 'name' && $value == $name)
                return $filters['initParams'];
        }

        return array();
    }

}
?>
