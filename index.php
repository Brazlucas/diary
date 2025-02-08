<?php
session_start();
require_once __DIR__ . '../app/functions.php';

// Processa requisições POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['content'])) {
        insertEntry($pdo, $_POST['content']);
        exit;
    }
    if (isset($_POST['delete_id'])) {
        deleteEntry($pdo, $_POST['delete_id']);
        exit;
    }
}

// Recupera entradas
$entries = getEntries($pdo);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diário Simples</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        };
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 p-6">
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold dark:text-white">Meu Diário</h1>
        <button id="toggleTheme" class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white px-4 py-2 rounded-md">🌙</button>
    </div>
        <textarea id="entry" class="w-full border p-2 rounded-md dark:bg-gray-700 dark:text-white" placeholder="Escreva algo..."></textarea>
        <button id="save" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md">Salvar</button>
        <ul id="entries" class="mt-4 space-y-2">
            <?php foreach ($entries as $entry): ?>
                <li class="p-2 border-b dark:text-white flex justify-between items-center"> 
                    <div class="w-3/4">
                        <p class="short-text">
                            <?= nl2br(htmlspecialchars(strlen($entry['content']) > 110 ? substr($entry['content'], 0, 110) . '...' : $entry['content'])) ?>
                            <span class="text-sm text-gray-500 dark:text-gray-400">(<?= date('d/m/Y H:i', strtotime($entry['created_at'])) ?>)</span>
                        </p>
                        <?php if (strlen($entry['content']) > 110): ?>
                            <button class="expand text-blue-500" data-content="<?= htmlspecialchars($entry['content']) ?>">Ver mais</button>
                        <?php endif; ?>
                    </div>
                    <button class="delete bg-red-500 text-white px-2 py-1 rounded-md h-full" data-id="<?= $entry['id'] ?>">🗑️</button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php include 'modal.php'; ?>
    <script src="../public/js/scripts.js"></script>
</body>
</html>
