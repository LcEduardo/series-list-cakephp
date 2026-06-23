# Links e URLs — como gerar caminhos no CakePHP

Este documento explica como criar links internos no CakePHP usando os helpers em vez de
escrever a URL "na mão". A ideia é: nunca chumbar caminhos como `/users` direto no HTML —
deixar o framework montar a URL a partir do **controller** e da **action**, para que tudo
continue funcionando se as rotas mudarem.

---

## 1. Os dois helpers: `Html` e `Url`

Dentro de qualquer template (`.php` em `templates/`) você tem dois ajudantes prontos:

| Helper        | Para que serve                                  | O que retorna             |
| ------------- | ----------------------------------------------- | ------------------------- |
| `$this->Html` | gerar a tag `<a>` completa                      | `<a href="...">Texto</a>` |
| `$this->Url`  | gerar **apenas** a string da URL                | `/users`                  |

Use `Html->link()` quando quiser o link inteiro pronto. Use `Url->build()` quando quiser
só a URL para colocar dentro de um `<a>`, `<form>`, `src`, etc. que você mesmo escreve.

---

## 2. `Html->link()` — gera a tag `<a>` inteira

```php
<?= $this->Html->link('Users', ['controller' => 'Users', 'action' => 'index']) ?>
```

Assinatura: `link($texto, $url, $opcoes)`.

- **`$texto`** — o que aparece para o usuário clicar (`Users`).
- **`$url`** — um array com `controller` e `action` (o Cake monta a URL a partir disso).
- **`$opcoes`** — atributos HTML extras (classe, target, etc.), opcional.

Exemplo com atributos e parâmetro:

```php
<?= $this->Html->link(
    'Ver usuário',
    ['controller' => 'Users', 'action' => 'view', $user->id],
    ['class' => 'button']
) ?>
```

O `$user->id` vira um argumento da action (`/users/view/5`).

---

## 3. `Url->build()` — gera apenas a URL

Quando você já tem o `<a>` escrito e só quer o `href`:

```php
<a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>">Users</a>
```

Também aceita um caminho direto como string (útil se a rota já está conectada):

```php
<a href="<?= $this->Url->build('/users') ?>">Users</a>
```

---

## 4. Array de URL vs. caminho fixo — por que preferir o array

```php
// ✅ recomendado — sobrevive a mudanças de rota
['controller' => 'Users', 'action' => 'index']

// ⚠️ funciona, mas quebra se o caminho da rota mudar
'/users'
```

Usar o array `['controller' => ..., 'action' => ...]` é mais robusto: se amanhã a rota
`/users` virar `/admin/usuarios` em `config/routes.php`, todos os links montados pelo array
se atualizam sozinhos. O caminho fixo `/users` precisaria ser caçado e trocado manualmente.

---

## 5. Link interno vs. externo

- **Interno** (outra página do próprio app): use os helpers e **não** use
  `target="_blank"` nem `rel="noopener"` — esses são para abrir sites externos em outra aba.
- **Externo** (documentação, outro site): aí sim um `<a href="https://...">` simples com
  `target="_blank" rel="noopener"` faz sentido.

```php
<!-- interno -->
<?= $this->Html->link('Users', ['controller' => 'Users', 'action' => 'index']) ?>

<!-- externo -->
<a target="_blank" rel="noopener" href="https://book.cakephp.org/5/">Documentação</a>
```

---

## 6. Onde isso aparece neste projeto

- As rotas ficam em `config/routes.php` (ex.: `/users` → `Users::index`, `/users/add` →
  `Users::add`).
- O menu de navegação fica em `templates/layout/default.php` (bloco `.top-nav-links`).

Para adicionar um link "Users" no menu, troque um `<a>` fixo por:

```php
<?= $this->Html->link('Users', ['controller' => 'Users', 'action' => 'index']) ?>
```

---

## Referências oficiais

- Html Helper (link): https://book.cakephp.org/5/en/views/helpers/html.html#creating-links
- Url Helper (build): https://book.cakephp.org/5/en/views/helpers/url.html
- Routing / geração de URLs: https://book.cakephp.org/5/en/development/routing.html
