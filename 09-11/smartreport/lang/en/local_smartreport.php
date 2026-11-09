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

defined('MOODLE_INTERNAL') || die;
$string['pluginname'] = 'SmartReport';
$string['success'] = 'Funcionou';
$string['open'] = 'Open SmartReport';
$string['settings'] = 'SmartReport settings';
$string['adminonly'] = 'SmartReport is restricted to site administrators.';
$string['subtitle'] = 'Query Moodle indicators quickly and clearly.';
$string['new'] = 'New';
$string['newdesc'] = 'Start a new query';
$string['popular'] = 'Popular';
$string['populardesc'] = 'Access frequent questions';
$string['terms'] = 'Terms of use';
$string['termsdesc'] = 'Read rules and guidance';
$string['back'] = '← Back';
$string['configuration'] = 'Configuration';
$string['configurationdesc'] = 'Set the provider and models used by SmartReport.';
$string['provider'] = 'AI provider';
$string['providerdesc'] = 'Select OpenAI, Google Gemini or Local (Llama).';
$string['apikey'] = 'API key';
$string['apikeydesc'] = 'Leave blank to retain the saved key. OpenAI and Gemini require a key for the selected provider. When switching providers, replace or remove the previous key.';
$string['clearkey'] = 'Remove saved API key';
$string['localurl'] = 'Query URL';
$string['localurldesc'] = 'For Local (Llama), enter the complete Ollama chat API URL, e.g. http://localhost:11434/api/chat. The address is accessed by the Moodle server.';
$string['models'] = 'Models';
$string['modelsdesc'] = 'Enter comma-separated models. This version uses the first model in conversations; it must be available in your account or local server.';
$string['chatname'] = 'Displayed chat name';
$string['perpage'] = 'Records per page';
$string['termscontent'] = 'Terms of use content';
$string['termscontentdesc'] = 'Content supplied and approved by the client. Leave blank while pending.';
$string['termspending'] = 'Terms of use are awaiting client content and approval.';
$string['newpending'] = 'New queries will be available in sprint 2.';
$string['popularpending'] = 'Popular reports will be available in sprint 6.';
$string['saved'] = 'Settings saved.';
$string['invalidurl'] = 'Enter a valid HTTP or HTTPS URL without credentials.';
$string['invalidmodels'] = 'Enter comma-separated models without empty items (100 characters maximum per model).';
$string['invalidperpage'] = 'Enter an integer between 1 and 200.';
$string['invalidprovider'] = 'Select a valid provider.';
$string['privacy:metadata'] = 'The plugin does not keep persistent history. Messages and context are sent to the configured AI provider.';
$string['smartreport:view'] = 'View SmartReport';
$string['listicon'] = '☷';
$string['aiconnection'] = 'AI connection';
$string['appearance'] = 'Interface and results';
$string['perpagedesc'] = 'Enter 1 to 200 records per results page.';
$string['invalidchatname'] = 'Enter a chat name between 1 and 100 characters.';
$string['conflictingkey'] = 'To replace the key, uncheck the option to remove the saved key.';
$string['newquery'] = 'New query';
$string['chatnotice'] = 'AI interprets your question and selects read-only tools. Moodle queries current records and displays results here. Participant names stay in the local table and are not automatically included in AI context. Questions and query summaries are sent to the provider; retention follows its policy.';
$string['conversation'] = 'New query conversation';
$string['chatwelcome'] = 'Hello! I can help formulate queries and explain Moodle indicators. I do not yet have access to your site data. How can I help?';
$string['yourmessage'] = 'Your message';
$string['messageplaceholder'] = 'E.g. How many students accessed the course this week?';
$string['chathelp'] = 'Enter to send · Shift + Enter for a new line · Up to 4,000 characters';
$string['sendmessage'] = 'Send message';
$string['chatscriptrequired'] = 'Enable JavaScript to try the conversation interface.';
$string['you'] = 'You';
$string['chatreply'] = 'Your message was added to the conversation preview. No query was run: AI responses and reports will be available in a future stage.';

$string['aiwaiting'] = 'AI is preparing a response…';
$string['aierror'] = 'Could not send the message. Check your connection and Moodle session, then try again. Your message has been preserved.';
$string['ainotconfigured'] = 'Set the provider, first model and API key (or local Ollama URL) in SmartReport settings.';
$string['invalidmessage'] = 'The message must contain 1 to 4,000 characters, with up to 10 previous messages and 24,000 context characters.';
$string['aiautherror'] = 'The provider rejected authentication. Check the API key and model access in settings.';
$string['airatelimit'] = 'Wait a few moments before trying again. If this persists, check your provider account quota and limits.';
$string['aiprovidererror'] = 'The provider could not complete the request. Check the configured model and service availability before trying again.';
$string['aiinvalidresponse'] = 'The provider did not return a complete, valid text response. Try rephrasing the question.';
$string['aiconnectionerror'] = 'Transport failure contacting the provider (cURL code {$a}). Report this code to the Moodle server administrator.';
$string['privacy:metadata:aiprovider'] = 'The configured AI provider receives messages and context to generate responses.';
$string['privacy:metadata:aiprovider:messages'] = 'Questions, recent messages and query summary metadata (tool, parameters and total). Participant rows are displayed locally and are not automatically included in context.';
$string['invalidapikey'] = 'The key must not contain line breaks and must be at most 1,024 characters.';
$string['providerkeychange'] = 'When switching providers, enter a new key or select removal of the previous key.';

$string['aiproxydns'] = 'Moodle could not resolve its configured proxy (cURL {$a}). Check the proxy address and DNS in Moodle HTTP settings.';
$string['aidnserror'] = 'Moodle could not resolve the provider hostname (cURL {$a}). Check server DNS; for Gemini, the domain is generativelanguage.googleapis.com.';
$string['aiconnectfailed'] = 'Moodle could not connect to the provider or proxy (cURL {$a}). Check firewall, proxy and outbound HTTPS port 443. For Ollama, check its configured port.';
$string['aitimeout'] = 'Connection or response timed out (cURL {$a}): up to 10 seconds to connect and 60 seconds overall. Check network and provider availability.';
$string['aitlserror'] = 'HTTPS/TLS negotiation with the provider failed (cURL {$a}). Check server cURL/OpenSSL versions and any HTTPS inspection proxy.';
$string['aicertificateerror'] = 'HTTPS certificate failure (cURL {$a}). Check trusted certificates and curl.cainfo in the PHP configuration used by the Moodle server. Do not disable SSL verification.';
$string['airequestblocked'] = 'Moodle did not start the provider connection. Check URL blocking events and Moodle HTTP security restrictions, including hostname and port.';
$string['querysubtitle'] = 'Explore Moodle indicators';
$string['send'] = 'Send';
$string['yourquestion'] = 'Your question';
$string['chatreset'] = 'New query started. The previous conversation was cleared.';
$string['aboutai'] = 'About AI usage';

$string['invalidtool'] = 'Could not interpret the query using available tools. Provide the indicator, course ID and period in days; do not send SQL.';
$string['courserequired'] = 'Provide a valid course ID. You can ask to find courses by name.';
$string['reportfailed'] = 'Could not query Moodle database indicators. Ask the administrator to check installation compatibility.';
$string['indicator'] = 'Indicator';
$string['value'] = 'Value';
$string['tool_site_summary'] = 'Current site indicators';
$string['tool_find_courses'] = 'Matching courses';
$string['tool_list_roles'] = 'Available roles';
$string['tool_course_summary'] = 'Course indicators';
$string['tool_inactive_users'] = 'Participants without course access';
$string['visiblecourses'] = 'Visible courses (excluding site home)';
$string['activeaccounts'] = 'Non-deleted, non-suspended accounts (excluding guest)';
$string['recentaccounts'] = 'Accounts accessing the site in the last {$a} days';
$string['sitenote'] = 'Site access uses the last recorded access. Accounts are not enrolments; each user is counted once.';
$string['visible'] = 'Visible';
$string['choosecourse'] = 'Provide the exact course ID to query its indicators. Search includes hidden courses available to administrators.';
$string['archetype'] = 'Archetype';
$string['rolesnote'] = 'Use the role ID to filter participants. Custom roles such as mediator must be identified in this list. Up to 200 roles are displayed.';
$string['activeparticipants'] = 'Actively enrolled participants';
$string['recentparticipants'] = 'Active participants accessing the course in the last {$a} days';
$string['completedparticipants'] = 'Active participants with recorded course completion';
$string['completiondisabled'] = 'Completion tracking disabled';
$string['coursenote'] = 'Each participant is counted once, even with multiple enrolments. Excludes suspended/deleted accounts and suspended, future or expired enrolments. Completions depend on Moodle processing.';
$string['lastcourseaccess'] = 'Last course access';
$string['dayswithoutaccess'] = 'Days without access';
$string['neveraccessed'] = 'No recorded access';
$string['inactivenote'] = 'Criterion: more than {$a} days without recorded course access, with active enrolment starting before that threshold. Without recorded access, days are counted from the oldest active enrolment.';
$string['rolefilter'] = 'Role filter: ID {$a}, in course or parent contexts.';
$string['allroles'] = 'All roles; this list is not limited to students.';
$string['reportcount'] = 'Showing {$a->shown} of {$a->total} records.';
$string['reporttime'] = 'Queried at: {$a}. Source: Moodle database.';
$string['reportmore'] = 'More results are available. Request the next page with the same course, period and role where applicable.';
$string['refreshindicators'] = 'Refresh site indicators';
$string['livehelp'] = 'Queries Moodle directly, without requiring AI.';
