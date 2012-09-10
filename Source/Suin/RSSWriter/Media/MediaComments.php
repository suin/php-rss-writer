<?php

namespace Suin\RSSWriter\Media;

use Suin\RSSWriter\XmlElementInterface;
use \DOMNode;

/**
 *
 * @author avasilenko
 */
class MediaComments implements XmlElementInterface
{
    /** @var MediaComment[] */
    private $comments;

    /**
     * @param MediaComment[] $comments
     */
    public function __construct(array $comments = array())
    {
        $this->comments = $comments;
    }

    /**
     * @param MediaComment $comment
     * @return $this
     */
    public function comment(MediaComment $comment)
    {
        $this->comments[] = $comment;
        return $this;
    }

    /**
     * Return XML object
     * @param \DOMNode $element source element to append to
     */
    public function buildXML(DOMNode $element)
    {
        $element->appendChild(
            $comments = $element->ownerDocument->createElementNS(MediaContent::MEDIA_NAMESPACE, 'media:comments')
        );

        foreach ($this->comments as $comment) {
            $comment->buildXML($comments);
        }
    }
}
