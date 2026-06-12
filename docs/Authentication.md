# Authentication — Estrutura de Users

Este documento descreve, em ordem, tudo o que construímos para o recurso **Users** no
CakePHP: desde a convenção de nomes, passando pela camada de Table, Entity, validações
e regras de aplicação, até como cada peça se relaciona com as outras.

---

## 1. Convenção de nomes do CakePHP

O CakePHP usa **convenção sobre configuração**. A partir de uma única tabela no banco
chamada `users` (plural, minúscula), o framework infere automaticamente os nomes das
classes. Por isso criamos:

| Camada      | Arquivo                              | Classe              | Forma     |
| ----------- | ------------------------------------ | ------------------- | --------- |
| Banco       | tabela `users`                       | —                   | plural    |
| Controller  | `src/Controller/UsersController.php` | `UsersController`   | plural    |
| Table       | `src/Model/Table/UsersTable.php`     | `UsersTable`        | plural    |
| Entity      | `src/Model/Entity/User.php`          | `User`              | singular  |

A regra geral:

- **Tabela, Table e Controller** ficam no **plural** (`Users`) — representam a coleção.
- **Entity** fica no **singular** (`User`) — representa um único registro/linha.

Seguindo essa convenção, o Cake conecta tudo sozinho: `UsersController` encontra
`UsersTable`, que por sua vez produz objetos `User`. Não precisamos configurar nada
manualmente.

---

## 2. A migration (origem dos campos)

A tabela `users` foi criada por uma migration (`CreateUsers`) com os campos:

- `name` — string(255), **obrigatório** (`null => false`)
- `age` — integer, opcional (`null => true`)
- `email` — string(255), **obrigatório** e com índice **único** (`UNIQUE_USERS_EMAIL`)
- `password` — string(255), **obrigatório**

Esses limites e restrições do banco são a referência para as validações que escrevemos
depois na aplicação. Ex.: como a coluna é `varchar(255)`, validamos `maxLength(255)`.

---

## 3. A Table — `UsersTable`

A Table é o **gateway** entre a aplicação e a tabela do banco. Nela definimos:

```php
public function initialize(array $config): void
{
    parent::initialize($config);

    $this->setTable('users');
    $this->setPrimaryKey('id');
}
```

- `setTable('users')` — diz qual tabela física esta classe representa.
- `setPrimaryKey('id')` — define a chave primária.

A Table também é o lugar onde ficam as **validações** e as **regras de aplicação**.

---

## 4. Validação — `validationDefault`

O método `validationDefault()` é chamado **automaticamente** pelo CakePHP sempre que
usamos `newEntity()` ou `patchEntity()`. Ele valida os dados **crus de entrada**, antes
de salvar, e produz mensagens de erro amigáveis em vez de deixar o banco estourar.

```php
public function validationDefault(Validator $validator): Validator
{
    $validator
        ->scalar('name')
        ->maxLength('name', 255)
        ->requirePresence('name', 'create')
        ->notEmptyString('name');

    $validator
        ->email('email')
        ->maxLength('email', 255)
        ->requirePresence('email', 'create')
        ->notEmptyString('email');

    $validator
        ->scalar('password')
        ->maxLength('password', 255)
        ->requirePresence('password', 'create')
        ->notEmptyString('password');

    return $validator;
}
```

Significado das regras usadas:

- **`scalar`** — o valor precisa ser um tipo simples (string/número), não um array.
- **`email`** — valida o formato do e-mail.
- **`maxLength(campo, 255)`** — espelha o limite `varchar(255)` da migration.
- **`requirePresence(campo, 'create')`** — o campo precisa **existir** no payload, mas só
  no cenário de criação. Ao editar (`update`), pode ser omitido — útil para "editar
  perfil sem trocar a senha".
- **`notEmptyString(campo)`** — o **valor** não pode ser vazio (diferente de
  `requirePresence`, que cobra a presença da chave).

> Importante: a validação roda sobre a senha **digitada** (texto puro), ainda **antes**
> A ordem é importante.
> do hash. Por isso o `maxLength(255)` se aplica à senha original — o hash gerado depois
> sempre cabe nos 255 da coluna.

---

## 5. Regras de aplicação — `buildRules`

Algumas verificações dependem de consultar o banco (não dá para resolvê-las só olhando o
dado de entrada). Essas vão no `buildRules()`, que roda **no momento de salvar**:

```php
public function buildRules(RulesChecker $rules): RulesChecker
{
    $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

    return $rules;
}
```

- **`isUnique(['email'])`** — garante que não exista outro usuário com o mesmo e-mail.
  Isso reforça, na camada da aplicação, o índice único `UNIQUE_USERS_EMAIL` do banco.

### Validation vs. Rules — qual a diferença?

| Aspecto       | `validationDefault`                  | `buildRules`                          |
| ------------- | ------------------------------------ | ------------------------------------- |
| Quando roda   | em `newEntity()` / `patchEntity()`   | em `save()`                           |
| O que checa   | formato/forma do dado de entrada     | regras que dependem do banco/estado   |
| Exemplo       | "e-mail tem formato válido?"         | "e-mail já existe na tabela?"         |

Ambas são necessárias: a validação barra dados malformados cedo; as rules garantem a
integridade que só o banco conhece.

---

## 6. A Entity — `User` e o hash de senha

A Entity representa **uma linha** da tabela e é onde o dado vive depois de carregado.
Nela definimos duas coisas relevantes:

```php
class User extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected function _setPassword(string $password): ?string
    {
        if (mb_strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return null;
    }
}
```

- **`$_accessible`** — controla o *mass assignment* (quais campos podem ser preenchidos em
  massa via `newEntity()`/`patchEntity()`). `'*' => true` libera todos; `'id' => false`
  protege a chave primária de ser sobrescrita.
- **`_setPassword()`** — é um **mutator** (setter mágico). Sempre que `password` é
  atribuído à entity, o Cake chama esse método automaticamente e armazena o **hash**, não
  o texto puro. Usa o `DefaultPasswordHasher` do plugin **Authentication**.

---

## 7. Como tudo se relaciona — o fluxo completo

Ao criar um usuário, o caminho é:

```
Request (form/JSON)
      │
      ▼
$this->Users->newEntity($data)        ← UsersController usa a UsersTable
      │
      ├─► validationDefault()          ← valida name/email/password (dado cru)
      │        (formato, presença, tamanho)
      │
      ▼
Entity User preenchida
      │
      └─► _setPassword()               ← hash da senha acontece aqui (na Entity)
      │
      ▼
$this->Users->save($user)
      │
      ├─► buildRules()                 ← isUnique(email) consulta o banco
      │
      ▼
INSERT na tabela `users`
```

Resumindo a divisão de responsabilidades:

- **Convenção de nomes** → o Cake conecta Controller ↔ Table ↔ Entity sozinho.
- **Migration** → define a estrutura física e as restrições do banco.
- **`UsersTable`** → gateway + validações de entrada (`validationDefault`) + regras de
  banco (`buildRules`).
- **Entity `User`** → representa a linha, controla mass assignment e faz o hash da senha.

Cada peça tem um papel claro e elas se complementam: a validação garante que o dado entra
correto, o hash garante que a senha nunca é armazenada em texto puro, e as rules garantem
a integridade que depende do estado atual do banco.
