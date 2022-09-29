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


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/accessrule/accessrulebase.php');

class quizaccess_sentry extends quiz_access_rule_base {
    public function is_preflight_check_required($attemptid) {
        return empty($attemptid);
    }

    public function add_preflight_check_form_fields(mod_quiz_preflight_check_form $quizform, MoodleQuickForm $mform, $attemptid) {
        global $PAGE;

        $mform->addElement(
            'header',
            'sentryheader',
            get_string('sentryheader', 'quizaccess_sentry')
        );
        $mform->addElement(
            'static',
            'sentrymessage',
            '',
            get_string('sentrystatement', 'quizaccess_sentry')
        );
        $mform->addElement(
            'checkbox',
            'sentry',
            '',
            get_string('sentrylabel', 'quizaccess_sentry')
        );

        $PAGE->requires->js_call_amd('quizaccess_sentry/startattempt', 'setup', array());
    }

    public function validate_preflight_check($data, $files, $errors, $attemptid) {
        if (empty($data['sentry'])) {
            $errors['sentry'] = get_string('youmustagree', 'quizaccess_sentry');
        }

        return $errors;
    }

    public static function make(quiz $quizobj, $timenow, $canignoretimelimits) {

        if (empty($quizobj->get_quiz()->sentryrequired)) {
            return null;
        }

        return new self($quizobj, $timenow);
    }

    public static function add_settings_form_fields(
        mod_quiz_mod_form $quizform,
        MoodleQuickForm $mform
    ) {
        $mform->addElement(
            'select',
            'sentryrequired',
            get_string('sentryrequired', 'quizaccess_sentry'),
            array(
                0 => get_string('notrequired', 'quizaccess_sentry'),
                1 => get_string('sentryrequiredoption', 'quizaccess_sentry'),
            )
        );
        $mform->addHelpButton(
            'sentryrequired',
            'sentryrequired',
            'quizaccess_sentry'
        );
    }

        /**
     * Information, such as might be shown on the quiz view page, relating to this restriction.
     * There is no obligation to return anything. If it is not appropriate to tell students
     * about this rule, then just return ''.
     * @return mixed a message, or array of messages, explaining the restriction
     *         (may be '' if no message is appropriate).
     */
    public function description() {
        global $PAGE;

        $messages = "<button class='btn btn-primary'> Report </button>";
        $PAGE->requires->js_call_amd('quizaccess_sentry/startattempt', 'setup', array());
        return $messages;
    }

        /**
     * Sets up the attempt (review or summary) page with any special extra
     * properties required by this rule. securewindow rule is an example of where
     * this is used.
     *
     * @param moodle_page $page the page object to initialise.
     */
    public function setup_attempt_page($page) {
        // Do nothing by default.
    }


    /**
     * This is called when the current attempt at the quiz is finished. This is
     * used, for example by the password rule, to clear the flag in the session.
     */
    public function current_attempt_finished() {
        // Do nothing by default.
    }


    public static function save_settings($quiz) {
        global $DB;
        if (empty($quiz->sentryrequired)) {
            $DB->delete_records('quizaccess_sentry', array('quizid' => $quiz->id));
        } else {
            if (!$DB->record_exists('quizaccess_sentry', array('quizid' => $quiz->id))) {
                $record = new stdClass();
                $record->quizid = $quiz->id;
                $record->sentryrequired = 1;
                $DB->insert_record('quizaccess_sentry', $record);
            }
        }
    }

    public static function delete_settings($quiz) {
        global $DB;
        $DB->delete_records('quizaccess_sentry', array('quizid' => $quiz->id));
    }

    public static function get_settings_sql($quizid) {
        return array(
            'sentryrequired',
            'LEFT JOIN {quizaccess_sentry} sentry ON sentry.quizid = quiz.id',
            array()
        );
    }
}
