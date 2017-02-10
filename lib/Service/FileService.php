<?php
/**
 * Zenodo - Publish your work to Zenodo.org
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Maxence Lange <maxence@pontapreta.net>
 * @copyright 2017
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
 */

namespace OCA\Zenodo\Service;

use OC\Files\Filesystem;
use OC\Files\View;
use OCP\Files\NotFoundException;

class FileService {

	private $userId;
	private $configService;
	private $miscService;

	public function __construct($userId, $configService, $miscService) {
		$this->userId = $userId;
		$this->configService = $configService;
		$this->miscService = $miscService;
	}

	/**
	 * get files from a userid+fileid
	 *
	 * @param number $userId
	 * @param number $fileId
	 * @param array $options
	 *
	 * @return array
	 */
	public function getFilesPerFileId($fileId) {

		if ($this->userId === '') {
			return false;
		}

		if ($fileId === '') {
			return false;
		}

		$view = Filesystem::getView();

		$data = array();
		$file = self::getFileInfoFromFileId($fileId, $view);

		if ($file === null) {
			return false;
		}

		// no folder yet
		if ($file->getType() === \OCP\Files\FileInfo::TYPE_FOLDER) {
			return false;
		}

		$data[] = $file;

		return $data;
	}


	// might work with encrypted file and remote file
	public static function getAbsolutePath($file) {
		$view = new View('/');
		if ($file->getStorage()
				 ->isLocal()
		) {
			return $view->getLocalFile($file->getPath());
		}

		return $view->toTmpFile($file->getPath(), true);
	}


	public static function getFileInfoFromFileId($fileId) {
		try {

			$view = Filesystem::getView();
			if ($view === null) {
				return null;
			}

			$path = $view->getPath($fileId);
			if ($path === null) {
				return null;
			}

			$file = $view->getFileInfo($path);
			if ($file === null) {
				return null;
			}

			return $file;
		} catch (NotFoundException $e) {
			return null;
		}
	}


}