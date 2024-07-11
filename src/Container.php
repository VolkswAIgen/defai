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

final class Container
{
	/**
	 * @template T of object
	 * @var array<class-string<T>, T>,
	 */
	private array $instances = [];

	/**
	 * @template S of object
	 * @var array<class-string<S>, \Closure(Container): S
	 */
	private array $closures = [];
	/**
	 * @template U of object
	 * @param class-string<U> $className
	 * @return U
	 */
	public function get(string $className): object
	{
		if (! in_array($className, $this->instances)) {
			$this->instances[$className] = $this->closures[$className]($this);
		}

		return $this->instances[$className];
	}

	/**
	 * @template R of object
	 * @param class-string<R> $class
	 * @param Closure(Container):R $closure
	 */
	public function add(string $class, Closure $closure): void
	{
		$this->closures[$class] = $closure;
	}
}
