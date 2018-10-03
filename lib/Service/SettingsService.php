<?php
/**
 * FullTextSearch - Full text search framework for Nextcloud
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Maxence Lange <maxence@artificial-owl.com>
 * @copyright 2018
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
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

namespace OCA\FullTextSearch\Service;

use Exception;

class SettingsService {

	/** @var PlatformService */
	private $platformService;

	/** @var ProviderService */
	private $providerService;

	/** @var MiscService */
	private $miscService;

	/**
	 * SettingsService constructor.
	 *
	 * @param PlatformService $platformService
	 * @param ProviderService $providerService
	 * @param MiscService $miscService
	 */
	public function __construct(
		PlatformService $platformService, ProviderService $providerService,
		MiscService $miscService
	) {
		$this->platformService = $platformService;
		$this->providerService = $providerService;
		$this->miscService = $miscService;
	}


	/**
	 * @param $data
	 *
	 * @return bool
	 */
	public function checkConfig($data) {
		return true;
	}


	/**
	 * @param array $data
	 *
	 * @throws Exception
	 */
	public function completeSettings(&$data) {
		$data = array_merge(
			$data, [
					 'platforms_all' => $this->completeSettingsPlatforms(),
					 'providers_all' => $this->completeSettingsProviders()
				 ]
		);

	}


	/**
	 * @return array
	 * @throws Exception
	 */
	private function completeSettingsPlatforms() {
		$list = [];
		$platforms = $this->platformService->getPlatforms();
		foreach ($platforms as $wrapper) {
			$platform = $wrapper->getPlatform();
			$list[$wrapper->getClass()] = [
				'id'   => $platform->getId(),
				'name' => $platform->getName()
			];
		}

		return $list;
	}


	/**
	 * @return array
	 * @throws Exception
	 */
	private function completeSettingsProviders() {
		$list = [];
		$providers = $this->providerService->getProviders();
		foreach ($providers as $provider) {
			$list[$provider->getId()] = $provider->getName();
		}

		return $list;
	}

}
