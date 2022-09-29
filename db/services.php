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

$functions = array(
    'quizaccess_sentry_log_sus_event' => array(
        'classname'   => 'quizaccess_sentry_external',
        'methodname'  => 'log_sus_event',
        'classpath'   => 'mod/quiz/accessrule/sentry/external.php',
        'description' => 'Log suspicious events',
        'type'        => 'write',
        'ajax'        => true
    ),
);

$services = array(
    'quizaccess_sentry' => array(
        'functions' => array(
            'quizaccess_sentry_log_sus_event'
        ),
        'restrictedusers' => 0,
        'enabled' => 1,
        'shortname' => 'quizaccess_sentry'
    )
);