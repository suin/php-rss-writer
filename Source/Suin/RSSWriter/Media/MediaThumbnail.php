<?php
namespace Suin\RSSWriter\Media;
use Suin\RSSWriter\XmlElementInterface;
use DOMNode;

/**
 * Allows particular images to be used as representative images for the media object. If multiple thumbnails are included,
 * and time coding is not at play, it is assumed that the images are in order of importance. It has one required attribute
 * and three optional attributes.
 * @author avasilenko
 */
class MediaThumbnail implements XmlElementInterface
{
    /** @var string */
    private $url;
    /** @var int */
    private $width;
    /** @var int */
    private $height;
    private $time;

    /**
     * The height of the thumbnail. It is an optional attribute.
     * @param int $height
     * @return $this
     */
    public function height($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * The url of the thumbnail. It is a required attribute.
     * @param string $url
     * @return $this
     */
    public function url($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * The width of the thumbnail. It is an optional attribute.
     * @param int $width
     * @return $this
     */
    public function width($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * The time offset in relation to the media object. Typically this is used when creating multiple keyframes within
     * a single video. The format for this attribute should be in the DSM-CC's Normal Play Time (NTP) as used
     * in RTSP {@link http://www.ietf.org/rfc/rfc2326.txt}. It is an optional attribute.
     * @example 12:05:01.123
     * @param $time
     * @return $this
     */
    public function time($time)
    {
        $this->time = $time;
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
        $element->appendChild($thumbnail = $doc->createElementNS(MediaContent::MEDIA_NAMESPACE, 'media:thumbnail'));
        $thumbnail->setAttribute('url', $this->url);
        if ($this->width) {
            $thumbnail->setAttribute('width', $this->width);
        }
        if ($this->height) {
            $thumbnail->setAttribute('height', $this->height);
        }
        if ($this->time) {
            $thumbnail->setAttribute('time', $this->time);
        }
    }
}
