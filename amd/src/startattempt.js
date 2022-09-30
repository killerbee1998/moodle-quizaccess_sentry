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
// You should have recZeived a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @module quizaccess_sentry/startattempt
 * @copyright 2022, Riasat Mahbub <riasat.mahbub@brainstation-23.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import Ajax from 'core/ajax';

const log_sus_event = (event_type, userid, timecaught) => {
    let wsfunction = 'quizaccess_sentry_log_sus_event';
    let params = {
        'event_type': event_type,
        'userid': userid,
        'timecaught': timecaught
    };

    let request = {
        methodname: wsfunction,
        args: params
    };

    Ajax.call([request])[0].done(function () {
    }).fail(Notification.exception);
};

export const setup = (props) => {

    window.addEventListener("visibilitychange", () => {
        if (document.hidden) {
            log_sus_event('Tab switched', props, Date.now());
        }
    });

    window.addEventListener('resize', () => {
        log_sus_event('Resized', props, Date.now());
    });

    window.addEventListener('keydown', (event) => {
        if (event.key === "F12") {
            log_sus_event('Pressed F12', props, Date.now());
        }
    });

    window.addEventListener('copy', (event) => {
        log_sus_event('Copied Text', props, Date.now());
        event.preventDefault();
    });

};