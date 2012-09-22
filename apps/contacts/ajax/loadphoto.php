<?php
/**
 * ownCloud - Addressbook
 *
 * @author Thomas Tanghus
 * @copyright 2012 Thomas Tanghus <thomas@tanghus.net>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
 
// Check if we are a user
OCP\JSON::checkLoggedIn();
OCP\JSON::checkAppEnabled('contacts');

require_once 'loghandler.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$refresh = isset($_GET['refresh']) ? true : false;

if($id == '') {
	bailOut(OC_Contacts_App::$l10n->t('Missing contact id.'));
}

$checksum = '';
$vcard = OC_Contacts_App::getContactVCard( $id );
foreach($vcard->children as $property){
	if($property->name == 'PHOTO') {
		$checksum = md5($property->serialize());
		break;
	}
}

OCP\JSON::success(array('data' => array('checksum'=>$checksum)));
