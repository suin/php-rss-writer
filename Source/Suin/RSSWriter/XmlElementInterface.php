<?php

namespace Suin\RSSWriter;
use DOMNode;

/**
 * @author avasilenko
 */
interface XmlElementInterface
{
    /**
     * Return XML object
     * @param \DOMNode $element source element to append to
     */
    public function buildXML(DOMNode $element);
}
