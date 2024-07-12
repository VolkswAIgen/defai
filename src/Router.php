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

use VolkswAIgen\VolkswAIgen\Main;

final class Router
{
	private Main $volkswaigen;

	private WP $wp;
	public function __construct(
		Main $vokswaigen,
		WP $wp,
	) {
		$this->volkswaigen = $vokswaigen;
		$this->wp = $wp;
	}

	public function __invoke(mixed $wp): void
	{
		if (!$this->volkswaigen->isAiBot(
			$_SERVER['HTTP_USER_AGENT'],
			$_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'],
		)) {
			return;
		}

		$this->wp->wp_redirect('https://openai.com', 302, false);
		exit;
	}
}
