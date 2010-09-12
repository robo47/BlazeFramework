<?php
namespace blaze\web\render\event;

/**
 * Description of AddressRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class EventRenderer extends \blaze\web\render\Renderer{

    public function __construct(){

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $type = $component->getType();
        $writer->write('<script type="text/javascript">');


        foreach($component->getEffects() as $effect){
            $id = $component->getParent()->getClientId($context);
            $writer->write('var listener = ');
            $effect->processRender($context);
            $writer->write(';');
            $writer->write('var element = document.getElementById(\''.$id.'\');');
//            $writer->write('if(document.addEventListener)
//                                element.addEventListener(\''.$type.'\', listener, false);
//                            else
//                                element.attachEvent(\'on'.$type.'\', listener);');
            $writer->write('element.on'.$type.' = listener;');
        }

        $writer->write('</script>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        
    }


}

?>
