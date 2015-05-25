<?php
/**
 * CaseStatus\ResponseParser
 *
 * Parses the case status response from USCIS
 *
 * PHP version 5
 *
 * @category Utility
 * @package  CaseStatus
 * @author   Nick Tomlin <nick.tomlin+github@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version  GIT: 1.0.0
 * @link     https://github.com/nicktomlin/php-case-status
 */

namespace CaseStatus;

class ResponseParser
{
    private $responseText;
    private $responseHtml;
    private $is_successful = false;

    public function __construct($html)
    {
        $this->parse($html);
    }

    public function text()
    {
        return $this->responseText;
    }

    public function html()
    {
        return $this->responseHtml;
    }

   /**
    * Return the "innerHTML" of a DOMElement
    *
    * @param DOMElement $element
    * @return HTML string
    */
    private function getHtml($element)
    {
        $dom = new \domDocument;
        $dom->appendChild($dom->importNode($element, true));
        return $dom->saveHTML();
    }

    public function isSuccessful()
    {
        return $this->is_successful;
    }

   /**
    * Parse a case status response. It is extremely brittle, due to the fact
    * that it depends on classes existing in the incoming html.
    *
    * This checks for two cases:
    * 1. A valid case status has been returned
    * 2. An invalid case message was returned
    *
    * And sets responseHtml and responseText of the response instance
    * accordingly. If no match is found a blank string is used.
    *
    * @param htmlstring $html Response body from USCIS
    * @return null
    */
    private function parse($html)
    {
        $status_text = '';
        $status_html = '';
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
            $status_html = $this->getHtml($status_element);
            $this->is_successful = true;
        } else {
            $this->is_successful = false;
            $error_element = $dom->getElementById('formErrorMessages');
            if ($error_element) {
                $status_text = $error_element->textContent;
                $status_html = $this->getHtml($error_element);
            }
        }

        $this->responseHtml = $status_html;
        $this->responseText = $status_text;
    }
}
