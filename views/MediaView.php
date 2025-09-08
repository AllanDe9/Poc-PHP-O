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
    <div class="max-w-2xl mx-auto mt-10 p-8 bg-white rounded-lg shadow">
        <h1 class="text-3xl font-bold mb-6">Détails d'un <?php echo strtolower($media->getType()); ?></h1>
        <?php if ($media): ?>
            <h2 class="text-2xl font-semibold mb-2"><?php echo ($media->getTitle()); ?></h2>
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
            <p class="text-gray-600 mb-1">
                <span class="<?php echo (isset($media) && $media->getAvailable()) ? 'text-green-600' : 'text-red-600'; ?>">
                    <?php echo (isset($media) && $media->getAvailable()) ? 'Disponible' : 'Indisponible'; ?>
                </span>
            </p>
            <?php if (isset($songs) && !empty($songs)): ?>
                <h3 class="text-xl font-semibold text-gray-700 mt-6 mb-2">Chansons:</h3>
                <ul class="list-disc list-inside space-y-1">
                    <?php foreach ($songs as $song): ?>
                        <li class="text-gray-700"><?php echo $song->getTitle(); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>