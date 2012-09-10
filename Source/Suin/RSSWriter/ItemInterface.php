<?php

namespace Suin\RSSWriter;

use \Suin\RSSWriter\ChannelInterface;
use \Suin\RSSWriter\SimpleXMLElement;

interface ItemInterface extends XmlElementInterface
{
	/**
	 * Set item title
	 * @param string $title
	 * @return $this
	 */
	public function title($title);

	/**
	 * Set item URL
	 * @param string $url
	 * @return $this
	 */
	public function url($url);

	/**
	 * Set item description
	 * @param string $description
	 * @return $this
	 */
	public function description($description);

	/**
	 * Set item category
	 * @param string $name Category name
	 * @param string $domain Category URL
	 * @return $this
	 */
	public function category($name, $domain = null);

	/**
	 * Set GUID
	 * @param string $guid
	 * @param bool $isPermalink
	 * @return $this
	 */
	public function guid($guid, $isPermalink = false);

	/**
	 * Set published date
	 * @param int $pubDate Unix timestamp
	 * @return $this
	 */
	public function pubDate($pubDate);

    /**
     * Add child element
     * @param $child
     * @return mixed
     */
    public function addChild(XmlElementInterface $child);

	/**
	 * Append item to the channel
	 * @param \Suin\RSSWriter\ChannelInterface $channel
	 * @return $this
	 */
	public function appendTo(ChannelInterface $channel);
}
