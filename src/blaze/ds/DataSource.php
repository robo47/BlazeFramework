<?php
namespace blaze\ds;

/**
 * Description of DataSource
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface DataSource {
    /**
     *
     * @param <type> $user
     * @param <type> $password
     * @param <type> $options
     * @return 	blaze\ds\Connection Beschreibung was die Methode zurückliefert
     */
     public function getConnection($user = null, $password = null, $options = null);
     /**
      *
      * @param <type> $driver
      * @param <type> $host
      * @param <type> $port
      * @param <type> $database
      * @param <type> $user
      * @param <type> $password
      * @param <type> $options
      * @return blaze\ds\DataSource
      */
     public static function getDataSource($host, $port, $database, $user = null, $password = null, $options = null);
}

?>
