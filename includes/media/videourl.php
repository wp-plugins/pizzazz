<?php

namespace pizzazz\includes\media;

use pizzazz\includes\exceptions\VideoUrlException;

class VideoUrl
{
    protected $url;

    public function getRealUrl($url)
    {
        if(!$headers = get_headers($url, 1)){
            $this->_throwException(sprintf(__('Failed to open stream for URL - %s', 'pizzazz'), $url));
        }
        return (isset($headers['Location'])) ? $headers['Location'] : $url;
    }

    public function getType($url)
    {
        $this->url = $url;
        return $this->_loadType();
    }

    protected function _loadType()
    {
        if($this->_isYoutube()) return 'Youtube';
        if($this->_isVimeo()) return 'Vimeo';
        $this->_throwException(sprintf(__('Unrecognized Video URL - %s', 'pizzazz'), $this->url));
    }

    protected function _isYoutube()
    {
        return preg_match('/\byoutube.com\b/i', $this->url);
    }

    protected function _isVimeo()
    {
        return preg_match('/\bvimeo.com\b/i', $this->url);
    }

    protected function _throwException($message)
    {
        throw new VideoUrlException($message);
    }
}