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
		    // This value is taken as is. It is vital that no modification is
			// done as otherwise the matching might break due to a modified
			// string.
			// The useragent as well as the IP-address are nowhere stored,
			// neither to DB, the filesystem or anywhere else and also not
			// executed or sent back to the browser in whatever form.
			// The two values are merely used to match a regex against and then
			// safely discarded. Therefore sanitizing or escaping does not
			// really make sense. On the contrary. Sanitizing the values in
			// terms of modifying them might actually break the further process
			// as the regex-matching might not work due to the strings having
			// been modified in critical parts.
			// The validation part on the other hand is what this whole plugin
			// is about. Validating that neither IP nor UserAgent match a
			// certain regex-pattern.
			$_SERVER['HTTP_USER_AGENT'],
			// We are validating that the passed value is indeed a valid
			// IP-address. If it is not a valid IP-Address the filter_var will
			// return false which will break the type on runtime.
			filter_var(
				$_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'],
				FILTER_VALIDATE_IP,
				FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 | FILTER_FLAG_GLOBAL_RANGE
			)
		)) {
			return;
		}

		$this->wp->wp_redirect('https://openai.com', 302, false);
		exit;
	}
}
