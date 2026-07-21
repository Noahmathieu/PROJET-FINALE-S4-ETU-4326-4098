<?php
$title = $title ?? 'Espace client';
$pageHeading = $pageHeading ?? $title;
$pageDescription = $pageDescription ?? '';
$activeMenu = $activeMenu ?? 'home';
$content = $content ?? '';
$clientName = $clientName ?? 'Client';
$soldeValue = $soldeValue ?? 0;
$logoPath = base_url(rawurlencode('Design sans titre.png'));

$menuItems = [
    ['key' => 'home', 'label' => 'Accueil', 'href' => base_url('client/home')],
    ['key' => 'depot', 'label' => 'Depot', 'href' => base_url('client/depot')],
    ['key' => 'retrait', 'label' => 'Retrait', 'href' => base_url('client/retrait')],
    ['key' => 'transfert', 'label' => 'Transfert', 'href' => base_url('client/transfert')],
    ['key' => 'transfertMultiple', 'label' => 'Transfert multiple', 'href' => base_url('client/transfertMultiple')],
    ['key' => 'historique', 'label' => 'Historique', 'href' => base_url('client/historique')],
    ['key' => 'epargne', 'label' => 'Epargne', 'href' => base_url('client/epargne')],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/operator/theme.css') ?>">
</head>
<body class="client-app">
    <div class="client-backdrop client-backdrop-1"></div>
    <div class="client-backdrop client-backdrop-2"></div>

    <div class="client-shell">
        <aside class="client-sidebar">
            <div class="client-brand">
                <img src="<?= $logoPath ?>" alt="Logo NM" class="client-brand-logo">
                <div>
                    <p class="client-kicker">Espace client</p>
                    <h1>NM Operator</h1>
                </div>
            </div>

            <div class="client-balance-card">
                <span>Solde actuel</span>
                <strong><?= number_format((float) $soldeValue, 0, ',', ' ') ?> Ar</strong>
                <p>Votre compte est accesible et suivi en temps reel.</p>
            </div>

            <nav class="client-nav" aria-label="Navigation client">
                <?php foreach ($menuItems as $item): ?>
                    <a class="client-link <?= $activeMenu === $item['key'] ? 'is-active' : '' ?>" href="<?= esc($item['href']) ?>">
                        <?= esc($item['label']) ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <a class="client-logout" href="<?= base_url('/logout') ?>">Se deconnecter</a>
        </aside>

        <main class="client-main">
            <header class="client-hero">
                <div>
                    <p class="client-eyebrow">Paiements et operations</p>
                    <h2><?= esc($pageHeading) ?></h2>
                    <?php if ($pageDescription !== ''): ?>
                        <p><?= esc($pageDescription) ?></p>
                    <?php endif; ?>
                </div>
                <div class="client-hero-card">
                    <img src="<?= $logoPath ?>" alt="Logo NM" class="client-hero-logo">
                    <div>
                        <span>Bienvenue</span>
                        <strong><?= esc($clientName) ?></strong>
                    </div>
                </div>
            </header>

            <section class="client-content">
                <?= $content ?>
            </section>
        </main>
    </div>
</body>
</html>
