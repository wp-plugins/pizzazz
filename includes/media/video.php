<?php

namespace pizzazz\includes\media;

abstract class Video
{
    protected $url;
    protected $portfolioItemId;
    protected $videoId;
    protected $embedCode;

    public function setPortfolioItemId($id)
    {
        $this->portfolioItemId = $id;
    }

    public function getEmbedCode($url)
    {
        $this->url = $url;
        $this->_loadVideoId();
        $this->_buildEmbedCode();
        return $this->embedCode;
    }

    abstract protected function _loadVideoId();

    abstract protected function _buildEmbedCode();
}