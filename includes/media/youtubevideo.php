<?php

namespace pizzazz\includes\media;

class YoutubeVideo extends Video
{
    protected function _loadVideoId()
    {
        $urlSplit = explode('v=', $this->url);
        $extraParamSplit = explode('&', $urlSplit[1]);
        $this->videoId = $extraParamSplit[0];
    }

    protected function _buildEmbedCode()
    {
        $this->embedCode = sprintf('<iframe
            width="640"
            height="480"
            src="http://www.youtube.com/embed/%s?autoplay=0"
            id="pz-video-%s"
            frameborder="0"></iframe>', $this->videoId, $this->portfolioItemId);
    }
}