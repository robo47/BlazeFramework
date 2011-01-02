<?php

namespace blaze\web\render\html4;

/**
 * Description of DataTableRenderer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class SelectListRenderer extends \blaze\web\render\html4\BaseSelectRenderer {

    public function __construct() {

    }

    public function renderBegin(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        $writer = $context->getResponse()->getWriter();
        parent::renderBegin($context, $component);
        $writer->write('<select');
    }

    public function renderAttributes(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        parent::renderAttributes($context, $component);
        $writer = $context->getResponse()->getWriter();
        $size = $component->getSize();
        $items = $component->getItems();
        $value = $this->getValue($context, $component);
        $type = $component->getType();
        $idFieldList = $component->getIdField();

        if ($size != null)
            $writer->write(' size="' . $size . '"');
        else
            $writer->write(' size="' . count($items) . '"');

        $writer->write('>');

        if ($items != null) {
            foreach ($items as $item) {
                if ($item instanceof \blaze\web\component\html\SelectItems) {
                    $subItems = $item->getValue();

                    if (count($subItems) > 0) {
                        $idField = $component->getIdField();
                        $labelField = $item->getLabelField();
                        $disabledField = $item->getDisabledField();

                        if ($idField === null)
                            $id = 0;

                        foreach ($subItems as $subItem) {
                            if ($idField !== null)
                                $id = $subItem->getClass()->getMethod('get' . ucfirst($idField))->invoke($subItem);

                            if ($labelField === null)
                                $label = '';
                            else
                                $label = $subItem->getClass()->getMethod('get' . ucfirst($labelField))->invoke($subItem);

                            if ($disabledField === null)
                                $disabled = false;
                            else
                                $disabledField = $subItem->getClass()->getMethod('get' . ucfirst($disabledField))->invoke($subItem);

                            if ($type === 'multiple')
                                $selected = $this->isSelectedMany($value, $idFieldList, $subItem, $idField);
                            else
                                $selected = $this->isSelectedOne($value, $idFieldList, $subItem, $idField);

                            $this->renderOption($context, $id, $label, $selected, $disabled);

                            if ($idField === null)
                                $id++;
                        }
                    }
                }else{
                    $id = $item->getValue();
                    $label = $item->getLabel();
                    $disabled = $item->getDisabled();
                    
                    if ($type === 'multiple')
                        $selected = $this->isSelectedMany($value, $idFieldList, $id);
                    else
                        $selected = $this->isSelectedOne($value, $idFieldList, $id);

                    $this->renderOption($context, $id, $label, $selected, $disabled);
                }
            }
        }

        $writer->write('</select>');
    }

    private function isSelectedMany($array, $idFieldArray, $item, $idFieldItem = null) {
        if($selectedItem === null || $selectedItem == '')
            return false;
        if($idFieldItem !== null)
            $curVal = $item->getClass()->getMethod('get' . ucfirst($idFieldItem))->invoke($item);
        else
            $curVal = $item;
        
        foreach ($array as $selectedItem) {
            if ($selectedItem->getClass()->getMethod('get' . ucfirst($idFieldArray))->invoke($selectedItem)
                    === $curVal)
                return true;
        }

        return false;
    }

    private function isSelectedOne($selectedItem, $idFieldSelected, $item, $idFieldItem = null) {
        if($selectedItem === null || $selectedItem == '')
            return false;
        return $selectedItem->getClass()->getMethod('get' . ucfirst($idFieldSelected))->invoke($selectedItem)
        === ($idFieldItem === null ? $item : $item->getClass()->getMethod('get' . ucfirst($idFieldItem))->invoke($item));
    }

    private function renderOption(\blaze\web\application\BlazeContext $context, $id, $label, $selected, $disabled) {
        $writer = $context->getResponse()->getWriter();
        $writer->write('<option');

        $writer->write(' value="'.$id.'"');

        if($selected)
            $writer->write(' selected="selected"');
        if($disabled)
            $writer->write(' disabled="disabled"');
        $writer->write('>');
        $writer->write($label);
        $writer->write('</option>');
    }

    public function renderEnd(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        
    }

    public function renderChildren(\blaze\web\application\BlazeContext $context, \blaze\web\component\UIComponent $component) {
        
    }

}

?>
