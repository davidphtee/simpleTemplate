# 🚀 PHP Template Engine

A simple, lightweight PHP template engine inspired by [thinkphp/php-template-engine](https://github.com/thinkphp/php-template-engine).

**Key features:**
- ✅ Double moustache `{{ $variable }}` — insert variable values.
- ✅ Triple moustache `{{{ ... }}}` — execute raw PHP code.
- ✅ Set single variables or arrays.
- ✅ Zero dependencies.

---

## 📂 Installation

Just download `Template.php` and include it in your project:

```php
require_once 'Template.php';
```


## 📄 Basic Usage

### 1️⃣ Create a template file

Create a `.tpl` file with moustache syntax:

**`example.tpl`**
```html
<h1>{{ $title }}</h1>

<ul>
  {{{ foreach ($items as $item): }}}
    <li>{{ $item }}</li>
  {{{ endforeach; }}}
</ul>
```

---

### 2️⃣ Render the template

**`index.php`**
```php
<?php
require_once 'Template.php';

// Create a template instance
$template = new Template();

// Set single variable
$template->set('title', 'My Shopping List');

// Or set multiple variables at once
$template->setArray([
    'items' => ['Apples', 'Bananas', 'Cherries']
]);

// Render and output the HTML
echo $template->fetch('example.tpl');
```

**Expected output:**
```html
<h1>My Shopping List</h1>

<ul>
  <li>Apples</li>
  <li>Bananas</li>
  <li>Cherries</li>
</ul>
```

---

## ⚙️ API Reference

### `set(string $name, mixed $value)`

Set a single variable for use in your template.

```php
$template->set('name', 'Alice');
```

---

### `setArray(array $list)`

Set multiple variables at once.

```php
$template->setArray([
    'name' => 'Alice',
    'age' => 25
]);
```

---

### `fetch(string $file): string`

Parse the template and return the final HTML output.

```php
$html = $template->fetch('mytemplate.tpl');
echo $html;
```

---

## ⚠️ Notes & Tips

- **Double moustache `{{ $var }}`**: outputs the variable value **without escaping** — use carefully if you output raw HTML.
- **Triple moustache `{{{ ... }}}`**: runs PHP logic inside the template — for loops, conditionals, etc.
- This engine is intentionally minimal — no layouts, includes, or caching by default. Extend as needed!

---

## 📜 License

Adapted from [thinkphp/php-template-engine](https://github.com/thinkphp/php-template-engine).  
Licensed under the MIT License.

---

## 👨‍💻 Author

**Name:** `David Tee`  
**Class:** `Template`


