<?php

use CaseStatus\ResponseParser;

class ResponseParserTest extends PHPUnit_Framework_TestCase
{
    private function readFixture ($file_name)
    {
        $file_path = __DIR__ . "/fixtures/$file_name";
        return file_get_contents($file_path);
    }

    public function __construct ()
    {
        $this->goodResponse = $this->readFixture('valid-response.html');
        $this->invalidResponse = $this->readFixture('invalid-response.html');
    }

    public function testContainsResponseText()
    {
        $response = new ResponseParser($this->goodResponse);
        $this->assertContains('Card Was Delivered To Me By The Post Office', $response->text());
    }

    public function testInvalidResponse()
    {
        $response = new ResponseParser($this->invalidResponse);
        $this->assertContains(
            "The application receipt number entered is invalid. Please check your receipt number and try again.",
            $response->text()
        );

    }

    public function testValidResponseHTML()
    {
        $response = new ResponseParser($this->goodResponse);
        $this->assertRegExp('#<h1>Card Was Delivered To Me By The Post Office</h1>#', $response->html());
    }

    public function testInvalidResponseHTML()
    {
        $response = new ResponseParser($this->invalidResponse);
        $this->assertRegExp('#<li>The application receipt number entered is invalid. Please check your receipt number and try again.</li>#', $response->html());
    }

    public function testIsSuccessfulWithValidResponse()
    {
        $response = new ResponseParser($this->goodResponse);
        $this->assertTrue($response->isSuccessful());
    }

    public function testIsSuccessfulWithInvalidResponse()
    {
        $response = new ResponseParser($this->invalidResponse);
        $this->assertFalse($response->isSuccessful());
    }
}
