<?php
namespace blaze\web\application;

/**
 * Description of WebView
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface WebView {
    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\web\tag\Tag Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
     */
     public function getViewRoot();
     public function processDecodes(\blaze\web\application\BlazeContext $context);
     public function processValidations(\blaze\web\application\BlazeContext $context);
     public function processUpdates(\blaze\web\application\BlazeContext $context);
     public function processApplication(\blaze\web\application\BlazeContext $context);
}

?>
