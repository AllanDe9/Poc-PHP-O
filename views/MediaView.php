<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <title>Détails du Média</title>
</head>
<body class="bg-gray-50 min-h-screen text-gray-800">
    <?php require 'views/Navbar.php'; ?>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="max-w-2xl mx-auto mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>
    <div class="max-w-2xl mx-auto mt-10 p-8 bg-white rounded-lg shadow">
        <h1 class="text-3xl font-bold mb-6">Détails d'un <?php echo strtolower($media->getType()); ?></h1>
            <div class="flex items-center mb-2">
                <h2 class="text-2xl font-semibold"><?php echo ($media->getTitle()); ?></h2>
                <span class="px-3 py-1 rounded-full text-sm font-semibold ml-4
                    <?php echo $media->getAvailable() ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-red-100 text-red-700 border border-red-300'; ?>">
                    <?php echo $media->getAvailable() ? 'Disponible' : 'Indisponible'; ?>
                </span>
            </div>
            <p class="text-gray-600 mb-1"><span class="font-medium">Auteur:</span> <?php echo $media->getAuthor(); ?></p>
            <?php if ($media instanceof Book): ?>
                <p class="text-gray-600 mb-1"><span class="font-medium">Nombre de pages:</span> <?php echo ($media->getPageNumber()); ?></p>
            <?php elseif ($media instanceof Movie): ?>
                <p class="text-gray-600 mb-1"><span class="font-medium">Durée:</span> <?php echo $media->getDuration(); ?> minutes</p>
                <p class="text-gray-600 mb-1"><span class="font-medium">Genre:</span> <?php echo $media->getGenre()->value; ?></p>
            <?php elseif ($media instanceof Album): ?>
                <p class="text-gray-600 mb-1"><span class="font-medium">Nombre de pistes:</span> <?php echo $media->getTrackNumber(); ?></p>
                <p class="text-gray-600 mb-1"><span class="font-medium">Label:</span> <?php echo $media->getEditor(); ?></p>
            <?php endif; ?>
            <?php if (isset($songs)): ?>
                <h3 class="text-xl font-semibold text-gray-700 mt-6 mb-2">Chansons:</h3>
                <ul class="list-disc mb-4 ml-4">
                <?php foreach ($songs as $song): ?>
                    <div class="flex items-center justify-between py-2">
                        <li><?php echo $song->getTitle(); ?></li>
                        <span class="space-x-2">
                            <a href="./<?php echo $media->getId(); ?>/edit-song/<?php echo $song->getId(); ?>" class="text-sm px-4 py-2 rounded-full border font-semibold text-gray-700 hover:bg-gray-400 hover:text-white transition"> Modifier </a>
                            <a href="?delete-song=<?php echo $song->getId(); ?>" class="text-sm px-4 py-2 rounded-full border font-semibold text-gray-700 hover:bg-gray-400 hover:text-white transition">Supprimer</a>
                        </span>
                    </div>
                <?php endforeach; ?>
                </ul>
            <a href="./<?php echo $media->getId(); ?>/add-song" class="px-4 py-2 rounded-full border font-semibold text-gray-700 hover:bg-gray-400 hover:text-white transition">Ajouter une chanson</a>
        <?php endif; ?>
    </div>
    <div class="flex justify-between max-w-2xl mx-auto mt-8 mb-6 p-8 bg-white rounded-lg shadow">
        <form method="post" class="inline">
            <input type="hidden" name="media_id" value="<?php echo $media->getId(); ?>">
            <button type="submit" class="px-4 py-2 rounded-full border font-semibold text-gray-700 hover:bg-gray-400 hover:text-white transition">
            <?php echo $media->getAvailable() ? 'Emprunter' : 'Rendre'; ?>
            </button>
        </form>
        <a href="../edit/<?php echo $media->getId(); ?>" class="px-4 py-2 rounded-full border font-semibold text-gray-700 hover:bg-gray-400 hover:text-white transition">
            Modifier
        </a>
        <a href="?delete=true" class="px-4 py-2 rounded-full border font-semibold text-gray-700 hover:bg-red-600 hover:text-white transition ml-4">
            Supprimer
        </a>
    </div>

    <?php if (isset($_GET['delete']) && $_GET['delete'] === 'true'): ?>
    <!-- Pop-up de confirmation -->
    <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-sm w-full">
            <h2 class="text-xl font-bold mb-4">Confirmer la suppression</h2>
            <p class="mb-6">Êtes-vous sûr de vouloir supprimer <?php echo $media->getTitle(); ?> ? Cette action est irréversible.</p>
            <div class="flex justify-end space-x-4">
                <a href="?" class="px-4 py-2 rounded bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300">Annuler</a>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?php echo $media->getId(); ?>">
                    <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white font-semibold hover:bg-red-700">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>