<?php
require_once 'Template.php';
$pdo = new PDO('mysql:host=localhost;dbname=mydb', 'user', 'pass');
$userId = $_GET['id'] ?? 1;
$stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$template = new Template(true);
$template->set('user', $user);
echo $template->fetch('user_form.tpl');
