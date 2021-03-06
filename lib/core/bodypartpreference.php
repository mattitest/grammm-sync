<?php
/*
 * SPDX-License-Identifier: AGPL-3.0-only
 * SPDX-FileCopyrightText: Copyright 2017 Zarafa Deutschland GmbH
 * SPDX-FileCopyrightText: Copyright 2020 grammm GmbH
 *
 * Holds body part preference data
 */

class BodyPartPreference extends StateObject {
    protected $unsetdata = array(   'truncationsize' => false,
                                    'allornone' => false,
                                    'preview' => false,
                                );

    /**
     * Expected magic getters and setters.
     *
     * GetTruncationSize() + SetTruncationSize()
     * GetAllOrNone() + SetAllOrNone()
     * GetPreview() + SetPreview()
     */

    /**
     * Indicates if this object has values.
     *
     * @access public
     * @return boolean
     */
    public function HasValues() {
        return (count($this->data) > 0);
    }
}
