# SmartReport 0.2.1 — consultas ao banco do Moodle

Plugin local `local_smartreport`, para Moodle 4.4 ou superior, restrito a administradores
do site. A página fica em Administração do site → Relatórios → SmartReport.

## Instalação e atualização

1. Faça backup da instalação.
2. Extraia `smartreport.zip` em `local/`, obtendo
   `local/smartreport/version.php` (ou `public/local/smartreport`, quando aplicável).
3. Abra Administração do site → Notificações para registrar a atualização e as funções AJAX.
4. Limpe os caches do Moodle.
5. Nas configurações, escolha provedor, chave e modelo.
6. Abra Novo e peça os indicadores do ambiente pelo chat.

Não há nova senha de banco: o plugin usa `$DB`, a conexão já configurada pelo Moodle.
As configurações anteriores são preservadas. Não há tabelas próprias nem migração
entre os componentes antigos `report_smartreport`/`block_smartreport` e o plugin local.

## Ferramentas disponíveis

| Ferramenta | Dados consultados | Parâmetros |
| --- | --- | --- |
| Indicadores do ambiente | Cursos visíveis, contas não suspensas/excluídas, contas com último acesso recente ao site | Dias, padrão 15 |
| Buscar cursos | ID, nome, nome breve e visibilidade; inclui ocultos para o administrador | Nome parcial e página |
| Listar papéis | IDs, nomes, nomes breves e arquétipos dos papéis | Até 200 papéis |
| Indicadores do curso | Participantes com matrícula ativa, acesso recente ao curso e conclusão registrada | ID do curso e dias |
| Participantes sem acesso | ID, nome, último acesso ao curso e dias sem acesso | ID do curso, dias, ID do papel opcional e página |

Exemplos de perguntas:

- “Mostre os indicadores do ambiente nos últimos 7 dias.”
- “Busque cursos com Administração no nome.”
- “Mostre os indicadores do curso ID 7 nos últimos 30 dias.”
- “Liste os papéis disponíveis.”
- “Quais participantes do curso ID 7, com papel ID 5, estão sem acessar há mais de 15 dias?”
- “Mostre a página 2 dos participantes sem acesso do curso ID 7, papel ID 5, há mais de 15 dias.”

Substitua os IDs pelos valores reais exibidos nas consultas. O assistente recebe
instruções para não adivinhar IDs nem equiparar mediadores a professores. Ao informar
somente o nome do curso ou do papel, primeiro consulte a lista e escolha o ID correto.
Sem filtro de papel, a consulta inclui todos os participantes com matrícula ativa,
não apenas alunos. Notas, SQL livre, filtros históricos de semestre e exportação
CSV/PDF ainda não fazem parte das ferramentas desta versão.

## O que significa atualizado

Cada execução lê o banco novamente e informa o horário de consulta no fuso do usuário.
Os indicadores são solicitados pela conversa.
Não há atualização automática contínua nem leitura de eventos em streaming.
O último acesso usa `user.lastaccess` ou `user_lastaccess`, conforme o indicador;
esses registros refletem a atualização realizada pelo próprio Moodle. Conclusões
podem depender do cron e das regras de conclusão do curso.

Contas do site não equivalem a matrículas. Participantes são contados uma única vez,
mesmo com múltiplos métodos de matrícula. As consultas por curso excluem contas
suspensas/excluídas, instâncias de matrícula desativadas e matrículas suspensas,
futuras ou expiradas. Conclusão é contada apenas entre participantes ativos e é
indicada como indisponível quando o acompanhamento do curso está desativado.

Inatividade usa **acesso ao curso**, não ao site. Novos matriculados ainda dentro do
prazo solicitado são excluídos da lista. Para quem nunca acessou, o tempo é contado
desde o início da matrícula ativa mais antiga. Um papel pode estar atribuído no curso
ou em contextos superiores. Sem registros, o total é zero, não uma estimativa da IA.

## Funcionamento da IA e proteção dos dados

O provedor interpreta a pergunta e devolve uma seleção estruturada em JSON. O servidor
valida o nome da ferramenta, os parâmetros e os limites, executa uma consulta fixa
somente de leitura e monta a tabela diretamente com os resultados. É uma seleção de
ferramentas compatível com os três provedores, não execução de SQL produzido pelo modelo.
Uma consulta usa no máximo uma ferramenta; ambiguidades exigem outra pergunta.

As ferramentas usam a API de dados do Moodle e parâmetros SQL separados dos valores.
O código de relatórios não altera nem apaga registros. Isso não transforma a conta de
banco do Moodle em uma conta somente de leitura; a restrição está nas operações
implementadas pelo plugin. Login, administrador, capability e sessão são verificados
no servidor, em todas as consultas.

A IA não recebe credenciais do banco nem acesso direto à rede do banco. Nomes de
participantes e linhas dos resultados ficam na tabela local; não são automaticamente
incluídos no histórico enviado ao provedor. O contexto contém pergunta, mensagens e
resumo da ferramenta/parâmetros/total. Se o usuário digitar dados pessoais na pergunta,
esses dados serão enviados ao provedor conforme a configuração. A Privacy API informa
essa transferência. Não há histórico persistente de conversas no plugin.

## Configuração

- **Provedor:** OpenAI, Google Gemini ou Local/Llama via protocolo Ollama.
- **Chave:** exigida por OpenAI/Gemini; opcional no Ollama com Bearer. Mantida no servidor.
  Campo vazio conserva o valor; remover apaga. Ao trocar de provedor, substitua ou remova a chave antiga.
- **URL local:** endpoint completo, por exemplo `http://localhost:11434/api/chat`.
  O endereço é acessado pelo servidor Moodle; não pelo navegador do administrador.
- **Modelos:** separados por vírgulas; o primeiro será usado. O modelo precisa seguir
  instruções e produzir JSON válido para a seleção de ferramentas.
- **Nome do chat:** personaliza a interface, até 100 caracteres.
- **Registros por página:** de 1 a 200, aplicado à busca de cursos e participantes sem acesso.
- **Termos:** conteúdo fornecido pelo cliente.

OpenAI usa Responses API com `store: false`; Gemini usa `generateContent`; Ollama usa
`/api/chat` sem streaming. Limite de conexão: 10 segundos; chamada completa: 60 segundos.
TLS é verificado, redirecionamentos são desativados e as políticas HTTP/proxy do Moodle
são respeitadas. O diagnóstico distingue DNS, proxy, conexão, certificados e timeout.

## Interface

A engrenagem abre configurações. Enter envia, Shift + Enter insere linha e cada pergunta
aceita até 4.000 caracteres. Até cinco turnos anteriores, limitados a 24.000 caracteres,
são usados como contexto. O botão + apaga conversa e contexto; respostas antigas pendentes
são ignoradas. Uma requisição já enviada ao provedor pode continuar sendo processada.
As tabelas são renderizadas como texto seguro, sem executar HTML recebido.


## Referências

- [Moodle: API de manipulação de dados](https://moodledev.io/docs/4.5/apis/core/dml)
- [Moodle: esquema das tabelas 4.4](https://github.com/moodle/moodle/blob/MOODLE_404_STABLE/lib/db/install.xml)
- [Moodle: funções externas](https://moodledev.io/docs/4.5/apis/subsystems/external/functions)
- [OpenAI: geração de texto](https://developers.openai.com/api/docs/guides/text)
- [Gemini: generateContent](https://ai.google.dev/api/generate-content)
- [Ollama: chat](https://docs.ollama.com/api/chat)

Licença GNU GPL v3 ou posterior. Consulte COPYING.txt.

