<?php

namespace Suin\RSSWriter;

/**
 * Class SimpleXMLElement
 * @package Suin\RSSWriter
 */
class SimpleXMLElement extends \SimpleXMLElement
{
    public function addChild($name, $value = null, $namespace = null)
    {
        if ($value !== null and is_string($value) === true) {
            $value = str_replace('&', '&amp;', $value);
        }

        return parent::addChild($name, $value, $namespace);
    }

    public function addCdataChild($name, $value = null, $namespace = null)
    {
        $element = $this->addChild($name, null, $namespace);
        $element = dom_import_simplexml($element);
        $elementOwner = $element->ownerDocument;
        $element->appendChild($elementOwner->createCDATASection($value));
    }
}
