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
$view = optional_param('view', 'home', PARAM_ALPHA);
if (!in_array($view, ['home', 'new', 'popular', 'terms'], true)) {
    throw new moodle_exception('invalidparameter');
}
admin_externalpage_setup('local_smartreport', '', ['view' => $view]);
$PAGE->set_url(new moodle_url('/local/smartreport/index.php', ['view' => $view]));
$PAGE->set_pagelayout('standard');
$chatname = trim((string)get_config('local_smartreport', 'chatname'));
if ($chatname === '') {
    $chatname = get_string('pluginname', 'local_smartreport');
}
$PAGE->set_title($chatname);
$PAGE->set_heading($chatname);
$PAGE->requires->css('/local/smartreport/styles.css');
$PAGE->navbar->add($chatname, new moodle_url('/local/smartreport/index.php'));
echo $OUTPUT->header();
$context = ['home' => (new moodle_url('/local/smartreport/index.php'))->out(false),
    'settings' => (new moodle_url('/local/smartreport/configure.php'))->out(false),
    'ishome' => $view === 'home', 'chatname' => $chatname];
foreach (['circle', 'plus-h', 'plus-v', 'list-line', 'list-dot'] as $icon) {
    $context[str_replace('-', '_', $icon)] = $OUTPUT->image_url($icon, 'local_smartreport')->out(false);
}
if ($view === 'home') {
    $context['cards'] = [];
    foreach (['new', 'popular', 'terms'] as $card) {
        $context['cards'][] = ['url' => (new moodle_url('/local/smartreport/index.php', ['view' => $card]))->out(false),
            'title' => get_string($card, 'local_smartreport'), 'description' => get_string($card . 'desc', 'local_smartreport'),
            'isnew' => $card === 'new', 'ispopular' => $card === 'popular', 'isterms' => $card === 'terms'];
    }
} else {
    $context['title'] = get_string($view, 'local_smartreport');
    $terms = trim((string)get_config('local_smartreport', 'termscontent'));
    $context['body'] = $view === 'terms' && $terms !== '' ? $terms : get_string($view . 'pending', 'local_smartreport');
}
echo $OUTPUT->render_from_template('local_smartreport/home', $context);
echo $OUTPUT->footer();
