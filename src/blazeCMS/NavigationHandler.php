<?php
namespace blazeCMS;
use blaze\lang\Object,
    blaze\lang\String;

/**
 * Description of NavigationHandler
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class NavigationHandler extends Object {

    /**
     *
     * @var blaze\lang\String
     */
    private $uri;
    /**
     *
     * @var array
     */
    private $mapping;
    /**
     *
     * @var blaze\lang\String
     */
    private $basePath = null;

    /**
     * Beschreibung
     */
    public function __construct($mapping){
        $this->mapping = $this->sortMapping($mapping['mapping']);
    }

    /**
     *
     * @param String $uri
     * @return string
     */
    private function getMappingPath(String $uri){
        if(!$uri->endsWith('/'))
            $uri = $uri->concat('/');
        $context = WebContext::getInstance();
        $path = $context->getParameter('work.dir').'/view';

        foreach($this->mapping as $key => $value){
            $regex = '/'.strtolower(str_replace(array('/','*'), array('\/','.*'), $key)).'/';
            
            if($uri->matches($regex)){
                $path .= $value;
                break;
            }
        }

        return $path;
    }

    private function sortMapping($mapping){
        uksort($mapping, array($this,'compare'));
        return $mapping;
    }

    private function compare($a, $b){
        return strlen($a) - strlen(b);
    }

    public function getBasePath(){
        return $this->basePath;
    }

    public function getBasePathFor($uri){
        return $this->getMappingPath(String::asWrapper($uri));
    }

    public function navigate($destination){
        $this->basePath = $this->getBasePathFor($destination);
    }
}

?>
