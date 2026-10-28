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

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
\local_smartreport\access::require_admin();
admin_externalpage_setup('local_smartreport_settings');
$PAGE->requires->css('/local/smartreport/styles.css');
$form = new \local_smartreport\form\configuration();
$home = new moodle_url('/local/smartreport/index.php');
if ($form->is_cancelled()) { redirect($home); }
if ($data = $form->get_data()) {
    require_sesskey();
    foreach (['provider', 'localurl', 'models', 'chatname', 'perpage', 'termscontent'] as $name) {
        $value = $data->$name;
        if ($name === 'models') { $value = implode(', ', array_map('trim', explode(',', $value))); }
        set_config($name, $value, 'local_smartreport');
    }
    if (!empty($data->clearkey)) {
        unset_config('apikey', 'local_smartreport');
    } else if ($data->apikey !== '') {
        set_config('apikey', $data->apikey, 'local_smartreport');
    }
    redirect($home, get_string('saved', 'local_smartreport'),
        null, \core\output\notification::NOTIFY_SUCCESS);
}
$defaults = ['provider' => 'openai', 'localurl' => '', 'models' => '',
    'chatname' => 'SmartReport', 'perpage' => 4, 'termscontent' => ''];
$config = (array)get_config('local_smartreport');
// Never insert the stored API key into HTML, even in a password field.
$values = array_intersect_key($config, $defaults) + $defaults;
$form->set_data((object)$values);
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('settings', 'local_smartreport'));
echo html_writer::start_div('smartreport smartreport-config');
echo html_writer::link($home, get_string('back', 'local_smartreport'));
echo $OUTPUT->heading(get_string('configuration', 'local_smartreport'), 3);
echo html_writer::tag('p', get_string('configurationdesc', 'local_smartreport'), ['class' => 'smartreport-muted']);
$form->display();
echo html_writer::end_div();
echo $OUTPUT->footer();
