# SmartReport

Plugin local do Moodle para apresentar uma interface inicial de consultas e
relatórios sobre indicadores da plataforma.

> **Status:** versão `0.1.1`. Esta versão entrega a
> estrutura inicial da interface e da configuração; a execução de novas
> consultas e o catálogo de relatórios populares ainda estão planejados para
> sprints futuras.

## Requisitos

- Moodle 4.4 ou posterior.
- Permissão de administrador do site para acessar o SmartReport e suas
  configurações.
- PHP e banco de dados compatíveis com a versão do Moodle instalada.

## Instalação

1. Copie a pasta `smartreport` deste pacote para o diretório `local` da
   instalação do Moodle:

   ```text
   <moodle>/local/smartreport
   ```

2. Acesse o Moodle como administrador do site.
3. Abra **Administração do site > Notificações** e conclua a instalação ou
   atualização do plugin.
4. Acesse **Administração do site > Relatórios > SmartReport**.

O componente do plugin é `local_smartreport`.

## Acesso

O plugin registra duas páginas no menu **Relatórios**:

- **SmartReport:** página inicial com os cartões de consulta, relatórios
  populares e termos de uso.
- **Configurações do SmartReport:** formulário de configuração do plugin.

O acesso é limitado a administradores do site. A capability
`local/smartreport:view` existe no contexto do sistema, mas não é atribuída a
arquétipos nesta versão; além disso, o plugin verifica explicitamente se o
usuário é administrador.

## Configuração

Na página **Configurações do SmartReport**, estão disponíveis os seguintes
campos:

| Campo | Descrição |
| --- | --- |
| **Provedor de IA** | Seleciona OpenAI, Google Gemini ou um provedor local baseado em Llama. |
| **Chave de API** | Salva uma chave para uso futuro pelo provedor selecionado. Deixe vazia para manter a chave atual. |
| **Remover chave de API salva** | Remove a chave armazenada nas configurações do Moodle. |
| **URL de consulta** | URL HTTP ou HTTPS do provedor local. É obrigatória quando o provedor Local (Llama) é selecionado e não pode conter credenciais. |
| **Modelos** | Um ou mais modelos separados por vírgula. Cada nome pode ter até 100 caracteres. |
| **Nome do chat exibido aos usuários** | Personaliza o título apresentado na interface. |
| **Registros por página** | Número inteiro entre 1 e 200. |
| **Conteúdo dos termos de uso** | Texto exibido na seção de termos de uso. |

As configurações são globais para o site. A chave de API não é inserida
novamente no HTML do formulário ao editar as configurações.

## Funcionalidades disponíveis

Na versão atual, a página inicial oferece:

- cartão **Novo**, com indicação de que a interface de nova consulta será
  disponibilizada na sprint 2;
- cartão **Populares**, com indicação de que o catálogo de relatórios
  populares será disponibilizado na sprint 6;
- seção **Termos de uso**, que exibe o conteúdo configurado ou uma mensagem
  informando que os termos ainda estão pendentes;
- personalização do nome exibido no cabeçalho;
- layout responsivo e estilos próprios do plugin.

Embora a configuração já contenha opções de provedores, modelos e URL local,
esta versão ainda não envia consultas para provedores de IA. O fluxo de
integração deve ser implementado em uma versão futura.

## Privacidade e segurança

- O plugin não armazena dados pessoais nesta versão.
- Nenhum dado é enviado a provedores de IA na implementação atual.
- As configurações são armazenadas como configurações globais do Moodle.
- O acesso às páginas é protegido por login, capability e verificação de
  administrador do site.
- URLs do provedor local aceitam somente os esquemas `http` e `https` e não
  podem incluir usuário ou senha.
- Valores de modelos e quantidade de registros são validados antes de serem
  salvos.

## Estrutura do pacote

```text
smartreport/
├── classes/
│   ├── access.php                 # Controle de acesso
│   ├── configuration.php          # Validação das configurações
│   ├── form/configuration.php     # Formulário de configuração
│   └── privacy/provider.php       # Declaração de privacidade
├── db/access.php                  # Capability do plugin
├── lang/
│   ├── en/local_smartreport.php   # Strings em inglês
│   └── pt_br/local_smartreport.php # Strings em português do Brasil
├── pix/                           # Ícones da interface
├── templates/home.mustache        # Template da página inicial
├── configure.php                  # Página de configurações
├── index.php                      # Página principal
├── settings.php                   # Itens no menu de administração
├── styles.css                     # Estilos do plugin
└── version.php                    # Metadados e requisitos do plugin
```

## Desenvolvimento

O plugin segue a estrutura padrão de um plugin local do Moodle. Durante o
desenvolvimento:

1. Faça as alterações dentro de `local/smartreport`.
2. Limpe os caches do Moodle em **Administração do site > Desenvolvimento >
   Limpar todos os caches** quando alterar templates, strings ou estilos.
3. Verifique a instalação com o modo de desenvolvimento e os validadores
   padrão do Moodle antes de publicar uma nova versão.

## Licença

Este projeto é distribuído sob a **GNU General Public License, versão 3 ou
posterior (GPL-3.0-or-later)**. Consulte [`smartreport/COPYING.txt`](smartreport/COPYING.txt)
para o texto completo da licença.

