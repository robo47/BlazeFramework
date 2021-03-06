<?php

namespace blaze\netlet;

/**
 * Description of NetletContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface NetletContext {
    public function addNetlet(\blaze\lang\String $name, \blaze\netlet\Netlet $netlet);

    public function getNetlets();

    public function addNetletMapping(\blaze\lang\String $uriMapping, \blaze\lang\String $name);

    public function getNetletMapping();

    public function addFilter(\blaze\lang\String $name, \blaze\netlet\Filter $filter);

    public function getFilters();

    public function addFilterMapping(\blaze\lang\String $uriMapping, \blaze\lang\String $name);

    public function getFilterMapping();

    public function addListener($listenerClass);

    public function getListeners();

    /**
     * @return \blazeServer\source\netlet\NetletApplication
     */
    public function getNetletApplication();

    /**
     * @param blaze\lang\String|string $name
     * @param mixed $o
     */
    public function setAttribute(\blaze\lang\String $name, $o);

    /**
     * @param blaze\lang\String|string $name
     * @return mixed
     */
    public function getAttribute(\blaze\lang\String $name);

    /**
     * @param blaze\lang\String|string $name
     */
    public function removeAttribute(\blaze\lang\String $name);

    /**
     * @param blaze\lang\String|string $name
     * @return blaze\lang\String
     */
    public function getInitParameter(\blaze\lang\String $name);

    /**
     * @return blaze\util\Map
     */
    public function getInitParameterMap();
}

?>
