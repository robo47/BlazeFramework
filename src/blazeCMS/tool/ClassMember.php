<?php
namespace blazeCMS\tool;
use blaze\lang\Object;

/**
 * Description of ClassMember
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ClassMember extends Object {
    /**
     *
     * @var string
     */
    private $name;
    /**
     *
     * @var string
     */
    private $type;
    private $dbColumn;

    function __construct($name, $type, $dbColumn) {
        $this->name = $name;
        $this->type = $type;
        $this->dbColumn = $dbColumn;
    }

    /**
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     *
     * @param string $name
     * @return blazeCMS\tool\ClassMember
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     *
     * @param string $type
     * @return blazeCMS\tool\ClassMember
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDbColumn() {
        return $this->dbColumn;
    }

    /**
     *
     * @param string $type
     * @return blazeCMS\tool\ClassMember
     */
    public function setDbColumn($dbColumn) {
        $this->dbColumn = $dbColumn;
        return $this;
    }


}

?>
