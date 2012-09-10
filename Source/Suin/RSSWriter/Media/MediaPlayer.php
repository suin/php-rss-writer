<?php
namespace Suin\RSSWriter\Media;

use Suin\RSSWriter\XmlElementInterface;
use DOMNode;
use Suin\RSSWriter\SimpleXMLElement;

/**
 * Allows the media object to be accessed through a web browser media player console. This element is required only
 * if a direct media url attribute is not specified in the <media:content> element. It has one required attribute and
 * two optional attributes.
 * @author avasilenko
 */
class MediaPlayer implements XmlElementInterface
{
    /** @var string */
    protected $url;
    /** @var int */
    protected $width;
    /** @var int */
    protected $height;

    /**
     * URL of the player console that plays the media. It is a required attribute.
     * @param string $url
     * @return $this
     */
    public function url($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Height of the browser window that the URL should be opened in. It is an optional attribute.
     * @param int $height
     * @return $this
     */
    public function height($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Width of the browser window that the URL should be opened in. It is an optional attribute.
     * @param int
     * @return $this
     */
    public function width($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Return XML object
     * @param \DOMNode $element
     */
    public function buildXML(DOMNode $element)
    {
        $doc = $element->ownerDocument;
        //ensure we have correct ns available
        $doc->createAttributeNS(MediaContent::MEDIA_NAMESPACE, 'media:content');
        $element->appendChild($player = $doc->createElementNS(MediaContent::MEDIA_NAMESPACE, 'media:player'));
        $attributes = get_object_vars($this);
        foreach($attributes as $name => $value) {
            if ($value) {
                $player->setAttribute($name, $value);
            }
        }
    }
}
