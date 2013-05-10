<?php
namespace Suin\RSSWriter\Media;

use Suin\RSSWriter\XmlElementInterface;
use DOMNode;

/**
 * This is the hash of the binary media file. It can appear multiple times as long as each instance is a different algo.
 * It has one optional attribute.
 * @author avasilenko
 */
class MediaHash implements XmlElementInterface
{
    /** @var string */
    private $algo;
    /** @var string */
    private $value;

    /**
     * The algorithm used to create the hash. Possible values are "md5" and "sha-1". Default value is "md5". It is an optional attribute.
     * @param string $algo
     * @return $this
     */
    public function algo($algo)
    {
       $this->algo = $algo;
       return $this;
    }

    /**
     * Hash value
     * @param string $value
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;
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
        $doc->createAttributeNS(MediaContent::MEDIA_NAMESPACE, 'media:content');
        $element->appendChild($hash = $doc->createElementNS(MediaContent::MEDIA_NAMESPACE, 'media:hash', $this->value));
        if ($this->algo) {
            $hash->setAttribute('algo', $this->algo);
        }
    }
}
