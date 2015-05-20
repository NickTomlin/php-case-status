<?php

namespace CaseStatus;

use CaseStatus\ResponseParser;

class Client
{
    public function __construct ($id)
    {
        $this->id = $id;
    }

    public function get ()
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
        foreach($fields as $key=>$value) {
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
