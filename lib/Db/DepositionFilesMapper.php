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

//use \OCA\Zenodo\Db\DepositionFiles;
//use \OCA\Zenodo\Model\DepositionFile;
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\IDBConnection;
use OCP\AppFramework\Db\Mapper;

class DepositionFilesMapper extends Mapper {

	const TABLENAME = 'zenodo_depositions_files';

	public function __construct(IDBConnection $db) {
		parent::__construct($db, self::TABLENAME, 'OCA\Zenodo\Db\DepositionFiles');
	}

	public function find($id) {
		try {
			$sql = sprintf('SELECT * FROM *PREFIX*%s WHERE id = ?', self::TABLENAME);

			return $this->findEntity($sql, [$id]);
		} catch (DoesNotExistException $dnee) {
			return null;
		}

	}

	public function findFile($fileId) {
		try {
			$sql = sprintf('SELECT * FROM *PREFIX*%s WHERE file_id = ?', self::TABLENAME);

			return $this->findEntity($sql, [$fileId]);
		} catch (DoesNotExistException $dnee) {
			return null;
		}
	}



	public function findDeposit($depositId) {
		try {
			$sql = sprintf('SELECT * FROM *PREFIX*%s WHERE deposit_id = ?', self::TABLENAME);

			return $this->findEntity($sql, [$depositId]);
		} catch (DoesNotExistException $dnee) {
			return null;
		}
	}


	// force will delete whichever type of the entry. if not, only delete sandbox entry
	public function deleteFile(DepositionFiles $entry, $force) {
		try {
			$sql = sprintf(
				'DELETE FROM *PREFIX*%s WHERE file_id = ? %s', self::TABLENAME,
				(($force) ? '' : "AND type='sandbox'")
			);

			return $this->execute($sql, [$entry->getFileId()]);

		} catch (DoesNotExistException $dnee) {
			return null;
		}

		return $entry;
	}


}

