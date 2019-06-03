<?php

namespace Suin\RSSWriter;

/**
 * Class ChannelPodcast
 * @package Suin\RSSWriter
 */
class ChannelPodcast
{
    /** @var string */
    protected $subtitle;

    /** @var string */
    protected $author;

    /** @var string */
    protected $summary;

    /** @var string */
    protected $owner;

    protected $preferCdata = false;

    /**
     * Set channel itunes:subtitle
     * @param string $subtitle
     * @return $this
     */
    public function subtitle($subtitle)
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    /**
     * Set channel itunes:author
     * @param string $author
     * @return $this
     */
    public function author($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Set channel itunes:summary
     * @param string $summary
     * @return $this
     */
    public function summary($summary)
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * Set channel itunes:owner
     * @param string $owner
     * @return $this
     */
    public function owner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Set channel itunes:image
     * @param string $image
     * @return $this
     */
    public function image($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Set channel itunes:category
     * @param array $category
     * @return $this
     */
    public function category($category)
    {
        $this->category = $category;
        return $this;
    }

    public function preferCdata($preferCdata)
    {
        $this->preferCdata = (bool)$preferCdata;
        return $this;
    }

    public function asXML()
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><channel></channel>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        if ($this->author !== null) {
            $xml->addChild('xmlns:itunes:author', $this->author);
        }

        if ($this->subtitle !== null) {
            $xml->addChild('xmlns:itunes:subtitle', $this->subtitle);
        }

        if ($this->summary) {
            if ($this->preferCdata) {
                $xml->addCdataChild('xmlns:itunes:summary', $this->summary);
            } else {
                $xml->addChild('xmlns:itunes:summary', $this->summary);
            }
        }

        if ($this->owner !== null && is_array($this->owner)) {
            $owner = $xml->addChild('xmlns:itunes:owner');
            if($this->owner['name'])
            {
                $owner->addChild('xmlns:itunes:name', $this->owner['name']);
            }
            if($this->owner['email'])
            {
                $owner->addChild('xmlns:itunes:email', $this->owner['email']);
            }
        }

        if ($this->image !== null) {
            $image = $xml->addChild('xmlns:itunes:image');
            $image->addAttribute('href', $this->image);
        }

        // Ituens Category
        if (is_array($this->category) && $this->category !== null) {
            $fromDom = new \DOMDocument();
            $obj = $fromDom->createElement('channel');
            $fromDom->appendChild($obj);
            $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->category), \RecursiveIteratorIterator::SELF_FIRST);
            $prevLvl = 0;

            foreach ($iterator as $k => $val) {
                $depth = $iterator->getDepth();
                if ($depth < $prevLvl) {
                    for ($i = 0; $i < $prevLvl - $depth; $i++) {
                        $obj = $obj->parentNode;
                    }
                }
                if (!is_array($val)) {
                    $son = $fromDom->createElement('itunes:category');
                    $domAttribute = $fromDom->createAttribute('text');
                    $domAttribute->value = $k;
                    $son->appendChild($domAttribute);
                    $obj->appendChild($son);
                } else {
                    $son = $fromDom->createElement('itunes:category');
                    $domAttribute = $fromDom->createAttribute('text');
                    $domAttribute->value = $k;
                    $son->appendChild($domAttribute);
                    $obj->appendChild($son);
                    $obj = $son;
                }
                $prevLvl = $depth;
            }

            $itunesCategories = $fromDom->getElementsByTagName('itunes:category');
            foreach ($itunesCategories as $key => $itunesCategory) {
                $toDom = dom_import_simplexml($xml);
                $toDom->appendChild($toDom->ownerDocument->importNode($itunesCategory, true));
            }
        }

        return $xml;
    }
}
