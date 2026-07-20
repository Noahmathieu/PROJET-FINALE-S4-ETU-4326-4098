<?php
$title = $title ?? 'Espace operateur';
$pageHeading = $pageHeading ?? $title;
$pageDescription = $pageDescription ?? '';
$activeMenu = $activeMenu ?? 'dashboard';
$summaryCards = $summaryCards ?? [];
$content = $content ?? '';
$logoPath = base_url(rawurlencode('Design sans titre.png'));

$menuItems = [
    ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => base_url('operator/home')],
    ['key' => 'configuration', 'label' => 'Configuration', 'href' => base_url('config')],
    ['key' => 'frais', 'label' => 'Frais', 'href' => base_url('frais')],
    ['key' => 'typeOperation', 'label' => 'Types d\'operation', 'href' => base_url('typeOperation')],
    ['key' => 'situationCompte', 'label' => 'Comptes clients', 'href' => base_url('situationClient')],
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
<body class="operator-app" data-active-menu="<?= esc($activeMenu) ?>">
    <div class="operator-backdrop operator-backdrop-1"></div>
    <div class="operator-backdrop operator-backdrop-2"></div>

    <div class="operator-shell">
        <aside class="operator-sidebar" id="operatorSidebar">
            <div class="brand-block">
                <img src="<?= $logoPath ?>" alt="Logo NM" class="brand-logo">
                <div>
                    <p class="brand-eyebrow">Plateforme de gestion</p>
                    <h1>NM Operator</h1>
                </div>
            </div>

            <nav class="operator-nav" aria-label="Navigation operateur">
                <?php foreach ($menuItems as $item): ?>
                    <a class="nav-link <?= $activeMenu === $item['key'] ? 'is-active' : '' ?>" href="<?= esc($item['href']) ?>">
                        <span class="nav-link-dot"></span>
                        <span><?= esc($item['label']) ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </aside>

        <div class="sidebar-overlay" data-sidebar-close></div>

        <main class="operator-main">
            <header class="operator-topbar">
                <button class="icon-button" type="button" data-sidebar-toggle aria-label="Ouvrir le menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="topbar-copy">
                    <span class="topbar-kicker">Tableau de bord securise</span>
                    <strong><?= esc($pageHeading) ?></strong>
                    <?php if ($pageDescription !== ''): ?>
                        <p><?= esc($pageDescription) ?></p>
                    <?php endif; ?>
                </div>

                <div class="topbar-actions">
                    <span class="signal-pill"><span class="signal-dot"></span>Connecte</span>
                    <a class="ghost-link" href="<?= base_url('/logout') ?>">Deconnexion</a>
                </div>
            </header>

            <section class="operator-content">
                <article class="hero-card">
                    <div class="hero-copy">
                        <p class="hero-tag">Mobile money centralise</p>
                        <h2><?= esc($pageHeading) ?></h2>
                        <?php if ($pageDescription !== ''): ?>
                            <p class="hero-text"><?= esc($pageDescription) ?></p>
                        <?php else: ?>
                            <p class="hero-text">   Une interface claire, rapide et coherente avec l'identite visuelle du projet.</p>
                        <?php endif; ?>
                    </div>

                </article>

                <?php if (!empty($summaryCards)): ?>
                    <section class="stats-grid" aria-label="Indicateurs principaux">
                        <?php foreach ($summaryCards as $card): ?>
                            <article class="stat-card <?= esc($card['tone'] ?? 'tone-blue') ?>">
                                <span><?= esc($card['label']) ?></span>
                                <strong data-counter="<?= esc((string) ($card['value'] ?? 0)) ?>"><?= esc(number_format((float) ($card['value'] ?? 0), 0, ',', ' ')) ?></strong>
                                <?php if (!empty($card['note'])): ?>
                                    <small><?= esc($card['note']) ?></small>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </section>
                <?php endif; ?>

                <section class="content-panel">
                    <?= $content ?>
                </section>
            </section>
        </main>
    </div>

    <script src="<?= base_url('assets/operator/theme.js') ?>" defer></script>
</body>
</html>
