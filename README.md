# SmartReport

**Relatórios pedagógicos e administrativos no Moodle por meio de linguagem natural.**

O **SmartReport** é um plugin em desenvolvimento que utiliza Inteligência Artificial Generativa (IAGen) para facilitar a consulta de dados e a geração de relatórios no Moodle. Sua proposta é permitir que informações do ambiente virtual de aprendizagem sejam obtidas por meio de perguntas, apoiando o acompanhamento dos cursos e a tomada de decisões na gestão educacional.

O projeto integra a proposta da **Plataforma SmartEdu**, apresentada no contexto do INOV@ÇÃO UFLA, da Universidade Federal de Lavras. Este repositório concentra o desenvolvimento do **SmartReport**, componente dedicado aos relatórios pedagógicos e administrativos.

## Por que desenvolver o SmartReport?

Os dados registrados em um ambiente virtual de aprendizagem podem apoiar o acompanhamento das turmas, a identificação de participantes sem acesso e o planejamento de ações pedagógicas e administrativas. Para que sejam úteis no cotidiano, é necessário oferecer formas simples de consultar e compreender essas informações.

O SmartReport busca aproximar as perguntas das equipes educacionais dos dados disponíveis no Moodle. Com uma interface de conversa, a proposta é reduzir a necessidade de conhecimento técnico para realizar consultas e tornar os indicadores mais acessíveis à gestão.

## Objetivo

Desenvolver um plugin integrado ao Moodle para consultar e apresentar informações pedagógicas e administrativas em linguagem natural, com apoio de IA generativa e possibilidade de integração à infraestrutura institucional de IA.

Seus objetivos são:

- Facilitar o acesso às informações dos cursos e do ambiente virtual.
- Apoiar o acompanhamento da participação e da conclusão de cursos.
- Simplificar consultas recorrentes utilizadas na gestão educacional.
- Oferecer informações para orientar decisões e ações de acompanhamento.
- Permitir o uso de IA local, em alinhamento com a proposta de autonomia tecnológica e controle institucional dos dados.

## Público e aplicação

O SmartReport é voltado ao apoio às equipes responsáveis pela administração do Moodle, pela gestão acadêmica e pelo acompanhamento pedagógico dos cursos. Os relatórios podem subsidiar o trabalho de gestores, coordenações e equipes educacionais.

**Na implementação atual, o uso do plugin é restrito aos administradores do site.** O público beneficiado pelas informações é mais amplo que o conjunto de usuários autorizados a consultar diretamente a ferramenta.

Um exemplo de aplicação é identificar participantes que estão sem acessar determinado curso há mais de 15 dias. A equipe responsável pode utilizar essa informação para avaliar a necessidade de acompanhamento e planejar ações de contato, considerando o contexto de cada turma.

## Como funciona

1. **Pergunta:** o administrador informa o que deseja consultar na interface de conversa.
2. **Interpretação:** o modelo de IA identifica a ferramenta disponível e os parâmetros correspondentes ao pedido.
3. **Consulta:** o SmartReport valida a solicitação e busca os dados no Moodle.
4. **Apresentação:** o resultado é exibido em tabelas e indicadores para análise.

Os registros apresentados são obtidos pelas consultas implementadas no plugin. A IA auxilia na interpretação da pergunta; a consulta ao banco é executada pelo SmartReport por meio da conexão já utilizada pelo Moodle.

## Recursos disponíveis

A versão atual oferece um conjunto inicial de consultas:

| Recurso | Finalidade |
| --- | --- |
| Indicadores do ambiente | Consultar cursos visíveis, contas não suspensas ou excluídas e acessos recentes ao site. |
| Busca de cursos | Localizar cursos pelo nome e consultar seus identificadores e sua visibilidade. |
| Consulta de papéis | Identificar os papéis cadastrados no Moodle para orientar filtros nas consultas. |
| Indicadores por curso | Acompanhar participantes com matrícula ativa, acesso recente e conclusão registrada. |
| Participantes sem acesso | Identificar participantes sem acesso ao curso no período informado, com filtro opcional por papel. |

Também é possível atualizar os indicadores gerais por um botão de consulta direta, sem utilizar IA.

### Exemplos de perguntas

- “Mostre os indicadores do ambiente nos últimos 7 dias.”
- “Busque cursos com Administração no nome.”
- “Liste os papéis disponíveis.”
- “Mostre os indicadores do curso ID 7 nos últimos 30 dias.”
- “Quais participantes do curso ID 7, com papel ID 5, estão sem acessar há mais de 15 dias?”

Os identificadores devem corresponder aos cursos e papéis existentes na instalação. A busca de cursos e a consulta de papéis permitem encontrar esses valores.

Os resultados devem ser interpretados conforme o indicador: acesso ao curso é diferente de acesso ao site; participantes com matrícula ativa não representam apenas alunos quando não há filtro de papel; e os dados de conclusão dependem das configurações e dos registros do Moodle.

## Inteligência artificial e dados institucionais

A proposta institucional prevê o uso de **IAGen local**, com o objetivo de ampliar a autonomia tecnológica e o controle sobre os dados. O SmartReport já oferece integração com **Ollama**, além das opções **OpenAI** e **Google Gemini**.

A compatibilidade com Ollama permite conectar o plugin a um serviço local configurado pela instituição. A implantação da infraestrutura institucional de IA é uma frente própria da proposta mais ampla da SmartEdu; não é realizada automaticamente pela instalação do SmartReport.

Na implementação atual:

- As ferramentas de relatório fazem consultas predefinidas de leitura, sem alterar ou excluir os registros consultados.
- O modelo não recebe as credenciais do banco nem executa consultas SQL livres.
- Perguntas, mensagens de contexto e resumos das consultas são enviados ao provedor configurado.
- Nomes de participantes e linhas dos resultados não são automaticamente incluídos no histórico enviado ao modelo. Dados pessoais digitados na pergunta acompanham a solicitação.
- O plugin não mantém histórico persistente de conversas.

## Licença

O código está disponibilizado sob a [GNU GPL v3 ou posterior](smartreport/COPYING.txt).
