<?php
/*
 * SPDX-License-Identifier: AGPL-3.0-only
 * SPDX-FileCopyrightText: Copyright 2007-2016 Zarafa Deutschland GmbH
 * SPDX-FileCopyrightText: Copyright 2020 grammm GmbH
 *
 * Interface called from the Device and StateManager to save states for a
 * user/device/folder. grammm-sync implements the FileStateMachine which saves
 * states to disk. Backends provide their own IStateMachine implementation of
 * this interface and return an IStateMachine instance with
 * IBackend->GetStateMachine(). Old sync states are not deleted until a new
 * sync state is requested. At that moment, the PIM is apparently requesting an
 * update since sync key X, so any sync states before X are already on the PIM,
 * and can therefore be removed. This algorithm should be automatically
 * enforced by the IStateMachine implementation.
 */

interface IStateMachine {
    const DEFTYPE = "";
    const DEVICEDATA = "devicedata";
    const FOLDERDATA = "fd";
    const FAILSAVE = "fs";
    const HIERARCHY = "hc";
    const BACKENDSTORAGE = "bs";

    const STATEVERSION_01 = "1";    // Z-Push 2.0.x - default value if unset
    const STATEVERSION_02 = "2";    // Z-Push 2.1.0 Milestone 1

    /**
     * Constructor
     * @throws FatalMisconfigurationException
     */

    /**
     * Gets a hash value indicating the latest dataset of the named
     * state with a specified key and counter.
     * If the state is changed between two calls of this method
     * the returned hash should be different
     *
     * @param string    $devid              the device id
     * @param string    $type               the state type
     * @param string    $key                (opt)
     * @param string    $counter            (opt)
     *
     * @access public
     * @return string
     * @throws StateNotFoundException, StateInvalidException, UnavailableException
     */
    public function GetStateHash($devid, $type, $key = false, $counter = false);

    /**
     * Gets a state for a specified key and counter.
     * This method sould call IStateMachine->CleanStates()
     * to remove older states (same key, previous counters)
     *
     * @param string    $devid              the device id
     * @param string    $type               the state type
     * @param string    $key                (opt)
     * @param string    $counter            (opt)
     * @param string    $cleanstates        (opt)
     *
     * @access public
     * @return mixed
     * @throws StateNotFoundException, StateInvalidException, UnavailableException
     */
    public function GetState($devid, $type, $key = false, $counter = false, $cleanstates = true);

    /**
     * Writes ta state to for a key and counter
     *
     * @param mixed     $state
     * @param string    $devid              the device id
     * @param string    $type               the state type
     * @param string    $key                (opt)
     * @param int       $counter            (opt)
     *
     * @access public
     * @return boolean
     * @throws StateInvalidException, UnavailableException
     */
    public function SetState($state, $devid, $type, $key = false, $counter = false);

    /**
     * Cleans up all older states.
     * If called with a $counter, all states previous state counter can be removed.
     * If additionally the $thisCounterOnly flag is true, only that specific counter will be removed.
     * If called without $counter, all keys (independently from the counter) can be removed.
     *
     * @param string    $devid              the device id
     * @param string    $type               the state type
     * @param string    $key
     * @param string    $counter            (opt)
     * @param string    $thisCounterOnly    (opt) if provided, the exact counter only will be removed
     *
     * @access public
     * @return
     * @throws StateInvalidException
     */
    public function CleanStates($devid, $type, $key, $counter = false, $thisCounterOnly = false);

    /**
     * Links a user to a device
     *
     * @param string    $username
     * @param string    $devid
     *
     * @access public
     * @return boolean     indicating if the user was added or not (existed already)
     */
    public function LinkUserDevice($username, $devid);

   /**
     * Unlinks a device from a user
     *
     * @param string    $username
     * @param string    $devid
     *
     * @access public
     * @return boolean
     */
    public function UnLinkUserDevice($username, $devid);

    /**
     * Returns an array with all device ids for a user.
     * If no user is set, all device ids should be returned
     *
     * @param string    $username   (opt)
     *
     * @access public
     * @return array
     */
    public function GetAllDevices($username = false);

    /**
     * Returns the current version of the state files
     *
     * @access public
     * @return int
     */
    public function GetStateVersion();

    /**
     * Sets the current version of the state files
     *
     * @param int       $version            the new supported version
     *
     * @access public
     * @return boolean
     */
    public function SetStateVersion($version);

    /**
     * Returns all available states for a device id
     *
     * @param string    $devid              the device id
     *
     * @access public
     * @return array(mixed)
     */
    public function GetAllStatesForDevice($devid);
}
