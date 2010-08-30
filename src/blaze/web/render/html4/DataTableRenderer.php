<?php

namespace blaze\web\render\html4;

/**
 * Description of DataTableRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class DataTableRenderer extends \blaze\web\render\html4\CoreRenderer {

    public function __construct() {

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<table');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes($context, $component);
        $writer = $context->getResponse()->getWriter();
        $caption = $component->getCaption();
        $summary = $component->getSummary();

        if ($summary != null)
            $writer->write(' summary="' . $summary . '"');
        $writer->write('>');

        if ($caption != null) {
            $captionClass = $component->getCaptionClass();
            $captionStyle = $component->getCaptionStyle();

            $writer->write('<caption');
            if ($captionClass != null)
                $writer->write(' class="' . $captionClass . '"');
            if ($captionStyle != null)
                $writer->write(' style="' . $captionStyle . '"');
            $writer->write('>');
            $writer->write($caption);
            $writer->write('</caption>');
        }
        $header = false;
        $footer = false;

        foreach ($component->getColumns() as $column) {
            if (!$header && $column->hasHeader())
                $header = true;
            if (!$footer && $column->hasFooter())
                $footer = true;
        }

        if ($header)
            $this->renderTablePart($context, $component, true);

        $value = $component->getValue();
        
//        if(!$value instanceof \blaze\util\ListI)
//            throw new \blaze\lang\IllegalArgumentException('List must be given as value.');

        $writer->write('<tbody>');

        $rowId = 0;

        if($value != null){
            foreach($value as $tableEntry){
                $component->setRowId($rowId++);
                $context->getELContext()->getContext(\blaze\web\el\ELContext::SCOPE_REQUEST)->set($context, $component->getRowVar(), $tableEntry);
                $this->renderTableRow($context, $component);
            }
            $component->setRowId(-1);
        }
        
        $writer->write('</tbody>');

        if ($footer)
            $this->renderTablePart($context, $component, true);

        $writer->write('</table>');
    }

    private function renderTablePart(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component, $head) {
        $writer = $context->getResponse()->getWriter();
        if ($head)
            $writer->write('<thead>');
        else
            $writer->write('<tfoot>');
        $writer->write('<tr>');

        foreach ($component->getColumns() as $column) {
            if ($head)
                $element = $column->getHeader();
            else
                $element = $column->getFooter();

            if ($element != null) {
                $colspan = $element->getSpan();

                if ($head)
                    $writer->write('<th');
                else
                    $writer->write('<td');

                if ($colspan != null)
                    $writer->write(' colspan="' . $colspan . '"');

                $writer->write('>');
                $writer->write($element->processRender($context));
                $this->recursiveUnsetClientId($element);

                if ($head)
                    $writer->write('</th>');
                else
                    $writer->write('</td>');
            }
        }

        $writer->write('</tr>');
        if ($head)
            $writer->write('</thead>');
        else
            $writer->write('</tfoot>');
    }

    private function renderTableRow(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<tr>');

        foreach ($component->getColumns() as $column) {
            $writer->write('<td>');
            $column->processRender($context);
            $this->recursiveUnsetClientId($column);
            $writer->write('</td>');
        }

        $writer->write('</tr>');
    }

    private function recursiveUnsetClientId(\blaze\web\component\UIComponent $component){
        $component->unsetClientId();
        foreach($component->getChildren() as $child)
                $this->recursiveUnsetClientId($child);
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        
    }

    public function renderChildren(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        
    }


}
?>
