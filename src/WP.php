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
namespace VolkswAIgen\DefAI;

interface WP
{
	public function add_filter(string $name, callable $function);

	public function get_option(string $name, $default = false): mixed;

	public function set_option(string $name, $value);

	public function add_action(string $action, callable $function);

	public function wp_redirect(string $url, int $code, bool|string $expose);
}
