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

namespace OCA\Zenodo\Db;

use \OCA\Zenodo\Model\DepositionFile;
use OCP\AppFramework\Db\Entity;

class DepositionFiles extends Entity {

	public $userId;
	public $fileId;
	public $type;
	public $depositId;

	public function __construct(DepositionFile $item = null) {
		if ($item != null) {
			$this->setFileId($item->getFileId());
			$this->setUserId($item->getUserId());
			$this->setType($item->getType());
			$this->setDepositId($item->getDepositId());
		}
	}
}

