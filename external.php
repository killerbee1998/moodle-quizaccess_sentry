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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Version information for the quizaccess_sentry plugin.
 *
 * @package   quizaccess_sentry
 * @copyright 2022 Riasat Mahbub <riasat.mahbub@brainstation-23.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->libdir . "/externallib.php");
require_once($CFG->dirroot . "/mod/quiz/accessrule/sentry/log_sus_event.php");


class quizaccess_sentry_external extends external_api {
    
    /**
     * Returns description of method parameters.
     * @return external_function_parameters
     */
    
    public static function log_sus_event_parameters(): external_function_parameters {
        return new external_function_parameters(
            array(
                'event_type' => new external_value(PARAM_TEXT, 'event_type'),
                'userid' => new external_value(PARAM_INT, 'userid'),
                'timecaught' => new external_value(PARAM_INT, 'timecaught')
            )
        );
    }


    /**
     * log sus events to db.
     *
     * @param int $id
     * @return array
     * @throws moodle_exception
     */
    public static function log_sus_event($event_type, $userid, $timecaught): array {
        global $DB;

        $warnings = array();

        quizaccess_sentry_log_sus_event($event_type, $userid, $timecaught);

        return array(
            'event_type' => $event_type,
            'userid' => $userid,
            'timecaught' => $timecaught,
            'warnings' => $warnings
        );

    }


    /**
     * Returns description of method result value.
     * @return external_description
     */
    public static function log_sus_event_returns() {
        return new external_single_structure(
            array(
                'event_type' => new external_value(PARAM_TEXT, 'event_type'),
                'userid' => new external_value(PARAM_INT, 'userid'),
                'timecaught' => new external_value(PARAM_INT, 'timecaught'),
                'warnings' => new external_warnings()
            )
        );
    }
}