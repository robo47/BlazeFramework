<?php

namespace blaze\web\render\html4;

/**
 * Description of DataTableRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class DataTableRenderer extends \blaze\web\render\html4\CoreRenderer {

    public function __construct() {

    }

    public function decode(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $value = $component->getValue();

        if ($value != null) {
            if ($component->getRowIdentifier() === null)
                $rowId = 0;

            $found = false;

            foreach ($value as $tableEntry) {
                if ($component->getRowIdentifier() !== null)
                    $component->setRowId($tableEntry->getClass()->getMethod('get' . ucfirst($component->getRowIdentifier()))->invoke($tableEntry));

                $context->getELContext()->getContext(\blaze\web\el\ELContext::SCOPE_REQUEST)->set($context, $component->getRowVar(), $tableEntry);
                $found = $this->decodeTableRow($context, $component, $found);

                if ($component->getRowIdentifier() === null)
                    $component->setRowId($rowId++);
            }
            $component->setRowId(-1);
        }
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
            if ($header && $footer)
                break;
        }

        if ($header)
            $this->renderOuterRow($context, $component, true);

        $value = $component->getValue();

//        if(!$value instanceof \blaze\util\ListI)
//            throw new \blaze\lang\IllegalArgumentException('List must be given as value.');

        $writer->write('<tbody>');

        if ($value != null) {
            if ($component->getRowIdentifier() === null)
                $rowId = 0;

            foreach ($value as $tableEntry) {
                if ($component->getRowIdentifier() !== null)
                    $component->setRowId($tableEntry->getClass()->getMethod('get' . ucfirst($component->getRowIdentifier()))->invoke($tableEntry));

                $context->getELContext()->getContext(\blaze\web\el\ELContext::SCOPE_REQUEST)->set($context, $component->getRowVar(), $tableEntry);
                $this->renderTableRow($context, $component);

                if ($component->getRowIdentifier() === null)
                    $component->setRowId($rowId++);
            }
            $component->setRowId(-1);
        }

        $writer->write('</tbody>');

        if ($footer)
            $this->renderOuterRow($context, $component, true);

        $writer->write('</table>');
    }

    private function renderOuterRow(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component, $head) {
        $writer = $context->getResponse()->getWriter();
        if ($head)
            $writer->write('<thead>');
        else
            $writer->write('<tfoot>');
        $writer->write('<tr>');

        foreach ($component->getColumns() as $column) {
            if ($column instanceof \blaze\web\component\html\DataTableColumns) {
                $value = $column->getValue();

                if ($value != null) {
                    $columnId = 0;

                    foreach ($value as $tableColumn) {
                        $column->setColumnId($columnId++);
                        $context->getELContext()->getContext(\blaze\web\el\ELContext::SCOPE_REQUEST)->set($context, $column->getColumnVar(), $tableColumn);
                        if ($head)
                            $this->renderTableCell($context, $component, $column->getHeader(), $head);
                        else
                            $this->renderTableCell($context, $component, $column->getFooter(), $head);
                    }
                    $column->setColumnId(-1);
                }
            }else {
                if ($head)
                    $this->renderTableCell($context, $component, $column->getHeader(), $head);
                else
                    $this->renderTableCell($context, $component, $column->getFooter(), $head);
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
            if ($column instanceof \blaze\web\component\html\DataTableColumns) {
                $value = $column->getValue();

                if ($value != null) {
                    $columnId = 0;

                    foreach ($value as $tableColumn) {
                        $column->setColumnId($columnId++);
                        $context->getELContext()->getContext(\blaze\web\el\ELContext::SCOPE_REQUEST)->set($context, $column->getColumnVar(), $tableColumn);
                        $this->renderTableCell($context, $component, $column, false);
                    }
                    $column->setColumnId(-1);
                }
            } else {
                $this->renderTableCell($context, $component, $column, false);
            }
        }

        $writer->write('</tr>');
    }

    private function decodeTableRow(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component, $found) {
        foreach ($component->getColumns() as $column) {
            if ($column instanceof \blaze\web\component\html\DataTableColumns) {
                $value = $column->getValue();

                if ($value != null) {
                    $columnId = 0;

                    foreach ($value as $tableColumn) {
                        $column->setColumnId($columnId++);
                        $context->getELContext()->getContext(\blaze\web\el\ELContext::SCOPE_REQUEST)->set($context, $column->getColumnVar(), $tableColumn);
                        $column->processDecodes($context);
                        $this->recursiveUnsetClientId($column);
                        if (!$found && $this->recursiveCheckSelected($column)) {
                            $component->getSelectedRowIndexLocal()->setValue($context, $component->getRowId());
                            $found = true;
                        }
                    }
                    $column->setColumnId(-1);
                }
            } else {
                $column->processDecodes($context);
                $this->recursiveUnsetClientId($column);
                if (!$found && $this->recursiveCheckSelected($column)) {
                    $component->getSelectedRowIndexLocal()->setValue($context, $component->getRowId());
                    $found = true;
                }
            }
        }

        return $found;
    }

    private function renderTableCell(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component, $parent, $head) {
        $writer = $context->getResponse()->getWriter();

        if ($parent != null) {
//            $colspan = $parent->getSpan();
            $styleClass = $parent->getStyleClass();
            $style = $parent->getStyle();

            if ($head)
                $writer->write('<th');
            else
                $writer->write('<td');

//            if ($colspan != null)
//                $writer->write(' colspan="' . $colspan . '"');
            if ($styleClass != null)
                $writer->write(' class="'.$styleClass.'"');
            if ($style != null)
                $writer->write(' style="'.$style.'"');

            $writer->write('>');
            $parent->processRender($context);
            $this->recursiveUnsetClientId($parent);

            if ($head)
                $writer->write('</th>');
            else
                $writer->write('</td>');
        }
    }

    private function recursiveUnsetClientId(\blaze\web\component\UIComponent $component) {
        $component->unsetClientId();
        foreach ($component->getChildren() as $child)
            $this->recursiveUnsetClientId($child);
    }

    private function recursiveCheckSelected(\blaze\web\component\UIComponent $component) {
        if ($component instanceof \blaze\web\component\UICommand){
            return $component->getClicked();
        }

        $found = false;

        foreach ($component->getChildren() as $child){
            if($found)
                break;
            if($this->recursiveCheckSelected($child) === true)
                    $found = true;
        }
        
        return $found;
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        
    }

    public function renderChildren(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        
    }

}

?>
