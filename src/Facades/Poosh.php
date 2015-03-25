<?php namespace Joearcher\Pooshlaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Poosh extends Facade{
	protected static function getFacadeAccessor() { return 'pooshlaravel'; }
}