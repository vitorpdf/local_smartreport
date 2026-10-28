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

namespace local_smartreport\form;
defined('MOODLE_INTERNAL') || die;
require_once($CFG->libdir . '/formslib.php');
class configuration extends \moodleform {
    public function definition() {
        $mform = $this->_form;
        $mform->addElement('select', 'provider', get_string('provider', 'local_smartreport'),
            ['openai' => 'OpenAI (ChatGPT)', 'gemini' => 'Google Gemini', 'local' => 'Local (Llama)']);
        $mform->addElement('static', 'providerhelp', '', get_string('providerdesc', 'local_smartreport'));
        $mform->addElement('password', 'apikey', get_string('apikey', 'local_smartreport'),
            ['autocomplete' => 'new-password', 'maxlength' => 1024]);
        $mform->setType('apikey', PARAM_RAW_TRIMMED);
        $mform->addElement('static', 'keyhelp', '', get_string('apikeydesc', 'local_smartreport'));
        $mform->addElement('advcheckbox', 'clearkey', get_string('clearkey', 'local_smartreport'));
        foreach (['localurl', 'models', 'chatname', 'perpage'] as $name) {
            $mform->addElement('text', $name, get_string($name, 'local_smartreport'), ['size' => 50]);
            // Keep the original numeric text to reject malformed values rather than silently coercing them.
            $mform->setType($name, $name === 'perpage' ? PARAM_RAW_TRIMMED : PARAM_TEXT);
            if (in_array($name, ['models', 'chatname', 'perpage'])) {
                $mform->addRule($name, get_string('required'), 'required', null, 'server');
            }
            if (in_array($name, ['localurl', 'models'])) {
                $mform->addElement('static', $name . 'help', '', get_string($name . 'desc', 'local_smartreport'));
            }
        }
        $mform->addElement('textarea', 'termscontent', get_string('termscontent', 'local_smartreport'),
            ['rows' => 6, 'cols' => 60]);
        $mform->setType('termscontent', PARAM_TEXT);
        $mform->addElement('static', 'termshelp', '', get_string('termscontentdesc', 'local_smartreport'));
        $this->add_action_buttons(true, get_string('savechanges'));
    }
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        return array_merge($errors, \local_smartreport\configuration::validate($data));
    }
}
