<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * SmartReport local plugin.
 *
 * @package    local_smartreport
 * @copyright  2026 Vitor Gabriel Firmino
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
if (is_siteadmin()) {
    $ADMIN->add('reports', new admin_externalpage('local_smartreport',
        get_string('pluginname', 'local_smartreport'),
        new moodle_url('/local/smartreport/index.php')));
    $ADMIN->add('reports', new admin_externalpage('local_smartreport_settings',
        get_string('settings', 'local_smartreport'),
        new moodle_url('/local/smartreport/configure.php')));
}
