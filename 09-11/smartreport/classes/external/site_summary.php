<?php
// This file is part of Moodle - http://moodle.org/
// Licensed under the GNU GPL v3 or later.
namespace local_smartreport\external;
defined('MOODLE_INTERNAL') || die;

/** Live overview available even when the AI provider is unavailable. */
final class site_summary extends \core_external\external_api {
    public static function execute_parameters(): \core_external\external_function_parameters {
        return new \core_external\external_function_parameters([]);
    }
    public static function execute(): array {
        self::validate_context(\context_system::instance());
        \local_smartreport\access::require_admin();
        require_sesskey();
        try {
            return \local_smartreport\report_tools::run('site_summary', ['days' => 15]);
        } catch (\dml_exception $e) {
            throw new \moodle_exception('reportfailed', 'local_smartreport');
        }
    }
    public static function execute_returns(): \core_external\external_single_structure {
        return send_message::execute_returns();
    }
}
