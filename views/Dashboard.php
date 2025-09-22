<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <?php require 'views/Navbar.php'; ?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Tableau de bord</h1>
        <form method="GET" action="" class="mb-8 flex flex-col md:flex-row items-center gap-3 bg-white p-4 rounded-lg shadow-sm">
            <input
            type="text" name="search"
            placeholder="Rechercher par titre ou auteur..."
            value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
            class="border border-blue-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 w-full md:w-1/2 transition">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition shadow">Rechercher</button>
            <select onchange="this.form.submit()" name="sort" class="border border-blue-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 ml-80 md:w-1/4 transition">
            <option value="">Trier par</option>
            <option value="title_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'title_asc') ? 'selected' : ''; ?>>Titre (A-Z)</option>
            <option value="title_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'title_desc') ? 'selected' : ''; ?>>Titre (Z-A)</option>
            <option value="author_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'author_asc') ? 'selected' : ''; ?>>Auteur (A-Z)</option>
            <option value="author_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'author_desc') ? 'selected' : ''; ?>>Auteur (Z-A)</option>
            <option value="available" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'available') ? 'selected' : ''; ?>>Disponibilité</option>
            </select>
        </form>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="max-w-2xl mx-auto mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>
        <div class="overflow-x-auto rounded-lg shadow-lg bg-white">
            <table class="min-w-full border border-gray-200">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Titre</th>
                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Auteur</th>
                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Disponibilité</th>
                        <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medias as $media): ?>
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4 border-b"><?php echo $media->getTitle(); ?></td>
                        <td class="px-6 py-4 border-b"><?php echo $media->getAuthor(); ?></td>
                        <td class="px-6 py-4 border-b">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium
                                <?php echo $media->getAvailable() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                                <?php echo $media->getAvailable() ? 'Disponible' : 'Indisponible'; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 border-b">
                            <a href="media/<?php echo $media->getId(); ?>"
                               class="text-blue-600 hover:text-blue-800 font-medium underline transition">
                                Voir
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="flex justify-end gap-4 mt-8">
            <a href="add/book" class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition shadow font-semibold">
                Ajouter Livre
            </a>
            <a href="add/album" class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition shadow font-semibold">
                Ajouter Album
            </a>
            <a href="add/movie" class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition shadow font-semibold">
                Ajouter Film
            </a>
        </div>
    </div>
</body>
</html>