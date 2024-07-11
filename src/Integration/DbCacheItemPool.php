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

namespace VolkswAIgen\DefAI\Integration;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use RuntimeException;
use VolkswAIgen\DefAI\WP;

final class DbCacheItemPool implements CacheItemPoolInterface
{
	private WP $wp;

	public function __construct(WP $wp)
	{
		$this->wp = $wp;
	}

	public function getItem(string $key): CacheItemInterface
	{
		$option = $this->wp->get_option('defai_' . $key);

		return DbCacheItem::createFromWpOption($option, $key);
	}

	public function getItems(array $keys = []): iterable
	{
		throw new RuntimeException("Not implemented");
	}

	public function hasItem(string $key): bool
	{
		throw new RuntimeException("Not implemented");
	}

	public function clear(): bool
	{
		throw new RuntimeException("Not implemented");
	}

	public function deleteItem(string $key): bool
	{
		throw new RuntimeException("Not implemented");
	}

	public function deleteItems(array $keys): bool
	{
		throw new RuntimeException("Not implemented");
	}

	public function save(CacheItemInterface $item): bool
	{
		if ($item instanceof DbCacheItem) {
			$item = $item->getWpOption();
		}
		$this->wp->set_option('defai_' . $item->getKey(), $item);

		return true;
	}

	public function saveDeferred(CacheItemInterface $item): bool
	{
		throw new RuntimeException("Not implemented");
	}

	public function commit(): bool
	{
		throw new RuntimeException("Not implemented");
	}
}
