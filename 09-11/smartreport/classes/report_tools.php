<?php
// This file is part of Moodle - http://moodle.org/
// Licensed under the GNU GPL v3 or later.
namespace local_smartreport;
defined('MOODLE_INTERNAL') || die;

/** Bounded, read-only reporting tools using Moodle's existing database connection. */
final class report_tools {
    public const TOOLS = ['site_summary', 'find_courses', 'list_roles', 'course_summary', 'inactive_users'];

    /** Reject model-generated SQL, identifiers and unknown arguments. */
    public static function validate(string $tool, array $args): array {
        $allowed = [
            'site_summary' => ['days'], 'find_courses' => ['query', 'page'], 'list_roles' => [],
            'course_summary' => ['courseid', 'days'],
            'inactive_users' => ['courseid', 'days', 'roleid', 'page'],
        ];
        if (!isset($allowed[$tool]) || array_diff(array_keys($args), $allowed[$tool])) {
            throw new \moodle_exception('invalidtool', 'local_smartreport');
        }
        $out = [];
        foreach ($args as $key => $value) {
            if ($key === 'query') {
                if (!is_string($value) || \core_text::strlen($value) > 100) {
                    throw new \moodle_exception('invalidtool', 'local_smartreport');
                }
                $out[$key] = trim($value);
            } else {
                $max = $key === 'days' ? 3650 : ($key === 'page' ? 10000 : 2147483647);
                $min = $key === 'roleid' ? 0 : 1;
                if (!is_int($value) || $value < $min || $value > $max) {
                    throw new \moodle_exception('invalidtool', 'local_smartreport');
                }
                $out[$key] = $value;
            }
        }
        if (in_array($tool, ['course_summary', 'inactive_users'], true) && empty($out['courseid'])) {
            throw new \moodle_exception('courserequired', 'local_smartreport');
        }
        return $out;
    }

    /** Read current records. This method is also protected when called outside AJAX. */
    public static function run(string $tool, array $args): array {
        global $DB, $CFG;
        access::require_admin();
        $args = self::validate($tool, $args);
        $now = time();
        $days = $args['days'] ?? 15;
        $cutoff = $now - $days * DAYSECS;
        $page = $args['page'] ?? 1;
        $limit = max(1, min(200, (int)(get_config('local_smartreport', 'perpage') ?: 4)));
        $offset = ($page - 1) * $limit;
        $rows = [];
        $total = 0;
        $note = '';
        $headers = [];
        $title = get_string('tool_' . $tool, 'local_smartreport');
        if ($tool === 'site_summary') {
            $guestid = (int)($CFG->siteguest ?? 0);
            $users = 'deleted = 0 AND suspended = 0 AND id <> :guest';
            $headers = [get_string('indicator', 'local_smartreport'), get_string('value', 'local_smartreport')];
            $rows = [
                [get_string('visiblecourses', 'local_smartreport'), (string)$DB->count_records_select('course', 'id <> :site AND visible = 1', ['site' => SITEID])],
                [get_string('activeaccounts', 'local_smartreport'), (string)$DB->count_records_select('user', $users, ['guest' => $guestid])],
                [get_string('recentaccounts', 'local_smartreport', $days), (string)$DB->count_records_select('user', $users . ' AND lastaccess >= :cutoff', ['guest' => $guestid, 'cutoff' => $cutoff])],
            ];
            $total = count($rows);
            $note = get_string('sitenote', 'local_smartreport');
        } else if ($tool === 'find_courses') {
            $query = $args['query'] ?? '';
            $where = 'id <> :site';
            $params = ['site' => SITEID];
            if ($query !== '') {
                $where .= ' AND (' . $DB->sql_like('fullname', ':fullname', false) . ' OR ' . $DB->sql_like('shortname', ':shortname', false) . ')';
                $params['fullname'] = '%' . $DB->sql_like_escape($query) . '%';
                $params['shortname'] = $params['fullname'];
            }
            $total = $DB->count_records_select('course', $where, $params);
            $records = $DB->get_records_select('course', $where, $params, 'fullname, id', 'id, fullname, shortname, visible', $offset, $limit);
            $headers = ['ID', get_string('course'), get_string('shortname'), get_string('visible', 'local_smartreport')];
            foreach ($records as $record) {
                $rows[] = [(string)$record->id, $record->fullname, $record->shortname, get_string($record->visible ? 'yes' : 'no')];
            }
            $note = get_string('choosecourse', 'local_smartreport');
        } else if ($tool === 'list_roles') {
            $headers = ['ID', get_string('role'), get_string('shortname'), get_string('archetype', 'local_smartreport')];
            foreach ($DB->get_records('role', null, 'id', 'id, name, shortname, archetype', 0, 200) as $role) {
                $rows[] = [(string)$role->id, $role->name ?: $role->shortname, $role->shortname, $role->archetype];
            }
            $total = $DB->count_records('role');
            $note = get_string('rolesnote', 'local_smartreport');
        } else {
            $courseid = $args['courseid'];
            $course = $DB->get_record('course', ['id' => $courseid], 'id, fullname, enablecompletion');
            if (!$course || $courseid === SITEID) {
                throw new \moodle_exception('courserequired', 'local_smartreport');
            }
            $title .= ' — ' . $course->fullname . ' (ID ' . $courseid . ')';
            // An active enrolment must be enabled, not suspended, started and not expired.
            // Group first to avoid duplicate users enrolled by more than one method.
            $enrolled = 'SELECT ue.userid, MIN(CASE WHEN ue.timestart > 0 THEN ue.timestart ELSE ue.timecreated END) AS enrolledsince
                FROM {user_enrolments} ue JOIN {enrol} e ON e.id = ue.enrolid
                WHERE e.courseid = :course AND e.status = 0 AND ue.status = 0
                  AND ue.timestart <= :startnow AND (ue.timeend = 0 OR ue.timeend > :endnow)
                GROUP BY ue.userid';
            $params = ['course' => $courseid, 'startnow' => $now, 'endnow' => $now, 'accesscourse' => $courseid];
            $from = " FROM {user} u JOIN ($enrolled) en ON en.userid = u.id
                LEFT JOIN {user_lastaccess} la ON la.userid = u.id AND la.courseid = :accesscourse";
            $where = ' WHERE u.deleted = 0 AND u.suspended = 0';
            if ($tool === 'course_summary') {
                $headers = [get_string('indicator', 'local_smartreport'), get_string('value', 'local_smartreport')];
                $active = $DB->count_records_sql('SELECT COUNT(1)' . $from . $where, $params);
                $recent = $DB->count_records_sql('SELECT COUNT(1)' . $from . $where . ' AND la.timeaccess >= :cutoff', $params + ['cutoff' => $cutoff]);
                $completed = $course->enablecompletion ? $DB->count_records_sql('SELECT COUNT(1)' . $from . $where .
                    ' AND EXISTS (SELECT 1 FROM {course_completions} cc WHERE cc.userid = u.id AND cc.course = :completedcourse AND cc.timecompleted > 0)',
                    $params + ['completedcourse' => $courseid]) : null;
                $rows = [
                    [get_string('activeparticipants', 'local_smartreport'), (string)$active],
                    [get_string('recentparticipants', 'local_smartreport', $days), (string)$recent],
                    [get_string('completedparticipants', 'local_smartreport'), $completed === null ? get_string('completiondisabled', 'local_smartreport') : (string)$completed],
                ];
                $total = count($rows);
                $note = get_string('coursenote', 'local_smartreport');
            } else {
                $where .= ' AND en.enrolledsince < :enrolcutoff AND (la.timeaccess IS NULL OR la.timeaccess < :accesscutoff)';
                $params += ['enrolcutoff' => $cutoff, 'accesscutoff' => $cutoff];
                $roleid = $args['roleid'] ?? 0;
                if ($roleid) {
                    if (!$DB->record_exists('role', ['id' => $roleid])) {
                        throw new \moodle_exception('invalidtool', 'local_smartreport');
                    }
                    $context = \context_course::instance($courseid);
                    [$insql, $inparams] = $DB->get_in_or_equal($context->get_parent_context_ids(true), SQL_PARAMS_NAMED, 'ctx');
                    $where .= " AND EXISTS (SELECT 1 FROM {role_assignments} ra WHERE ra.userid = u.id AND ra.roleid = :roleid AND ra.contextid $insql)";
                    $params += ['roleid' => $roleid] + $inparams;
                }
                $total = $DB->count_records_sql('SELECT COUNT(1)' . $from . $where, $params);
                $records = $DB->get_records_sql('SELECT u.id, u.firstname, u.lastname, la.timeaccess, en.enrolledsince' . $from . $where .
                    ' ORDER BY u.lastname, u.firstname, u.id', $params, $offset, $limit);
                $headers = ['ID', get_string('fullname'), get_string('lastcourseaccess', 'local_smartreport'), get_string('dayswithoutaccess', 'local_smartreport')];
                foreach ($records as $record) {
                    $last = (int)$record->timeaccess;
                    $rows[] = [(string)$record->id, trim($record->firstname . ' ' . $record->lastname),
                        $last ? userdate($last) : get_string('neveraccessed', 'local_smartreport'),
                        (string)floor(($now - ($last ?: (int)$record->enrolledsince)) / DAYSECS)];
                }
                $note = get_string('inactivenote', 'local_smartreport', $days) . ' ' .
                    ($roleid ? get_string('rolefilter', 'local_smartreport', $roleid) : get_string('allroles', 'local_smartreport'));
            }
        }
        $report = ['title' => $title, 'headers' => $headers, 'rows' => $rows, 'total' => $total,
            'page' => $page, 'hasmore' => in_array($tool, ['find_courses', 'inactive_users'], true) && $offset + count($rows) < $total,
            'generatedat' => userdate($now), 'note' => $note];
        // Only aggregate summary and tool arguments enter conversational history; never participant rows.
        $reply = $title . "\n" . get_string('reportcount', 'local_smartreport', (object)['shown' => count($rows), 'total' => $total]) .
            "\n" . $note . "\n" . get_string('reporttime', 'local_smartreport', $report['generatedat']);
        $context = 'Executed tool ' . $tool . ' with arguments ' . json_encode($args) . '. Returned ' . $total .
            ' matches. Data rows were shown locally and are not in this conversation context. Re-run tools for current values.';
        return ['reply' => $reply, 'report' => json_encode($report, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE), 'context' => $context];
    }
}
