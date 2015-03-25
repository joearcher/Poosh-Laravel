<?php namespace Joearcher\Pooshlaravel;

use \GuzzleHttp\Client as Guzz;
use \GuzzleHttp\Exception\RequestException;
use Exception;

/**
* @author Joe Archer <joe.archer@gmail.com>
* @copyright Copyright (c) 2015
* @license    http://www.opensource.org/licenses/mit-license.html MIT License
*/


class Pooshlaravel{

	/**
	* Server Secret key from config
	*@var string
	**/

	protected $secret;
	
	/**
	* Base Poosh server url
	*@var string
	**/

	protected $baseUrl;

	/**
	*Instance of Guzzle client
	*@var \GuzzleHttp\Client
	**/

	protected $client;

	/**
	 *Poosh server port number
	 *@var  int 
	**/

	protected $port;

	/**
	*set everything up
	*@return void
	**/
	public function __construct()
	{
		$this->secret = config('poosh.secret');
		$this->port = config('poosh.server_port');
		$this->baseUrl = config('poosh.server_url');

		if($this->secret == ""){
			$error = "You must set a secret in your config";
			throw new Exception($error);
		}

		if($this->baseUrl== ""){
			$error = "You must set a server base URL in your config";
			throw new Exception($error);
		}

		$this->client = new Guzz(['base_url' => $this->baseUrl]);
	}

	/**
	*Send payload to all clients listening for event
	*@param String $event [name of the event]
	*@param Array $payload [payload to be sent]
	**/

	public function send($event,$payload)
	{
		//check event is a string
		if(!is_string($event)){
			$error = "Event must be a string";
			throw new Exception($error);
		}
		//check the payload is an array
		if(!is_array($payload)){
			$error = "Payload must be an array";
			throw new Exception($error);
		}
		//encode the payload for transmission
		$body = json_encode(['event' => $event,'payload' => $payload]);

		//set up the request
		$request = $this->client->createRequest('POST','/send',['body' => $body]);
		//set the Poosh server port
		$request->setPort($this->port);
		//set the headers
		$request->setHeader('content-type','application/json');
		$request->setHeader('authorization',sha1($this->secret.json_encode($payload)));
	
		try
		{
			$this->client->send($request);
		}
		catch(RequestException $e)
		{
			echo $e->getRequest() . "\n";
		    if ($e->hasResponse()) {
		        echo $e->getResponse() . "\n";
		    }
		}
	}
	
}