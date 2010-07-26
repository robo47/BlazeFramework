<?php
namespace blaze\netlet;

/**
 * Description of NetletContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface NetletContext {

     public function addNetlet($name, $netletClass);
     public function addNetletMapping($name, $urlPattern);
     public function addFilter($name, $filterClass);
     public function addFilterMapping($name, $urlPattern);
     public function addListener($name, $listenerClass);

    /**
     * @param blaze\lang\String|string $name
     * @param mixed $o
     */
     public function setAttribute($name, $o);
    /**
     * @param blaze\lang\String|string $name
     * @return mixed
     */
    public function getAttribute($name);
    /**
     * @param blaze\lang\String|string $name
     */
    public function removeAttribute($name);

    /**
     * @param blaze\lang\String|string $name
     * @param boolean $postType
     * @return blaze\lang\String
     */
    public function getInitParameter($name, $postType = null);
    /**
     * @return blaze\util\Map
     */
    public function getInitParameterMap();
}

?>
