<?php
namespace Suin\RSSWriter;

use DOMNode;

/**
 * The atom:link element defines a relationship between a web resource (such as a page) and an RSS channel or item (OPTIONAL).
 * The most common use is to identify an HTML representation of an entry in an RSS or Atom feed.
 * @author avasilenko
 */
class AtomLink implements XmlElementInterface
{
    const ATOM_NAMESPACE = 'http://www.w3.org/2005/Atom';

    /** @var string */
    private $href;
    /** @var string */
    private $hreflang;
    /** @var string */
    private $rel;
    /** @var string */
    private $type;

    public function __construct($href)
    {
        $this->href = $href;
    }

    /**
     * Identifies the language used by the related resource using an HTML language code
     * @param string $hreflang
     * @return $this
     */
    public function hreflang($hreflang)
    {
        $this->hreflang = $hreflang;
        return $this;
    }

    /**
     * Contains a keyword that identifies the nature of the relationship between the linked resouce and the element. Five relationships are possible:
     * <ul>
     *  <li>The value "alternate" describes an alternate representation, such as a web page containing the same content as a feed entry</li>
     *  <li>The value "enclosure" describes a a media object such as an audio or video file</li>
     *  <li>The value "related" describes a related resource</li>
     *  <li>The value "self" describes the feed itself</li>
     *  <li>The value "via" describes the original source that authored the entry, when it's not the feed publisher</li>
     * </ul>
     * @param string $rel
     * @return $this
     */
    public function rel($rel)
    {
        $this->rel = $rel;
        return $this;
    }

    /**
     * Identifies the resource's MIME media type
     * @param string $type
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Return XML object
     * @param \DOMNode $element source element to append to
     */
    public function buildXML(DOMNode $element)
    {
        $doc = $element->ownerDocument;
        //ensure we have correct ns available
        $doc->createAttributeNS(self::ATOM_NAMESPACE, 'atom:link');
        $element->appendChild($link = $doc->createElementNS(self::ATOM_NAMESPACE, 'atom:link'));
        $link->setAttribute('href', $this->href);
        if ($this->hreflang) {
            $link->setAttribute('hreflang', $this->hreflang);
        }
        if ($this->rel) {
            $link->setAttribute('rel', $this->rel);
        }
        if ($this->type) {
            $link->setAttribute('type', $this->type);
        }
    }
}
