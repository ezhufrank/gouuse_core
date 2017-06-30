<?php

namespace GouuseCore\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Database\Events\StatementPrepared;
use Event;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EventServiceProvider extends ServiceProvider {
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
			'App\Events\SomeEvent' => [
					'App\Listeners\EventListener'
			],
			'Illuminate\Database\Events\QueryExecuted' => [
					'GouuseCore\Listeners\QueryListener'
			]
	];
	public function boot() {
		Event::listen ( StatementPrepared::class, function ($event) {
			$event->statement->setFetchMode(\PDO::FETCH_ASSOC);
		});
			if (env('APP_DEBUG') == true) {
				Event::listen ( QueryExecuted::class, function ($event) {
					if (strpos($event->sql, 'explain')===false) {
						$sql = str_replace("?", "'%s'", $event->sql);
						$log = vsprintf($sql, $event->bindings);
						if (strpos($log, 'select')!==false) {
							$sql1 = "explain ".$sql;
							$results = DB::select($sql1, []);
							foreach ($results as $row) {
								if ($row['type'] == 'ALL') {
									$msg = "OOPS, FOUND FULLTABLE SCAN!\n ";
									$msg .= "\nSQL: \n $log\n";
									Log::warning($msg);
									return;
									//throw new \Exception($msg);
								}
							}
						}
						Log::debug($log);
					}
				});
			}
	}
}
