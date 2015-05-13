<?php

use CaseStatus\Client;

class CaseStatusIntegrationTest extends PHPUnit_Framework_TestCase
{
    public function testCorrectlyRequestsId()
    {
        $cssid = new Client('msc1490880727');
        $response = $cssid->get();

        $this->assertContains('Card Was Delivered To Me By The Post Office', $response->getText());
    }
}
