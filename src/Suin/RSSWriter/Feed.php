<?php

namespace Suin\RSSWriter;

use DOMDocument;

/**
 * Class Feed
 * @package Suin\RSSWriter
 */
class Feed implements FeedInterface
{
    /** @var ChannelInterface[] */
    protected $channels = [];

    protected $feedStyles = [];

    /**
     * Add Style sheet
     * @param string  $style_url
     * @param string  $media  (defaults to 'screen')
     * @return $this
     */
    public function addStyle($style_url, $media = 'screen'){
      if( !empty($style_url) ){
	$this->feedStyles[] = [ $style_url, $media ];
      }

      return $this;
    }

      
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

    /**
     * Render XML
     * @return string
     */
    public function render()
    {

      $xml = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\" ?><rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\" xmlns:atom=\"http://www.w3.org/2005/Atom\" />",
				  LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);


      foreach ($this->channels as $channel) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($channel->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        $dom = new DOMDocument('1.0', 'UTF-8');

	if( count($this->feedStyles) > 0 ){
	  foreach( $this->feedStyles as $info ){
	    $url = $info[0];
	    $media = $info[1];
	    $xslt = $dom->createProcessingInstruction('xml-stylesheet', "type=\"text/css\" media=\"{$media}\" href=\"{$url}\" ");
	    $dom->appendChild($xslt);
	  }
	}

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
