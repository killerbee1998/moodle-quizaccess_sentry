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
require_once(__DIR__ . '/../../../../config.php');

global $OUTPUT;
global $DB;

$PAGE->set_url(new moodle_url('/mod/quiz/accessrule/sentry/report.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('report', 'quizaccess_sentry'));

echo $OUTPUT->header();

$templatecontext = (object)[
];

$quizid = required_param('quizid', PARAM_INT);

$records = $DB->get_records('sus_events', array('quizid' => $quizid));

echo "<h1> Report of Violations</h1>";

echo "<table class='table table-bordered'>";

echo "<tr >";
echo "<tr> <th scope='col'> USER ID </th> <th scope='col'> SUSPICIOUS EVENT </th> <th scope='col'> TIME CAUGHT</th> </tr>";
echo "</tr>";

foreach($records as $record){
    echo "<tr >";
    echo "<th scope='row'>" . $record->userid. "</th>";
    echo "<td >" . $record->event_type. "</td>";
    echo "<td >" . gmdate("F j, Y, g:i a", $record->timecaught/1000). "</td>";
    echo "</tr>";
}
echo "</table>";

echo $OUTPUT->footer();
