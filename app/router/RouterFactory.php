<?php

namespace App;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
                
                $router[] = new Route('pridat-projekt', 'Homepage:create');
                $router[] = new Route('upravit-projekt/id=<projectId>', 'Homepage:update');
                $router[] = new Route('prihlasovani', 'Sign:in');
                $router[] = new Route('registrovani', 'Sign:up');
                
                
                
                $router[] = new Route('<presenter>/<action>', 'Homepage:default');
		return $router;
	}
}
