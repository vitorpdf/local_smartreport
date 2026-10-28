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
$string['pluginname'] = 'SmartReport';
$string['success'] = 'Funcionou';
$string['open'] = 'Open SmartReport';
$string['settings'] = 'SmartReport settings';
$string['adminonly'] = 'SmartReport is restricted to site administrators.';
$string['subtitle'] = 'Query Moodle indicators quickly and clearly.';
$string['new'] = 'New';
$string['newdesc'] = 'Start a new query';
$string['popular'] = 'Popular';
$string['populardesc'] = 'Access frequent questions';
$string['terms'] = 'Terms of use';
$string['termsdesc'] = 'Read rules and guidance';
$string['back'] = '← Back';
$string['configuration'] = 'Configuration';
$string['configurationdesc'] = 'Set the provider and models used by SmartReport.';
$string['provider'] = 'AI provider';
$string['providerdesc'] = 'Select OpenAI, Google Gemini or Local (Llama).';
$string['apikey'] = 'API key';
$string['apikeydesc'] = 'Leave blank to retain the saved key. Enter a new key to replace it.';
$string['clearkey'] = 'Remove saved API key';
$string['localurl'] = 'Query URL';
$string['localurldesc'] = 'Required when Local (Llama) is selected.';
$string['models'] = 'Models';
$string['modelsdesc'] = 'Enter one or more comma-separated models.';
$string['chatname'] = 'Displayed chat name';
$string['perpage'] = 'Records per page';
$string['termscontent'] = 'Terms of use content';
$string['termscontentdesc'] = 'Content supplied and approved by the client. Leave blank while pending.';
$string['termspending'] = 'Terms of use are awaiting client content and approval.';
$string['newpending'] = 'New queries will be available in sprint 2.';
$string['popularpending'] = 'Popular reports will be available in sprint 6.';
$string['saved'] = 'Settings saved.';
$string['invalidurl'] = 'Enter a valid HTTP or HTTPS URL without credentials.';
$string['invalidmodels'] = 'Enter comma-separated models without empty items (100 characters maximum per model).';
$string['invalidperpage'] = 'Enter an integer between 1 and 200.';
$string['invalidprovider'] = 'Select a valid provider.';
$string['privacy:metadata'] = 'SmartReport does not store personal data. Settings are site-wide and no data is sent to AI providers.';
$string['smartreport:view'] = 'View SmartReport';
$string['listicon'] = '☷';
