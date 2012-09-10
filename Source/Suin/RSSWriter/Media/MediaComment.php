<?php
namespace Suin\RSSWriter\Media;

use Suin\RSSWriter\XmlElementInterface;
use DOMNode;

/**
 * @author avasilenko
 */
class MediaComment implements XmlElementInterface
{
    private $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Return XML object
     * @param \DOMNode $element source element to append to
     */
    public function buildXML(DOMNode $element)
    {
        $element->appendChild(
            $element->ownerDocument->createElementNS(MediaContent::MEDIA_NAMESPACE, 'media:comment', htmlspecialchars($this->comment))
        );
    }
}
