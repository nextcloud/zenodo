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

script('zenodo', 'admin');
style('zenodo', 'admin');

?>





<div class="section" id="circles">
	<h2><?php p($l->t('Zenodo')) ?></h2>

	<p>
		<label><?php p($l->t('Sandbox Token')); ?></label><br />
		<input type="text" id="sandboxtoken" />
	</p>
	<p>
		<label><?php p($l->t('Production Token')); ?></label><br />
		<input type="text" id="productiontoken" />
	</p>

	<p>
		<input type="submit" id="tokensubmit" value="<?php p($l->t('Store Zenodo Credentials')); ?>">
	</p>
</div>
