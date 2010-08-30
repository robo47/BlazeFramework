<?php
namespace blaze\netlet;

/**
 * Description of NetletContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface NetletContext {

     public function addNetlet($name, \blaze\netlet\Netlet $netlet);
     public function getNetlets();
     
     public function addNetletMapping($uriMapping, $name);
     public function getNetletMapping();

     public function addFilter($name, \blaze\netlet\Filter $filter);
     public function getFilters();

     public function addFilterMapping($uriMapping, $name);
     public function getFilterMapping();

     public function addListener($name, $listenerClass);
     public function getListeners();

     /**
      * @return \blazeServer\source\netlet\NetletApplication
      */
     public function getNetletApplication();

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
