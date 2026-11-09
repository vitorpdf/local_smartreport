<?php
// This file is part of Moodle - http://moodle.org/
// Licensed under the GNU GPL v3 or later.
namespace local_smartreport\external;
defined('MOODLE_INTERNAL') || die;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_multiple_structure;
use core_external\external_single_structure;
use core_external\external_value;

/** AJAX entry point, restricted to site administrators. */
final class send_message extends external_api {
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'message' => new external_value(PARAM_RAW, 'New message, at most 4000 characters'),
            'history' => new external_multiple_structure(new external_single_structure([
                'role' => new external_value(PARAM_ALPHA, 'user or assistant'),
                'content' => new external_value(PARAM_RAW, 'Message text'),
            ])),
        ]);
    }

    public static function execute(string $message, array $history): array {
        global $SESSION;
        self::validate_context(\context_system::instance());
        \local_smartreport\access::require_admin();
        require_sesskey();
        $params = self::validate_parameters(self::execute_parameters(), ['message' => $message, 'history' => $history]);
        \local_smartreport\ai_client::messages($params['message'], $params['history']);
        // Session locking serialises requests; never store conversation text in the session.
        if (time() - ($SESSION->local_smartreport_lastrequest ?? 0) < 3) {
            throw new \moodle_exception('airatelimit', 'local_smartreport');
        }
        $SESSION->local_smartreport_lastrequest = time();
        return \local_smartreport\report_assistant::answer($params['message'], $params['history']);
    }

    public static function execute_returns(): external_single_structure {
        return new external_single_structure([
            'reply' => new external_value(PARAM_RAW, 'Assistant answer'),
            'report' => new external_value(PARAM_RAW, 'Local report JSON, not sent to the provider'),
            'context' => new external_value(PARAM_RAW, 'Conversation context without participant rows'),
        ]);
    }
}
