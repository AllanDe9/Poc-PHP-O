<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <title>Login</title>
</head>
<body class="bg-gray-100">
    <?php require 'views/Navbar.php'; ?>
    <div class="flex flex-col items-center mt-10 min-h-screen">
        <h1 class="text-3xl font-bold mb-6">Connexion</h1>
        <form action="login" method="post" class="bg-white p-8 rounded shadow-md w-full max-w-sm">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 mb-2">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 mb-2">Mot de passe:</label>
                <input type="password" id="password" name="password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <?php if (isset($error)): ?>
                <div class="mb-4 text-red-500"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="mb-4 text-green-500"><?php echo $_SESSION['message']; ?></div>
            <?php endif; ?>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">Connexion</button>
        </form>
    </div>
</body>
</html>