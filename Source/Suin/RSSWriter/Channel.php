<?php

namespace Suin\RSSWriter;

use Suin\RSSWriter\XmlElementInterface;
use DOMNode;

class Channel implements \Suin\RSSWriter\ChannelInterface
{
	/** @var string */
	protected $title;
	/** @var string */
	protected $url;
	/** @var string */
	protected $description;
	/** @var string */
	protected $language;
	/** @var string */
	protected $copyright;
	/** @var int */
	protected $pubDate;
	/** @var int */
	protected $lastBuildDate;
	/** @var int */
	protected $ttl;
	/** @var \Suin\RSSWriter\XmlElemenTInterface[] */
	protected $items = array();

	/**
	 * Set channel title
	 * @param string $title
	 * @return $this
	 */
	public function title($title)
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * Set channel URL
	 * @param string $url
	 * @return $this
	 */
	public function url($url)
	{
		$this->url = $url;
		return $this;
	}

	/**
	 * Set channel description
	 * @param string $description
	 * @return $this
	 */
	public function description($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * Set ISO639 language code
	 *
	 * The language the channel is written in. This allows aggregators to group all
	 * Italian language sites, for example, on a single page. A list of allowable
	 * values for this element, as provided by Netscape, is here. You may also use
	 * values defined by the W3C.
	 *
	 * @param string $language
	 * @return $this
	 */
	public function language($language)
	{
		$this->language = $language;
		return $this;
	}

	/**
	 * Set channel copyright
	 * @param string $copyright
	 * @return $this
	 */
	public function copyright($copyright)
	{
		$this->copyright = $copyright;
		return $this;
	}

	/**
	 * Set channel published date
	 * @param int $pubDate Unix timestamp
	 * @return $this
	 */
	public function pubDate($pubDate)
	{
		$this->pubDate = $pubDate;
		return $this;
	}

	/**
	 * Set channel last build date
	 * @param int $lastBuildDate Unix timestamp
	 * @return $this
	 */
	public function lastBuildDate($lastBuildDate)
	{
		$this->lastBuildDate = $lastBuildDate;
		return $this;
	}

	/**
	 * Set channel ttl (minutes)
	 * @param int $ttl
	 * @return $this
	 */
	public function ttl($ttl)
	{
		$this->ttl = $ttl;
		return $this;
	}

    /**
     * Add item object
     * @param \Suin\RSSWriter\XmlElementInterface $item
     * @return $this
     */
	public function addChild(XmlElementInterface $item)
	{
		$this->items[] = $item;
		return $this;
	}

	/**
	 * Append to feed
	 * @param \Suin\RSSWriter\FeedInterface $feed
	 * @return $this
	 */
	public function appendTo(FeedInterface $feed)
	{
		$feed->addChannel($this);
		return $this;
	}

    /**
     * Return XML object
     * @param \DOMNode $element
     */
	public function buildXML(DOMNode $element)
	{
        $doc = $element->ownerDocument;
        $channel = $doc->createElement('channel');
        $element->appendChild($channel);
        $channel->appendChild($doc->createElement('title', htmlentities($this->title)));
        $channel->appendChild($doc->createElement('link', htmlentities($this->url)));
        $channel->appendChild($doc->createElement('description', htmlentities($this->description)));

		if ( $this->language !== null )
		{
			$channel->appendChild($doc->createElement('language', htmlentities($this->language)));
		}

		if ( $this->copyright !== null )
		{
			$channel->appendChild($doc->createElement('copyright', $this->copyright));
		}

		if ( $this->pubDate !== null )
		{
			$channel->appendChild($doc->createElement('pubDate', date(DATE_RSS, $this->pubDate)));
		}

		if ( $this->lastBuildDate !== null )
		{
			$channel->appendChild($doc->createElement('lastBuildDate', date(DATE_RSS, $this->lastBuildDate)));
		}

		if ( $this->ttl !== null )
		{
			$channel->appendChild($doc->createElement('ttl', $this->ttl));
		}
        foreach($this->items as $item) {
            $item->buildXML($channel);
        }
	}
}
