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

use DateInterval;
use DateTimeImmutable;
use Psr\Cache\CacheItemInterface;

final class DbCacheItem implements CacheItemInterface
{
	private array $data;
	private DateTimeImmutable $expiresAt;

	private string $key;

	public function __construct(array $data, DateTimeImmutable $expiresAt, string $key)
	{
		$this->data = $data;
		$this->expiresAt = $expiresAt;
		$this->key = $key;
	}

	public function getKey(): string
	{
		return $this->key;
	}

	public function get(): mixed
	{
		return $this->data;
	}

	public static function createFromWpOption(string $wpOptionValue, string $key): self
	{
		$value = json_decode($wpOptionValue, true);

		return new self($value['data'], new DateTimeImmutable($value['expires_at']), $key);
	}

	public function getWpOption(): string
	{
		return json_encode(['data' => $this->data, 'expires_at' => $this->expiresAt->format('Y-m-d H:i:s')]);
	}

	public function isHit(): bool
	{
		return new DateTimeImmutable() < $this->expiresAt;
	}

	public function set(mixed $value): static
	{
		$this->data = $value;
		return $this;
	}

	public function expiresAt(?\DateTimeInterface $expiration): static
	{
		$this->expiresAt = DateTimeImmutable::createFromInterface($expiration);;

		return $this;
	}

	public function expiresAfter(DateInterval|int|null $time): static
	{
		if (! $time instanceof DateInterval) {
			$time = new DateInterval('PT' . $time . 'S');
		}
		$this->expiresAt = (new DateTimeImmutable())->add($time);

		return $this;
	}
}
