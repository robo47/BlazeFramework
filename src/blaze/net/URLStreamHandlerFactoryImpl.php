<?php

namespace blaze\net;

/**
 * Description of URLStreamHandlerFactory
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class URLStreamHandlerFactoryImpl implements URLStreamHandlerFactory{
    /**
     * @param \blaze\lang\String|string $protocol
     * @return blaze\net\URLStreamHandler
     */
    public function createURLStreamHandler($protocol){
        switch(\blaze\lang\String::asWrapper($protocol)->toLowerCase()->toNative()){
            case 'http':
                break;
            case 'https':
                break;
            case 'ftp':
                break;
        }
    }
}

?>
