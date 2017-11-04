<?php

namespace Suin\RSSWriter;

/**
 * Interface FeedInterface
 * @package Suin\RSSWriter
 */
interface FeedInterface
{
    /**
     * Add channel
     * @param ChannelInterface $channel
     * @return $this
     */
    public function addChannel(ChannelInterface $channel);

    /**
     * Add Style sheet
     * @param string  $style_url
     * @param string  $media  (defaults to 'screen')
     * @return $this
     */
    public function addStyle($style_url, $media);

    /**
     * Render XML
     * @return string
     */
    public function render();

    /**
     * Render XML
     * @return string
     */
    public function __toString();
}
