<?php

namespace Ropat\CrudGenerator;

use Illuminate\Support\ServiceProvider;

class CrudGeneratorServiceProvider extends ServiceProvider {
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->publishes([
			__DIR__ . '/../config/crudgenerator.php' => config_path('crudgenerator.php'),
		]);

		$this->publishes([
			__DIR__ . '/stubs/' => base_path('resources/crud-generator/'),
		]);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		$this->commands(
			'Ropat\CrudGenerator\Commands\CrudCommand',
			'Ropat\CrudGenerator\Commands\CrudControllerCommand',
			'Ropat\CrudGenerator\Commands\CrudModelCommand',
			'Ropat\CrudGenerator\Commands\CrudMigrationCommand',
			'Ropat\CrudGenerator\Commands\CrudViewCommand'
		);
	}

}
