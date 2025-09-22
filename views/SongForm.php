<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <title><?php echo isset($song) ? 'Modifier' : 'Ajouter'; ?> une chanson</title>
</head>
<body class="bg-gray-100 min-h-screen">
    <?php require 'views/Navbar.php'; ?>
    <div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">
            <?php echo isset($song) ? 'Modifier ' . htmlspecialchars($song->getTitle()) : 'Ajouter une chanson à l\'album ' . htmlspecialchars($album->getTitle()); ?>
        </h1>
        <form action="" method="post" class="space-y-6">
            <div>
                <label for="title" class="block text-gray-700 font-semibold mb-2">Titre :</label>
                <input type="text" id="title" name="title" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="<?php echo isset($song) ? htmlspecialchars($song->getTitle()) : ''; ?>">
            </div>
            <div>
                <label for="notation" class="block text-gray-700 font-semibold mb-2">Notation sur 10 :</label>
                <input type="number" id="notation" name="notation" min="0" max="10" required
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="<?php echo isset($song) ? htmlspecialchars($song->getNotation()) : ''; ?>">
            </div>
            <div>
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    <?php echo isset($song) ? 'Modifier' : 'Ajouter'; ?> la chanson
                </button>
            </div>
        </form>
    </div>
</body>
</html>
