<?php

namespace CaseStatus;

class ResponseParser
{
    private $responseText;

    public function __construct($html)
    {
        $this->parse($html);
    }

    public function text () {
        return $this->responseText;
    }

    private function parse ($html)
    {
        $status_text = '';
        $status_classes = 'rows text-center';
        $libxml_previous_state = libxml_use_internal_errors(true);

        libxml_use_internal_errors(true);
        $dom = new \domDocument;
        $dom->loadHTML($html);
        $dom->preserveWhiteSpace = false;
        libxml_clear_errors();
        libxml_use_internal_errors($libxml_previous_state);

        $xpath = new \DomXPath($dom);
        $nodes = $xpath->query("//*[contains(@class, 'rows text-center')]");

        if ($nodes->length) {
            $status_element = $nodes->item(0);
            $status_text = $status_element->textContent;
        } else {
            $error_element = $dom->getElementById('formErrorMessages');
            if ($error_element) {
                $status_text = $error_element->textContent;
            }
        }

        $this->responseText = $status_text;
    }
}
