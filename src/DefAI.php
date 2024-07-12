<?php
/*
 * DefAI - Provide dedicated content just for AI bots.
 *
 * Copyright (C) 2024 VolkswAIgen-Team
 *
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version. This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program. If not, see <http://www.gnu.org/licenses/>.
 */
declare(strict_types=1);

namespace VolkswAIgen\DefAI;

use Psr\Cache\CacheItemPoolInterface;
use VolkswAIgen\DefAI\Integration\DbCacheItemPool;
use VolkswAIgen\DefAI\Integration\WP as WPImplementation;
use VolkswAIgen\VolkswAIgen\ListFetcher;
use VolkswAIgen\VolkswAIgen\Main;

final class DefAI
{
	public function __construct() {}

	public function init(): void
	{
		$container = new Container();
		$container->add(Router::class, function(Container $c): Router {
			return new Router(
				$c->get(Main::class),
				$c->get(WP::class),
			);
		});
		$container->add(Main::class, function(Container $c): Main {
			return new Main($c->get(ListFetcher::class));
		});
		$container->add(ListFetcher::class, function(Container $c): ListFetcher {
			return new ListFetcher($c->get(CacheItemPoolInterface::class));
		});
		$container->add(CacheItemPoolInterface::class, function(Container $c): CacheItemPoolInterface {
			return new DbCacheItemPool($c->get(WP::class));
		});
		$container->add(WP::class, function(Container $c): WP {
			return new WPImplementation();
		});


		$wp = $container->get(WP::class);

		$wp->add_action('parse_request', $container->get(Router::class));
	}
}
