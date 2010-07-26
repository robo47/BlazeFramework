<?php

namespace blazeServer\source\netlet;

use blaze\lang\Object,
 blaze\netlet\http\HttpNetletRequestWrapper,
 blaze\netlet\http\HttpNetletResponseWrapper,
 blaze\lang\ClassWrapper;

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
class NetletContainer extends Object {

    /**
     * Beschreibung
     */
    public function __construct() {

    }

    public static function main($args) {
        $container = new NetletContainer();
        $container->process();
    }

    public function process() {
        $request = new HttpNetletRequestWrapper();
        $response = new HttpNetletResponseWrapper();

        try{
            // Get application and the configuration class of the application
            $app = \blazeServer\source\core\NetletApplication::getAdminApplication();//getApplication($request);
            $netletConfMap = $app->getConfig()->getNetletConfigurationMap();

            // Create a new NetletContext for the Netlet
            $netletContext = new NetletContextImpl(array());

            // Making sure that the Url ends with a '/'
            $uri = $request->getRequestURI()->getPath();
            if (!$uri->endsWith('/'))
                $uri = $uri->concat('/');

            $netletName = $this->getRequestedNetletName($uri, $netletConfMap['netletMapping']);

            if($netletName == null){
                $response->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND, 'There was no netlet for the request found.');
                $this->finish($response);
                return;
            }

            $netlet = $this->getNetletClassByName($netletName, $netletConfMap['netlets']);
            
            if($netlet == null){
                $response->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND, 'There was no netlet for the given netlet name found.');
                $this->finish($response);
                return;
            }

            $filterNames = $this->getRequestedFilterNames($uri, $netletConfMap['filterMapping']);

            $filters = array();

            foreach($filterNames as $filterName){
                $filter = $this->getFilterClassByName($filterName, $netletConfMap['filters']);
                
                if($filter == null){
                    $response->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND, 'There was no filter for the given filter name found.');
                    $this->finish($response);
                    return;
                }else{
                    $filters[$filterName] = $filter;
                }
            }

            $registeredFilters = array();

            foreach($filters as $filterName => $filter){
                $conf = new \blazeServer\source\filter\FilterConfigImpl($filterName, $netletContext, $this->getFilterInitParams($filterName, $netletConfMap['filters']));
                $filterObj = $filter->newInstance();
                $filterObj->init($conf);
                $registeredFilters[] = $filterObj;
            }

            $filterChain = new \blazeServer\source\filter\FilterChainImpl($registeredFilters);
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
        $this->finish($response);
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
