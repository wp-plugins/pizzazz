<?php

namespace pizzazz\includes\media;

class VimeoVideo extends Video
{
    protected function _loadVideoId()
    {
        $urlSplit = explode('vimeo.com/', $this->url);
        $extraParamSplit = explode('&', $urlSplit[1]);
        $this->videoId = $extraParamSplit[0];
    }

    protected function _buildEmbedCode()
    {
        $this->embedCode = sprintf('<iframe
            width="640"
            height="480"
            src="http://player.vimeo.com/video/%s?autoplay=0"
            id="pz-video-%s"
            webkitallowfullscreen="webkitallowfullscreen"
            mozallowfullscreen="mozallowfullscreen"
            allowfullscreen="allowfullscreen"
            frameborder="0"></iframe>', $this->videoId, $this->portfolioItemId);
    }
}