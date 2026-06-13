# Series List (CakePHP 5)

Aplicação de exemplo em [CakePHP 5](https://cakephp.org) para gerenciar uma lista
de séries, gêneros e usuários. Usa **SQLite** como banco de dados.

## Requisitos

- PHP **>= 8.2** (com as extensões `mbstring`, `intl` e `pdo_sqlite` habilitadas)
- [Composer](https://getcomposer.org/)
- Um ambiente de desenvolvimento web. Qualquer um serve:
  - [Laravel Herd](https://herd.laravel.com/) / Valet — serve em `http://<pasta>.test`
  - Servidor embutido do CakePHP — `bin/cake server` em `http://localhost:8765`

## Instalação

```bash
# 1. Clone o repositório
git clone <url-do-repo> series-list-cakephp
cd series-list-cakephp

# 2. Instale as dependências
composer install

# 3. Crie o seu arquivo de ambiente a partir do exemplo
cp config/.env.example config/.env
```

### Configurando o `config/.env`

O arquivo `config/.env` é **git-ignored** (cada pessoa tem o seu) e é carregado
automaticamente pelo `config/bootstrap.php`. Depois de copiá-lo do exemplo,
ajuste os valores para a **sua** máquina:

| Variável | O que fazer |
|----------|-------------|
| `APP_FULL_BASE_URL` | **Deixe vazio** (`""`) em desenvolvimento. O CakePHP detecta o host automaticamente a partir da requisição, então funciona em qualquer domínio/porta local. Veja a observação abaixo. |
| `SECURITY_SALT` | Gere um valor próprio com `bin/cake security generate_salt` e cole aqui. |
| `DATABASE_URL` | Troque pelo **caminho absoluto** do projeto na sua máquina, apontando para `data/app.sqlite`. |
| `DATABASE_TEST_URL` | Caminho absoluto para o banco de testes (`tmp/tests.sqlite`). |

Exemplo de `DATABASE_URL` no Windows:

```bash
export DATABASE_URL="sqlite:///C:/Users/SeuUsuario/projetos/series-list-cakephp/data/app.sqlite"
```

#### Sobre o `APP_FULL_BASE_URL`

Essa variável define o **host base** usado para montar **URLs absolutas**
(redirects, links em e-mails, canonical, etc.). Caminhos relativos — como o
`action` dos formulários — **não** dependem dela.

- **Desenvolvimento:** deixe `APP_FULL_BASE_URL=""`. Com o valor vazio, o
  CakePHP usa o `HTTP_HOST` da requisição, ou seja, se adapta sozinho ao
  endereço que você estiver usando (`series-list-cakephp.test`, `localhost:8765`,
  etc.). Se você fixar um host **errado** aqui, redirects podem te levar para um
  domínio que não existe e resultar em **404** — por isso, em dev, vazio é o mais
  seguro.
- **Produção:** você **deve** definir o domínio real **sem barra no final**, por
  exemplo `https://seu-app.com`. Isso é uma exigência de **segurança**: o
  `HostHeaderMiddleware` do CakePHP usa esse valor para barrar ataques de
  *Host Header Injection*. Em produção, o `config/.env` normalmente nem é lido —
  você define as variáveis direto no ambiente do servidor/container.

## Banco de dados

Crie o arquivo do SQLite e rode as migrations:

```bash
# Cria a pasta do banco, se ainda não existir
mkdir -p data

# Executa as migrations (users, genres, series)
bin/cake migrations migrate
```

## Rodando a aplicação

Com Herd/Valet, basta acessar `http://<nome-da-pasta>.test`
(ex.: `http://series-list-cakephp.test`).

Ou use o servidor embutido:

```bash
bin/cake server -p 8765
# acesse http://localhost:8765
```

### Rotas principais

| Método | URL | Ação |
|--------|-----|------|
| GET | `/` | Lista de séries |
| GET | `/users` | Lista de usuários |
| GET/POST | `/users/add` | Cadastro de usuário |

## Testes

```bash
bin/cake test
# ou
vendor/bin/phpunit
```
