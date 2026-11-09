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
$string['apikeydesc'] = 'Deixe em branco para manter a chave salva. OpenAI e Gemini exigem uma chave do provedor selecionado. Ao trocar de provedor, substitua ou remova a chave anterior.';
$string['clearkey'] = 'Remover chave de API salva';
$string['localurl'] = 'URL de consulta';
$string['localurldesc'] = 'Para Local (Llama), informe a URL completa da API de chat do Ollama, por exemplo http://localhost:11434/api/chat. O endereço é acessado pelo servidor Moodle.';
$string['models'] = 'Modelos';
$string['modelsdesc'] = 'Informe modelos separados por vírgula. Nesta versão, o primeiro modelo será usado nas conversas; ele deve estar disponível na sua conta ou servidor local.';
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
$string['privacy:metadata'] = 'O plugin não mantém um histórico persistente. Mensagens e contexto são enviados ao provedor de IA configurado.';
$string['smartreport:view'] = 'Visualizar o SmartReport';
$string['listicon'] = '☷';
$string['aiconnection'] = 'Conexão com a IA';
$string['appearance'] = 'Interface e resultados';
$string['perpagedesc'] = 'Informe de 1 a 200 registros por página de resultados.';
$string['invalidchatname'] = 'Informe um nome de chat com 1 a 100 caracteres.';
$string['conflictingkey'] = 'Para substituir a chave, desmarque a opção de remover a chave salva.';
$string['newquery'] = 'Nova consulta';
$string['chatnotice'] = 'A IA interpreta sua pergunta e seleciona ferramentas de leitura. O Moodle consulta seus registros atuais e exibe os resultados aqui. Nomes de participantes ficam na tabela local e não são incluídos automaticamente no contexto enviado à IA. Perguntas e resumos de consultas são enviados ao provedor; ele pode manter dados conforme sua política.';
$string['conversation'] = 'Conversa da nova consulta';
$string['chatwelcome'] = 'Olá! Posso ajudar a formular consultas e entender indicadores do Moodle. Ainda não tenho acesso aos dados do seu site. Como posso ajudar?';
$string['yourmessage'] = 'Sua mensagem';
$string['messageplaceholder'] = 'Ex.: Quantos alunos acessaram o curso nesta semana?';
$string['chathelp'] = 'Enter para enviar · Shift + Enter para nova linha · Até 4.000 caracteres';
$string['sendmessage'] = 'Enviar mensagem';
$string['chatscriptrequired'] = 'Ative o JavaScript para experimentar a interface de conversa.';
$string['you'] = 'Você';
$string['chatreply'] = 'Sua mensagem foi adicionada à prévia da conversa. Nenhuma consulta foi executada: as respostas da IA e os relatórios estarão disponíveis em uma próxima etapa.';

$string['aiwaiting'] = 'A IA está preparando a resposta…';
$string['aierror'] = 'Não foi possível enviar a mensagem. Verifique sua conexão e sessão no Moodle e tente novamente. Sua mensagem foi preservada.';
$string['ainotconfigured'] = 'Configure o provedor, o primeiro modelo e a chave de API (ou a URL do Ollama local) nas configurações do SmartReport.';
$string['invalidmessage'] = 'A mensagem deve ter de 1 a 4.000 caracteres, com até 10 mensagens anteriores e 24.000 caracteres de contexto.';
$string['aiautherror'] = 'O provedor recusou a autenticação. Confira a chave de API e o acesso ao modelo nas configurações.';
$string['airatelimit'] = 'Aguarde alguns instantes antes de tentar novamente. Se persistir, confira a cota e os limites da sua conta no provedor.';
$string['aiprovidererror'] = 'O provedor não concluiu a solicitação. Confira o modelo configurado e a disponibilidade do serviço antes de tentar novamente.';
$string['aiinvalidresponse'] = 'O provedor não retornou uma resposta de texto completa e válida. Tente reformular a pergunta.';
$string['aiconnectionerror'] = 'Falha de transporte ao acessar o provedor (código cURL {$a}). Informe esse código ao responsável pelo servidor Moodle.';
$string['privacy:metadata:aiprovider'] = 'O provedor de IA configurado recebe as mensagens e o contexto para gerar respostas.';
$string['privacy:metadata:aiprovider:messages'] = 'Perguntas, mensagens recentes e metadados resumidos das consultas (ferramenta, parâmetros e total). As linhas de participantes são exibidas localmente e não são incluídas automaticamente no contexto.';
$string['invalidapikey'] = 'A chave não pode conter quebras de linha e deve ter até 1.024 caracteres.';
$string['providerkeychange'] = 'Ao trocar de provedor, informe a nova chave ou marque a remoção da chave anterior.';

$string['aiproxydns'] = 'O servidor Moodle não conseguiu localizar o proxy configurado (cURL {$a}). Confira o endereço e o DNS do proxy nas configurações HTTP do Moodle.';
$string['aidnserror'] = 'O servidor Moodle não conseguiu resolver o endereço do provedor (cURL {$a}). Verifique o DNS do servidor; para Gemini, o domínio é generativelanguage.googleapis.com.';
$string['aiconnectfailed'] = 'O servidor Moodle não conseguiu abrir a conexão com o provedor ou proxy (cURL {$a}). Verifique firewall, proxy e acesso de saída HTTPS na porta 443. Para Ollama, confira a porta configurada.';
$string['aitimeout'] = 'A conexão ou a resposta excedeu o tempo limite (cURL {$a}): até 10 segundos para conectar e 60 segundos no total. Verifique a rede e a disponibilidade do provedor.';
$string['aitlserror'] = 'Falha na negociação HTTPS/TLS com o provedor (cURL {$a}). Verifique a versão do cURL/OpenSSL e eventual proxy que inspeciona HTTPS no servidor Moodle.';
$string['aicertificateerror'] = 'Falha de certificado HTTPS (cURL {$a}). Verifique os certificados de confiança e o arquivo curl.cainfo do PHP usado pelo servidor Moodle. Não desative a verificação SSL.';
$string['airequestblocked'] = 'O Moodle não iniciou a conexão com o provedor. Verifique os registros de bloqueio de URL e as restrições de segurança HTTP do Moodle, incluindo domínio e porta.';
$string['querysubtitle'] = 'Consulte indicadores do Moodle';
$string['send'] = 'Enviar';
$string['yourquestion'] = 'Sua pergunta';
$string['chatreset'] = 'Nova consulta iniciada. A conversa anterior foi apagada.';
$string['aboutai'] = 'Sobre o uso da IA';

$string['invalidtool'] = 'Não foi possível interpretar a consulta com as ferramentas disponíveis. Informe o indicador, o ID do curso e o período em dias; não envie SQL.';
$string['courserequired'] = 'Informe o ID de um curso válido. Você pode pedir para buscar cursos pelo nome.';
$string['reportfailed'] = 'Não foi possível consultar os indicadores no banco do Moodle. Peça ao administrador para verificar a compatibilidade da instalação.';
$string['indicator'] = 'Indicador';
$string['value'] = 'Valor';
$string['tool_site_summary'] = 'Indicadores atuais do ambiente';
$string['tool_find_courses'] = 'Cursos encontrados';
$string['tool_list_roles'] = 'Papéis disponíveis';
$string['tool_course_summary'] = 'Indicadores do curso';
$string['tool_inactive_users'] = 'Participantes sem acesso ao curso';
$string['visiblecourses'] = 'Cursos visíveis (exceto página inicial)';
$string['activeaccounts'] = 'Contas não excluídas e não suspensas (exceto visitante)';
$string['recentaccounts'] = 'Contas com acesso ao site nos últimos {$a} dias';
$string['sitenote'] = 'Acesso ao site usa o último acesso registrado. Contas não equivalem a matrículas; cada usuário é contado uma vez.';
$string['visible'] = 'Visível';
$string['choosecourse'] = 'Informe o ID exato do curso para consultar seus indicadores. A busca inclui cursos ocultos, disponíveis ao administrador.';
$string['archetype'] = 'Arquétipo';
$string['rolesnote'] = 'Use o ID do papel para filtrar participantes. Papéis personalizados, como mediador, devem ser identificados nesta lista. Exibidos até 200 papéis.';
$string['activeparticipants'] = 'Participantes com matrícula ativa';
$string['recentparticipants'] = 'Participantes ativos com acesso ao curso nos últimos {$a} dias';
$string['completedparticipants'] = 'Participantes ativos com conclusão registrada';
$string['completiondisabled'] = 'Acompanhamento de conclusão desativado';
$string['coursenote'] = 'Cada participante é contado uma vez, mesmo com várias matrículas. Exclui contas suspensas/excluídas e matrículas suspensas, futuras ou expiradas. Conclusões dependem do processamento do Moodle.';
$string['lastcourseaccess'] = 'Último acesso ao curso';
$string['dayswithoutaccess'] = 'Dias sem acesso';
$string['neveraccessed'] = 'Sem acesso registrado';
$string['inactivenote'] = 'Critério: mais de {$a} dias sem acesso registrado ao curso, com matrícula ativa iniciada antes desse prazo. Sem acesso registrado, os dias são contados desde a matrícula ativa mais antiga.';
$string['rolefilter'] = 'Filtro de papel: ID {$a}, no curso ou em contextos superiores.';
$string['allroles'] = 'Todos os papéis; esta lista não se limita a alunos.';
$string['reportcount'] = 'Exibindo {$a->shown} de {$a->total} registros.';
$string['reporttime'] = 'Consultado em: {$a}. Fonte: banco de dados do Moodle.';
$string['reportmore'] = 'Há mais resultados. Peça a próxima página informando o mesmo curso, período e papel, quando aplicável.';
$string['refreshindicators'] = 'Atualizar indicadores do ambiente';
$string['livehelp'] = 'Consulta direta ao Moodle, sem depender da IA.';
