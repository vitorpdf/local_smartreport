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

namespace local_smartreport;
defined('MOODLE_INTERNAL') || die;
final class configuration {
    public static function validate(array $data): array {
        $errors = [];
        if (preg_match('/[\r\n]/', $data['apikey'] ?? '') || strlen($data['apikey'] ?? '') > 1024) {
            $errors['apikey'] = get_string('invalidapikey', 'local_smartreport');
        }
        if (trim($data['chatname'] ?? '') === '' || \core_text::strlen(trim($data['chatname'])) > 100) {
            $errors['chatname'] = get_string('invalidchatname', 'local_smartreport');
        }
        if (!empty($data['clearkey']) && trim($data['apikey'] ?? '') !== '') {
            $errors['apikey'] = get_string('conflictingkey', 'local_smartreport');
        }
        if (!in_array($data['provider'], ['openai', 'gemini', 'local'], true)) {
            $errors['provider'] = get_string('invalidprovider', 'local_smartreport');
        }
        $url = trim($data['localurl']);
        $parts = parse_url($url);
        if (($data['provider'] === 'local' && $url === '') || ($url !== '' &&
                (!filter_var($url, FILTER_VALIDATE_URL) || !$parts || empty($parts['host']) ||
                !in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true) ||
                isset($parts['user']) || isset($parts['pass']) || isset($parts['fragment'])))) {
            $errors['localurl'] = get_string('invalidurl', 'local_smartreport');
        }
        foreach (explode(',', $data['models']) as $model) {
            if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9_.:\/\-]{0,99}$/D', trim($model))) {
                $errors['models'] = get_string('invalidmodels', 'local_smartreport');
            }
        }
        if (!preg_match('/^[0-9]+$/D', (string)$data['perpage']) ||
                (int)$data['perpage'] < 1 || (int)$data['perpage'] > 200) {
            $errors['perpage'] = get_string('invalidperpage', 'local_smartreport');
        }
        return $errors;
    }
}
