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

use VolkswAIgen\DefAI\WP as WPInterface;

final class WP implements WPInterface
{

	public function add_filter(string $name, callable $function)
	{
		return add_filter($name. $function);
	}

	public function get_option(string $name, $default = false): mixed
	{
		return get_option($name, $default);
	}

	public function set_option(string $name, $value)
	{
		$this->set_option($name, $value);
	}
}
