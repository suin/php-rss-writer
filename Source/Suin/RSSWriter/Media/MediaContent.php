<?php

namespace Suin\RSSWriter\Media;

use Suin\RSSWriter\XmlElementInterface;
use DOMNode;
use Suin\RSSWriter\SimpleXMLElement;
use Suin\RSSWriter\ItemInterface;

/**
 * Media content element. As seen on {@link http://www.rssboard.org/media-rss}
 * @author avasilenko
 */
class MediaContent implements XmlElementInterface
{
    const MEDIA_NAMESPACE = 'http://search.yahoo.com/mrss/';
    /** @var XmlElementInterface[] */
    protected $childs = array();
    /**
     * @var string
     */
    protected $url;
    /**
     * @var int
     */
    protected $fileSize;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $medium;
    /**
     * @var bool
     */
    protected $isDefault;
    /**
     * @var string
     */
    protected $expression;
    /**
     * @var int
     */
    protected $kilobits;
    /**
     * @var int
     */
    protected $framerate;
    /**
     * @var float
     */
    protected $samplingrate;
    /**
     * @var int
     */
    protected $channels;
    /**
     * @var int
     */
    protected $duration;
    /**
     * @var int
     */
    protected $height;
    /**
     * @var int
     */
    protected $width;
    /**
     * @example en
     * @var string
     */
    protected $lang;

    /**
     * Should specify the direct URL to the media object. If not included, a player element must be specified.
     * @param $url
     * @return $this
     */
    public function url($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Number of audio channels in the media object. It is an optional attribute.
     * @param int $channels
     * @return $this
     */
    public function channels($channels)
    {
        $this->channels = $channels;
        return $this;
    }

    /**
     * Number of seconds the media object plays. It is an optional attribute.
     * @param int $duration
     * @return $this
     */
    public function duration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * Determines if the object is a sample or the full version of the object, or even if it is a continuous
     * stream (sample | full | nonstop). Default value is "full". It is an optional attribute.
     * @param string $expression
     * @return $this
     */
    public function expression($expression)
    {
        $this->expression = $expression;
        return $this;
    }

    /**
     * Number of bytes of the media object. It is an optional attribute.
     * @param int $fileSize
     * @return $this
     */
    public function fileSize($fileSize)
    {
        $this->fileSize = $fileSize;
        return $this;
    }

    /**
     * Number of frames per second for the media object. It is an optional attribute.
     * @param int $framerate
     * @return $this
     */
    public function framerate($framerate)
    {
        $this->framerate = $framerate;
        return $this;
    }

    /**
     * Height of the media object. It is an optional attribute.
     * @param int $height
     * @return $this
     */
    public function height($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Determines if this is the default object that should be used for the <media:group>. There should only be one
     * default object per <media:group>. It is an optional attribute.
     * @param boolean $isDefault
     * @return $this
     */
    public function isDefault($isDefault)
    {
        $this->isDefault = $isDefault;
        return $this;
    }

    /**
     * Kilobits per second rate of media. It is an optional attribute.
     * @param int $kilobits
     * @return $this
     */
    public function kilobits($kilobits)
    {
        $this->kilobits = $kilobits;
        return $this;
    }

    /**
     * Primary language encapsulated in the media object. Language codes possible are detailed in RFC 3066.
     * This attribute is used similar to the xml:lang attribute detailed in the XML 1.0 Specification (Third Edition).
     * It is an optional attribute.
     * @param string $lang
     * @return $this
     */
    public function lang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * Type of object (image | audio | video | document | executable).
     * While this attribute can at times seem redundant if type is supplied, it is included because it simplifies
     * decision making on the reader side, as well as flushes out any ambiguities between MIME type and object type.
     * It is an optional attribute.
     * @param string $medium
     * @return $this
     */
    public function medium($medium)
    {
        $this->medium = $medium;
        return $this;
    }

    /**
     * Number of samples per second taken to create the media object. It is expressed in thousands of samples per second (kHz). It is an optional attribute.
     * @example 44.1
     * @param float $samplingrate
     * @return $this
     */
    public function samplingrate($samplingrate)
    {
        $this->samplingrate = $samplingrate;
        return $this;
    }

    /**
     * Standard MIME type of the object. It is an optional attribute.
     * @param string $type
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Width of the media object. It is an optional attribute.
     * @param int $width
     * @return $this
     */
    public function width($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Add child
     * @param \Suin\RSSWriter\XmlElementInterface $child
     * @return $this
     */
    public function addChild(XmlElementInterface $child)
    {
        $this->childs[] = $child;
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
        $doc->createAttributeNS(self::MEDIA_NAMESPACE, 'media:content');
        $element->appendChild($content = $doc->createElementNS(self::MEDIA_NAMESPACE, 'media:content'));
        $properties = get_object_vars($this);
        unset($properties['childs']);
        foreach($properties as $name => $value) {
            if ($value) {
                $content->setAttribute($name, htmlspecialchars($value));
            }
        }

        if (!empty($this->childs)) {
            foreach ($this->childs as $child) {
                $child->buildXML($content);
            }
        }
    }
}
