
# Simple PHP Template Engine

A lightweight PHP template engine with moustache syntax for easy variable insertion and PHP code execution within your HTML templates.

---

## Features

✅ **Moustache Syntax**

- `{{ $variable }}` — Outputs a variable’s value  
- `{{{ PHP code }}}` — Executes raw PHP code

✅ **Development & Production Modes**

- Development mode uses a temporary file for better error tracing.
- Production mode uses `eval()` for faster rendering.

✅ **Safe Variable Handling**

- Variables are extracted safely.
- Errors are handled gracefully with meaningful messages.

---

## Installation

Simply include `Template.php` in your project.

```php
require_once 'Template.php';
```

---

## Usage

### 1️⃣ Create a Template instance

```php
$template = new Template(true); // `true` enables development mode
```

---

### 2️⃣ Set variables

```php
$template->set('title', 'Hello World');
$template->setArray([
    'name' => 'John',
    'age' => 30
]);
```

---

### 3️⃣ Create a template file

**example.tpl**

```html
<h1>{{ $title }}</h1>
<p>Name: {{ $name }}</p>
<p>Age: {{ $age }}</p>

{{{ if($age >= 18): }}}
<p>Access granted.</p>
{{{ else: }}}
<p>Access denied.</p>
{{{ endif; }}}
```

---

### 4️⃣ Render the template

```php
echo $template->fetch('example.tpl');
```

---

## Configuration

| Parameter | Description |
|-----------|--------------|
| `isDevelopment` | `true` (default): uses a temporary file for detailed error tracing. <br> `false`: uses `eval()` for faster rendering in production. |

---

## Class Reference

### `__construct(bool $isDevelopment = true)`

Create a new instance.  
- `true` → development mode  
- `false` → production mode

### `set(string $name, mixed $value)`

Set a single variable.

### `setArray(array $list)`

Set multiple variables at once.

### `fetch(string $file): string`

Render the given template file with the current variables.

---

## Error Handling

- Throws `RuntimeException` if:
  - The template file does not exist or is unreadable.
  - An error occurs while rendering the template.
- In development mode, the source file name and line numbers are preserved for easier debugging.

---

## License

MIT — use it freely!

---

## Author

**David Tee**

Feel free to open issues or submit pull requests for improvements.
