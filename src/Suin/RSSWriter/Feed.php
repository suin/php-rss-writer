<?php

namespace Suin\RSSWriter;

use DOMDocument;

/**
 * Class Feed
 * @package Suin\RSSWriter
 */
class Feed implements FeedInterface
{
    /** @var string */
    protected $type = 'rss';

    /** @var ChannelInterface[] */
    protected $channels = [];

    /**
     * Add channel
     * @param ChannelInterface $channel
     * @return $this
     */
    public function addChannel(ChannelInterface $channel)
    {
        $this->channels[] = $channel;
        return $this;
    }

    public function asPodcast()
    {
        $this->type = 'podcast';
        return $this;
    }

    /**
     * Render XML
     * @return string
     */
    public function render()
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><rss version="2.0" />', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        foreach ($this->channels as $channel) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($channel->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        // Note that this adds the namespace as an attribute, rather than a declaration
        if ($this->type == 'rss') {
            $xml->addAttribute('xmlns:xmlns:content', 'http://purl.org/rss/1.0/modules/content/'); 
            $xml->addAttribute('xmlns:xmlns:atom','http://www.w3.org/2005/Atom'); 
        } else if ($this->type == 'podcast') {
            $xml->addAttribute('xmlns:xmlns:itunes', 'http://www.itunes.com/dtds/podcast-1.0.dtd'); 
            $xml->addAttribute('xmlns:xmlns:googleplay', 'http://www.google.com/schemas/play-podcasts/1.0'); 
        }

        //reset
        $this->type = null;

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->appendChild($dom->importNode(dom_import_simplexml($xml), true));
        $dom->formatOutput = true;
        return $dom->saveXML();
    }

    /**
     * Render XML
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
