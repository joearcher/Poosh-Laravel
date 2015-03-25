<?php namespace Joearcher\Pooshlaravel;

/**
* @author Joe Archer <joe.archer@gmail.com>
* @copyright Copyright (c) 2015
* @license    http://www.opensource.org/licenses/mit-license.html MIT License
*/

use Illuminate\Support\ServiceProvider;

class PooshlaravelServiceProvider extends ServiceProvider {

	public function boot(){
		$this->publishes([
		    __DIR__.'/config/config.php' => config_path('poosh.php'),
		]);
	}

	 public function register()
    {
        $this->app['pooshlaravel'] = $this->app->share(function ($app)
        {
            
            $poosh = new Pooshlaravel();
            
            return $poosh;
        });
    }
}