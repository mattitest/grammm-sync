<?php
/***********************************************
* File      :   syncrightsmanagementtemplates.php
* Project   :   Grammm-Sync
* Descr     :   WBXML rights management templates entities
*               that can be parsed directly (as a stream)
*               from WBXML.
*               It is automatically decoded
*               according to $mapping,
*               and the Sync WBXML mappings
*
* Created   :   15.06.2017
*
* Copyright 2017 Zarafa Deutschland GmbH
* Copyright 2020 Grammm GmbH
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License, version 3,
* as published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* Consult LICENSE file for details
************************************************/

class SyncRightsManagementTemplates extends SyncObject {

    public $rmtemplates;
    public $Status;

    public function __construct() {
        $mapping = array (
            SYNC_RIGHTSMANAGEMENT_TEMPLATES     => array (  self::STREAMER_VAR   => "rmtemplates",
                                                            self::STREAMER_TYPE  => "SyncRigtsManagementTemplate",
                                                            self::STREAMER_ARRAY => SYNC_RIGHTSMANAGEMENT_TEMPLATE,
                                                            self::STREAMER_PROP  => self::STREAMER_TYPE_SEND_EMPTY),

            SYNC_SETTINGS_PROP_STATUS           => array (  self::STREAMER_VAR      => "Status",
                                                            self::STREAMER_TYPE     => self::STREAMER_TYPE_IGNORE)
        );

        parent::__construct($mapping);
    }
}