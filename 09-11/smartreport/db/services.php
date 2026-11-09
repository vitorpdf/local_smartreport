<?php
// This file is part of Moodle - http://moodle.org/
// Licensed under the GNU GPL v3 or later.
defined('MOODLE_INTERNAL') || die;
$functions = [
    'local_smartreport_site_summary' => [
        'classname' => 'local_smartreport\external\site_summary',
        'methodname' => 'execute',
        'description' => 'Read live site indicators without an AI request.',
        'type' => 'read',
        'ajax' => true,
        'capabilities' => 'local/smartreport:view',
    ],
    'local_smartreport_send_message' => [
        'classname' => 'local_smartreport\external\send_message',
        'methodname' => 'execute',
        'description' => 'Send an administrator message to the configured AI provider.',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'local/smartreport:view',
    ],
];
