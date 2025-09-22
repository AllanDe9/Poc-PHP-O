<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($media) ? 'Modifier' : 'Ajouter'; ?> un <?php echo $mediaType; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <?php require 'views/Navbar.php'; ?>
    <div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">
            <?php echo isset($media) ? 'Modifier ' . htmlspecialchars($media->title) : 'Ajouter un ' . $mediaType; ?>
        </h1>
        <form action="" method="post" class="space-y-5">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Titre :</label>
                <input type="text" id="title" name="title" required
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="<?php echo isset($media) ? htmlspecialchars($media->title) : ''; ?>">
            </div>
            <div>
                <label for="author" class="block text-sm font-medium text-gray-700">Auteur :</label>
                <input type="text" id="author" name="author" required
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="<?php echo isset($media) ? htmlspecialchars($media->author) : ''; ?>">
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="available" name="available"
                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                    <?php echo (isset($media) && $media->available) ? 'checked' : ''; ?>>
                <label for="available" class="ml-2 block text-sm text-gray-700">Disponible</label>
            </div>
            <?php if ($mediaType === 'livre'): ?>
                <div>
                    <label for="page_number" class="block text-sm font-medium text-gray-700">Nombre de pages :</label>
                    <input type="number" id="page_number" name="page_number" min="1"
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="<?php echo isset($media) ? htmlspecialchars($media->page_number) : ''; ?>">
                </div>
            <?php elseif ($mediaType === 'film'): ?>
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700">Durée (minutes) :</label>
                    <input type="number" id="duration" name="duration" min="1"
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="<?php echo isset($media) ? htmlspecialchars($media->duration) : ''; ?>">
                </div>
                <div>
                    <label for="genre" class="block text-sm font-medium text-gray-700">Genre :</label>
                    <select id="genre" name="genre"
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <?php
                            foreach (Genre::cases() as $genre) {
                                $selected = (isset($media) && $media->genre === $genre->name) ? 'selected' : '';
                                echo '<option value="' . $genre->name . '" ' . $selected . '>' . $genre->value . '</option>';
                            }
                        ?>
                    </select>
                </div>
            <?php elseif ($mediaType === 'album'): ?>
                <div>
                    <label for="track_number" class="block text-sm font-medium text-gray-700">Nombre de pistes :</label>
                    <input type="number" id="track_number" name="track_number" min="1"
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="<?php echo isset($media) ? htmlspecialchars($media->track_number) : ''; ?>">
                </div>
                <div>
                    <label for="editor" class="block text-sm font-medium text-gray-700">Label :</label>
                    <input type="text" id="editor" name="editor"
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="<?php echo isset($media) ? htmlspecialchars($media->editor) : ''; ?>">
                </div>
            <?php endif; ?>
            <button type="submit"
                class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                <?php echo isset($media) ? 'Modifier' : 'Ajouter'; ?>
            </button>
        </form>
    </div>
</body>
</html>