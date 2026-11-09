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
$string['open'] = 'Abrir SmartReport';
$string['settings'] = 'Configurações do SmartReport';
$string['adminonly'] = 'O SmartReport é restrito aos administradores do site.';
$string['subtitle'] = 'Consulte indicadores do Moodle com rapidez e clareza.';
$string['new'] = 'Novo';
$string['newdesc'] = 'Inicie uma nova consulta';
$string['popular'] = 'Populares';
$string['populardesc'] = 'Acesse perguntas frequentes';
$string['terms'] = 'Termos de uso';
$string['termsdesc'] = 'Veja regras e orientações';
$string['back'] = '← Voltar';
$string['configuration'] = 'Configuração';
$string['configurationdesc'] = 'Defina o provedor e os modelos usados pelo SmartReport.';
$string['provider'] = 'Provedor de IA';
$string['providerdesc'] = 'Selecione o provedor: OpenAI, Google Gemini ou Local (Llama).';
$string['apikey'] = 'Chave de API (API Key)';
$string['apikeydesc'] = 'Deixe em branco para manter a chave salva. Informe uma nova chave para substituí-la.';
$string['clearkey'] = 'Remover chave de API salva';
$string['localurl'] = 'URL de consulta';
$string['localurldesc'] = 'Informe a URL de consulta quando o provedor selecionado for Local (Llama).';
$string['models'] = 'Modelos';
$string['modelsdesc'] = 'Informe um ou mais modelos separados por vírgula.';
$string['chatname'] = 'Nome do chat exibido aos usuários';
$string['perpage'] = 'Registros por página';
$string['termscontent'] = 'Conteúdo dos termos de uso';
$string['termscontentdesc'] = 'Texto a ser fornecido e aprovado pelo cliente. Deixe vazio enquanto estiver pendente.';
$string['termspending'] = 'O conteúdo dos termos de uso aguarda fornecimento e aprovação pelo cliente.';
$string['newpending'] = 'A interface de nova consulta será disponibilizada na sprint 2.';
$string['popularpending'] = 'O catálogo de relatórios populares será disponibilizado na sprint 6.';
$string['saved'] = 'Configurações salvas.';
$string['invalidurl'] = 'Informe uma URL HTTP ou HTTPS válida, sem credenciais.';
$string['invalidmodels'] = 'Informe modelos separados por vírgula, sem itens vazios (máximo de 100 caracteres por modelo).';
$string['invalidperpage'] = 'Informe um número inteiro entre 1 e 200.';
$string['invalidprovider'] = 'Selecione um provedor válido.';
$string['privacy:metadata'] = 'O SmartReport não armazena dados pessoais nesta sprint. As configurações são globais; nenhum dado é enviado a provedores de IA.';
$string['smartreport:view'] = 'Visualizar o SmartReport';
$string['listicon'] = '☷';
