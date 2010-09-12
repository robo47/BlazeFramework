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
class MessagesRenderer extends \blaze\web\render\html4\CoreRenderer{

    public function __construct(){

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $messages = $context->getMessages($component->getFor());

        if(count($messages) > 0){
            $writer->write('<ul');
        }
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $messages = $context->getMessages($component->getFor());

        if(count($messages) > 0){
            $writer->write('>');

            foreach($messages as $message){
                $writer->write('<li>');
                $writer->write($message->getSummary());
                $writer->write('</li>');
            }

            $writer->write('</ul>');
        }
    }

    public function renderChildren(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {

    }

    public function  renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $messages = $context->getMessages($component->getFor());
        if(count($messages) > 0)
            parent::renderAttributes($context, $component);
    }



}

?>
