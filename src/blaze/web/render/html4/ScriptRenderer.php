<?php
namespace blaze\web\render\html4;

/**
 * Description of BaseRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ScriptRenderer extends \blaze\web\render\Renderer{

    public function __construct(){

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<script');
        $src = $component->getSrc();

        $writer->write(' type="text/javascript"');
        if($src != null)
            $writer->write(' src="'.$src.'"');
        $writer->write('>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('</script>');
    }


}

?>
