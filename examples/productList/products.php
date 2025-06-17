<?php
require_once 'Template.php';
$pdo = new PDO('mysql:host=localhost;dbname=mydb', 'user', 'pass');
$stmt = $pdo->query("SELECT id, name FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$template = new Template(true);
$template->set('products', $products);
echo $template->fetch('products.tpl');
