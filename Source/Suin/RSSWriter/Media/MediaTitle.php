<?php

namespace Suin\RSSWriter\Media;

use Suin\RSSWriter\XmlElementInterface;
use DOMNode;

/**
 * @author avasilenko
 */
class MediaTitle implements XmlElementInterface
{
    /** @var string */
    private $title;
    /** @var string */
    private $type;

    /**
     * @param string $title
     * @param string|null $type specifies the type of text embedded. Possible values are either "plain" or "html". Default value is "plain".
     *                  All HTML must be entity-encoded. It is an optional attribute.
     */
    public function __construct($title, $type = null)
    {
        $this->title = $title;
        $this->type = $type;
    }

    /**
     * Return XML object
     * @param \DOMNode $element source element to append to
     */
    public function buildXML(DOMNode $element)
    {
        $doc = $element->ownerDocument;
        $element->appendChild($title = $doc->createElementNS(MediaContent::MEDIA_NAMESPACE, 'media:title', $this->title));
        if ($this->type) {
            $title->setAttribute('type', $this->type);
        }
    }
}
