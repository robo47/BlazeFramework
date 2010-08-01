<?php
namespace blaze\web\el;
use blaze\lang\Object,
    blaze\util\Map;

/**
 * Description of ELContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ELContext extends Object{
    protected $variableMapper;
    protected $resolver;

    public function __construct(Map $variableMapper) {
        $this->variableMapper = $variableMapper;
        $this->resolver = new ELResolver($this);
    }

    /**
     *
     * @return blaze\lang\Map
     */
    public function getVariableMapper() {
        return $this->variableMapper;
    }

    /**
     *
     * @return blaze\web\el\ELResolver
     */
    public function getELResolver() {
        return $this->resolver;
    }



}

?>
