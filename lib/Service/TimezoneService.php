<?php
/**
 * Circles - Bring cloud-users closer together.
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @copyright 2017
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU AVolu ffero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\Circles\Service;


class TimezoneService {


	/** @var string */
	private $userId;

	/** @var ConfigService */
	private $configService;


	/**
	 * TimezoneService constructor.
	 *
	 * @param string $userId
	 * @param ConfigService $configService
	 */
	public function __construct($userId, ConfigService $configService) {
		$this->userId = $userId;
		$this->configService = $configService;
	}


	/**
	 * @param string $time
	 *
	 * @return string
	 */
	public function convertTimeForCurrentUser($time) {
		return $this->convertTimeForUserId($this->userId, $time);
	}


	/**
	 * @param string $userId
	 * @param string $time
	 *
	 * @return string
	 */
	public function convertTimeForUserId($userId, $time) {
		$timezone = $this->configService->getCoreValueForUser($userId, 'timezone', 'UTC');
		$date = \DateTime::createFromFormat('Y-m-d H:i:s', $time);
		$date->setTimezone(new \DateTimeZone($timezone));

		return $date->format('Y-m-d H:i:s');
	}


	/**
	 * @return string
	 */
	public function getUTCDate() {
		$defaultTimezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$format = date('Y-m-d H:i:s');
		date_default_timezone_set($defaultTimezone);

		return $format;
	}
}


