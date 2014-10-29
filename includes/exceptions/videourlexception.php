<?php

namespace pizzazz\includes\exceptions;

class VideoUrlException extends \Exception
{
    protected $portfolioItemId;

    public function setPortfolioItemId($id)
    {
        $this->portfolioItemId = $id;
    }

    public function __toString()
    {
        return sprintf('
            <div id="pz-video-%s" class="pz-video-url-exception">
                <h4>Video URL Exception:</h4>
                <p>%s</p>
            </div>',
            $this->portfolioItemId, $this->getMessage());
    }
}