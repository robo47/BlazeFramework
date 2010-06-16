<?php
namespace blaze\net;
use blaze\lang\Object;

/**
 * Description of URI
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class URI extends Object {

    private $scheme;
    private $userInfo;
    private $host;
    private $port;
    private $path;
    private $query;
    private $fragment;

    public function __construct($scheme, $userInfo, $host, $port, $path, $query, $fragment) {
        $this->scheme = $scheme;
        $this->userInfo = $userInfo;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\String|string $uri Beschreibung des Parameters
     * @return 	blaze\net\URI Beschreibung was die Methode zurückliefert
     * @throws	blaze\lang\Exception
     */
     public static function parseURI($uri){
        $matches = array();

        //<scheme>://<user>:<password>@<host>:<port>/<path>?<query>#<anchor>
        //Check for <scheme>://<userinfo>@<other>
         if(preg_match('/^(.+):\/\/((.+)@)?(.+)$/', trim($uri, '/'), $matches) == 0)
                 throw new \blaze\lang\Exception('Invalid URI');

         $scheme = $matches[1];
         $userInfo = $matches[3];
         $other = trim($matches[4],'/');

         //Check for <host>[:<port>]/<other>
         if(preg_match('/^(.+):([0-9]{1,5})\\/(.+)$/', $other, $matches) == 0 &&
            preg_match('/^(.+)()\\/(.+)$/', $other, $matches) == 0 &&
            preg_match('/^(.+):([0-9]{1,5})()$/', $other, $matches) == 0 &&
            preg_match('/^(.+)()()$/', $other, $matches) == 0)
                 throw new \blaze\lang\Exception('Invalid URI');

         $host = $matches[1];
         $port = $matches[2];
         $other = $matches[3];
         $path = null;
         $query = null;
         $fragment = null;
         
         if(strlen($other) > 0){
             if(preg_match('/^(.+)\?(.+)#(.+)$/', trim($other, '/'), $matches) == 0 &&
                preg_match('/^(.+)\?(.+)()$/', trim($other, '/'), $matches) == 0 &&
                preg_match('/^(.+)()#(.+)$/', trim($other, '/'), $matches) == 0 &&
                preg_match('/^(.+)()()$/', trim($other, '/'), $matches) == 0)
                     throw new \blaze\lang\Exception('Invalid URI');

             $path = $matches[1];
             $query = $matches[2];
             $fragment = $matches[3];
         }

         return new URI($scheme, $userInfo, $host, $port, $path, $query, $fragment);
     }

     public function getScheme() {
         return $this->scheme;
     }

     public function getUserInfo() {
         return $this->userInfo;
     }

     public function getHost() {
         return $this->host;
     }

     public function getPort() {
         return $this->port;
     }

     public function getPath() {
         return $this->path;
     }

     public function getQuery() {
         return $this->query;
     }

     public function getFragment() {
         return $this->fragment;
     }

     
}

?>
