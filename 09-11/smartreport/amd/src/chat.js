// This file is part of Moodle - http://moodle.org/
// Licensed under the GNU GPL v3 or later.
/**
 * Conversation with the server-side AI gateway.
 * @module local_smartreport/chat
 * @copyright 2026 Vitor Gabriel Firmino
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['core/ajax'], function(Ajax) {
    'use strict';
    return {
        init: function() {
            var root = document.querySelector('[data-region="smartreport-chat"]');
            if (!root || root.dataset.initialised) {
                return;
            }
            root.dataset.initialised = 'true';
            var form = root.querySelector('form');
            var input = root.querySelector('textarea');
            var button = form.querySelector('button[type="submit"]');
            var reset = root.querySelector('[data-action="new-query"]');
            var messages = root.querySelector('[data-region="messages"]');
            var status = root.querySelector('[data-region="status"]');
            var errors = root.querySelector('[data-region="error"]');
            var history = [];
            var busy = false;
            var generation = 0;
            reset.disabled = false;
            input.disabled = false;
            var update = function() {
                button.disabled = busy || input.value.trim().length === 0;
                input.disabled = busy;
                form.setAttribute('aria-busy', String(busy));
            };
            var append = function(type, text) {
                var fragment = root.querySelector('[data-region="' + type + '-template"]').content.cloneNode(true);
                fragment.querySelector('.smartreport-bubble').textContent = text;
                var element = fragment.firstElementChild;
                messages.appendChild(fragment);
                messages.scrollTop = messages.scrollHeight;
                return element;
            };
            input.addEventListener('input', update);
            var reportTable = function(element, report) {
                var wrapper = document.createElement('div');
                wrapper.className = 'smartreport-table-wrap';
                wrapper.tabIndex = 0;
                wrapper.setAttribute('role', 'region');
                wrapper.setAttribute('aria-label', report.title);
                var table = document.createElement('table');
                table.className = 'smartreport-results-table';
                var caption = table.createCaption();
                caption.textContent = report.title;
                caption.className = 'smartreport-visually-hidden';
                var head = table.createTHead().insertRow();
                report.headers.forEach(function(label) {
                    var cell = document.createElement('th');
                    cell.scope = 'col';
                    cell.textContent = label;
                    head.appendChild(cell);
                });
                var body = table.createTBody();
                report.rows.forEach(function(row) {
                    var tr = body.insertRow();
                    row.forEach(function(value) { tr.insertCell().textContent = value; });
                });
                wrapper.appendChild(table);
                element.appendChild(wrapper);
                if (report.hasmore) {
                    var hint = document.createElement('p');
                    hint.textContent = root.dataset.more;
                    element.appendChild(hint);
                }
            };
            reset.addEventListener('click', function() {
                // Invalidate callbacks from an older request, even if it is still running on the server.
                generation++;
                history = [];
                busy = false;
                messages.replaceChildren();
                root.classList.remove('has-conversation');
                input.value = '';
                errors.textContent = '';
                status.textContent = root.dataset.reset;
                update();
                input.focus();
            });
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                var value = input.value.trim();
                if (busy || !value || value.length > 4000) {
                    return;
                }
                // Retain complete turns only, within the server's context budget.
                var context = history.slice(-10);
                while (context.length && context.reduce(function(sum, item) {
                    return sum + Array.from(item.content).length;
                }, Array.from(value).length) > 24000) {
                    context.splice(0, 2);
                }
                busy = true;
                var requestGeneration = generation;
                root.classList.add('has-conversation');
                errors.textContent = '';
                status.textContent = root.dataset.waiting;
                update();
                var user = append('user', value);
                Promise.resolve().then(function() {
                    if (requestGeneration !== generation) {
                        return null;
                    }
                    return Ajax.call([{methodname: 'local_smartreport_send_message',
                        args: {message: value, history: context}}])[0];
                }).then(function(result) {
                    if (requestGeneration !== generation) {
                        return;
                    }
                    if (!result || typeof result.reply !== 'string' || !result.reply.trim()) {
                        throw new Error('Invalid response');
                    }
                    var report = result.report ? JSON.parse(result.report) : null;
                    var answer = append('reply', result.reply);
                    if (report) {
                        reportTable(answer, report);
                    }
                    history = context.concat([{role: 'user', content: value},
                        {role: 'assistant', content: result.context || result.reply}]);
                    input.value = '';
                }).catch(function(error) {
                    if (requestGeneration !== generation) {
                        return;
                    }
                    // The original draft stays available for an explicit retry (no duplicate charge retries).
                    user.remove();
                    root.classList.toggle('has-conversation', messages.children.length > 0);
                    var known = ['ainotconfigured', 'invalidmessage', 'aiautherror', 'airatelimit',
                        'aiprovidererror', 'aiinvalidresponse', 'aiconnectionerror', 'aiproxydns',
                        'aidnserror', 'aiconnectfailed', 'aitimeout', 'aitlserror',
                        'aicertificateerror', 'airequestblocked', 'invalidtool', 'courserequired', 'reportfailed'];
                    errors.textContent = error && known.indexOf(error.errorcode) !== -1 && error.message ?
                        error.message : root.dataset.error;
                }).then(function() {
                    if (requestGeneration !== generation) {
                        return;
                    }
                    busy = false;
                    status.textContent = '';
                    update();
                    input.focus();
                });
            });
            input.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' && !event.shiftKey && !event.isComposing) {
                    event.preventDefault();
                    if (!button.disabled) {
                        form.requestSubmit();
                    }
                }
            });
            update();
        }
    };
});
