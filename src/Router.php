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

	public function __construct(
		Main $vokswaigen
	) {
		$this->volkswaigen = $vokswaigen;
	}
	/**
	 * @param false|array{
	 *     headers: array,
	 *     body: string,
	 *     response: string,
	 * 	   cookies: array,
	 *     filename: string
	 * }|WP_Error $response
	 * @param array $parsedArgs
	 * @param string $url
	 *
	 * @return false|array{
	 *      headers: array,
	 *      body: string,
	 *      response: string,
	 *      cookies: array,
	 *      filename: string
	 * }|WP_Error
	 */
	public function __invoke(mixed $response, array $parsedArgs, string $url): mixed
	{
		if ($response instanceof WP_Error) {
			return $response;
		}

		if (! $this->volkswaigen->isAiBot($response, $response)) {
			return $response;
		}

		return [
			'headers' => [
				'location' => 'https://openai.com',
			],
			'body' => '',
			'response' => '302',
			'cookies' => [],
			'filename' => '',
		];
	}
}
