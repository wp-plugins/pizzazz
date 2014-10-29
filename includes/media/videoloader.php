<?php

namespace pizzazz\includes\media;

use pizzazz\includes\exceptions\VideoUrlException;

class VideoLoader
{
    static protected $portfolioItem;
    static protected $url;
    static protected $videoUrl;
    static protected $videoType;

    static public function getEmbedCode($portfolioItem)
    {
        try{
            self::$portfolioItem = $portfolioItem;
            return self::_tryLoadEmbedCode();
        }catch (VideoUrlException $e){
            $e->setPortfolioItemId(self::$portfolioItem->ID);
            return $e;
        }
    }

    static protected function _tryLoadEmbedCode()
    {
        self::_loadVideoUrl();
        self::$url = self::$videoUrl->getRealUrl(self::$portfolioItem->videoUrl);
        self::_loadVideoType();
        return self::_loadEmbedCode();
    }

    static protected function _loadVideoUrl()
    {
        self::$videoUrl = new VideoUrl();
    }

    static protected function _loadVideoType()
    {
        self::$videoType = self::$videoUrl->getType(self::$url);
    }

    static protected function _loadEmbedCode()
    {
        $videoTypeClass = sprintf('%s\%sVideo', __NAMESPACE__, self::$videoType);
        $video = new $videoTypeClass();
        $video->setPortfolioItemId(self::$portfolioItem->ID);
        return $video->getEmbedCode(self::$url);
    }
}