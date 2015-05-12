<?php
namespace CSSID;

class ResponseParser
{
    private $responseText;

    public function __construct($responseText)
    {
        $this->responseText = $responseText;
    }

    public function getText ()
    {
        // TODO: use a regex or PHPDom to parse this instead of strpos
        $content_area_position = strpos($this->responseText,'<div class="rows text-center">');

        if ($content_area_position) {
          $start = substr($this->responseText, $content_area_position);
        } else {
          $start = substr($this->responseText, strpos($this->responseText, '<div id="formErrorMessages">'));
        }

        $end = strpos($start, '</div>');
        $statusText = substr($start, 0, $end);

        return $statusText;
    }
}
