<?php
namespace blaze\net;
use blaze\lang\Object;

/**
 * Description of URI
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class URI extends Object {

    /**
     *
     * @var blaze\lang\String
     */
    private $scheme;
    /**
     *
     * @var blaze\lang\String
     */
    private $user;
    /**
     *
     * @var blaze\lang\String
     */
    private $password;
    /**
     *
     * @var blaze\lang\String
     */
    private $host;
    /**
     *
     * @var int
     */
    private $port;
    /**
     *
     * @var blaze\lang\String
     */
    private $path;
    /**
     *
     * @var blaze\lang\String
     */
    private $query;
    /**
     *
     * @var blaze\lang\String
     */
    private $fragment;

    /**
     *
     * @param blaze\lang\String|string $scheme
     * @param blaze\lang\String|string $userInfo
     * @param blaze\lang\String|string $host
     * @param int $port
     * @param blaze\lang\String|string $path
     * @param blaze\lang\String|string $query
     * @param blaze\lang\String|string $fragment
     */
    public function __construct($scheme, $user, $password, $host, $port, $path, $query, $fragment) {
        $this->scheme = \blaze\lang\String::asWrapper($scheme);
        $this->user = \blaze\lang\String::asWrapper($user);
        $this->password = \blaze\lang\String::asWrapper($password);
        $this->host = \blaze\lang\String::asWrapper($host);
        $this->port = \blaze\lang\Integer::asNative($port);
        $this->path = \blaze\lang\String::asWrapper($path);
        $this->query = \blaze\lang\String::asWrapper($query);
        $this->fragment = \blaze\lang\String::asWrapper($fragment);
    }

    /**
     * Description
     *
     * @param 	blaze\lang\String|string $uri Description of the parameter $var
     * @return 	blaze\net\URI Description of what the method returns
     * @throws	blaze\lang\Exception
     */
     public static function parseURI($uri){
        $uri = \blaze\lang\String::asWrapper($uri);
        $idx = $uri->indexOf('://');

        if($idx == -1)
            throw new \blaze\lang\Exception('Invalid URI');

        $scheme = $uri->substring(0, $idx);
        $schemes = $scheme->split(':');
        $uri = $schemes[0].$uri->substring($idx);
        $parts = parse_url($uri);

        $host = isset($parts['host']) ? $parts['host'] : null;
        $port = isset($parts['port']) ? $parts['port'] : null;
        $user = isset($parts['user']) ? $parts['user'] : null;
        $password = isset($parts['pass']) ? $parts['pass'] : null;
        $path = isset($parts['path']) ? $parts['path'] : null;
        $query = isset($parts['query']) ? $parts['query'] : null;
        $fragment = isset($parts['fragment']) ? $parts['fragment'] : null;

//        $matches = array();
//
//        //<scheme>://<user>:<password>@<host>:<port>/<path>?<query>#<anchor>
//        //Check for <scheme>://<userinfo>@<other>
//         if(preg_match('/^(.+):\/\/((.+)@)?(.+)$/', trim($uri, '/'), $matches) == 0)
//                 throw new \blaze\lang\Exception('Invalid URI');
//
//         $scheme = $matches[1];
//         $userInfo = $matches[3];
//         $other = trim($matches[4],'/');
//
//         //Check for <host>[:<port>]/<other>
//         if(preg_match('/^(.+):([0-9]{1,5})\\/(.+)$/', $other, $matches) == 0 &&
//            preg_match('/^(.+)()\\/(.+)$/', $other, $matches) == 0 &&
//            preg_match('/^(.+):([0-9]{1,5})()$/', $other, $matches) == 0 &&
//            preg_match('/^(.+)()()$/', $other, $matches) == 0)
//                 throw new \blaze\lang\Exception('Invalid URI');
//
//         $host = $matches[1];
//         $port = $matches[2];
//         $other = $matches[3];
//         $path = null;
//         $query = null;
//         $fragment = null;
//
//         if(strlen($other) > 0){
//             if(preg_match('/^(.+)\?(.+)#(.+)$/', trim($other, '/'), $matches) == 0 &&
//                preg_match('/^(.+)\?(.+)()$/', trim($other, '/'), $matches) == 0 &&
//                preg_match('/^(.+)()#(.+)$/', trim($other, '/'), $matches) == 0 &&
//                preg_match('/^(.+)()()$/', trim($other, '/'), $matches) == 0)
//                     throw new \blaze\lang\Exception('Invalid URI');
//
//             $path = $matches[1];
//             $query = $matches[2];
//             $fragment = $matches[3];
//         }
         return new URI($scheme, $user, $password, $host, $port, $path, $query, $fragment);
     }

     public function getScheme() {
         return $this->scheme;
     }

     public function getUser() {
         return $this->user;
     }

     public function getPassword() {
         return $this->password;
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
