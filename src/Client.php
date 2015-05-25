<?php
/**
 * CaseStatus\Client
 *
 * Expose the basic api for case status.
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

use CaseStatus\ResponseParser;

class Client
{
    /**
     *  Store a reference to case status id and expose query methods
     *
     *  @param string $id uccis case status id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Post to the ucis case status endpoint and return a parsed response
     * @return new ResponseParser
     */
    public function get()
    {
        $url = "https://egov.uscis.gov/casestatus/mycasestatus.do";
        $request = curl_init();

        $fields = array(
          'changeLocale'=> '',
          'appReceiptNum'=> $this->id,
          'initCaseSearch'=> 'CHECK STATUS'
        );

        // a reduce might be better here?
        $postvars = '';
        foreach ($fields as $key => $value) {
            $postvars .= $key . "=" . $value . "&";
        }

        curl_setopt($request, CURLOPT_URL, $url);
        curl_setopt($request, CURLOPT_POST, 1);
        curl_setopt($request, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($request, CURLOPT_TIMEOUT, 15);

        $response_html = curl_exec($request);
        curl_close($request);

        return new ResponseParser($response_html);
    }
}
