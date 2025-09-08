<nav class="flex items-center justify-between bg-gray-800 p-4 text-white">
    <div class="flex items-center space-x-4">
        <h1 class="text-xl font-bold">Gestion Médiathèque</h1>
        <?php if (isset($_SESSION['user'])): ?>
            <span class="font-semibold">Bienvenue <?php echo$_SESSION['user']; ?></span>
        <?php endif; ?>
    </div>
    <div>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="/Poc-PHP-O/logout" class="hover:font-bold transition">Déconnexion</a>
        <?php else: ?>
            <?php if ($_SERVER['REQUEST_URI'] === '/Poc-PHP-O/login'): ?>
                <a href="/Poc-PHP-O/register" class="hover:text-2xl transition">S'inscrire</a>
            <?php else: ?>
                <a href="/Poc-PHP-O/login" class="hover:font-bold transition">Connexion</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</nav>
