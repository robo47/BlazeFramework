<?php
namespace blaze\web\render\html4;

/**
 * Description of MetaRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class MetaRenderer extends \blaze\web\render\Renderer{

    public function __construct(){

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<meta');

        if($component instanceof \blaze\web\component\html\ContentType)
            $writer->write(' http-equiv="Content-Type" content="'.$component->getValue().'; charset='.$component->getCharset().'"');
        else if($component instanceof \blaze\web\component\html\ContentLanguage)
            $writer->write(' http-equiv="Content-Language" content="'.$component->getValue().'"');
        else if($component instanceof \blaze\web\component\html\Keywords)
            $writer->write(' name="keywords" content="'.$component->getValue().'"');
        else if($component instanceof \blaze\web\component\html\Description)
            $writer->write(' name="description" content="'.$component->getValue().'"');
        $writer->write('/>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
    }


}

?>
