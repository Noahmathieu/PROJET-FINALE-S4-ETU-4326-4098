<?php
$prefixe = $prefixe ?? [];

ob_start();
?>
<div class="dual-grid">
    <section class="panel-card">
        <div class="panel-head">
            <div>
                <h3>Ajouter un nouveau prefixe</h3>
                <p>Ces prefixes sont utilises pour valider les numeros clients autorises.</p>
            </div>
        </div>

        <form class="form-grid" action="<?= base_url('autresOperateurs/ajouter') ?>" method="post">
            <div class="form-group">
                <label for="prefixe">Prefixe</label>
                <input type="text" name="prefixe" id="prefixe" placeholder="Ex: 032" maxlength="10" required>
                <label for="nom">Nom de l'operateur</label>
                <input type="text" name="nom" id="nom" placeholder="Ex: Orange" maxlength="100" required>
            </div>

            <button class="primary-button" type="submit">Ajouter le prefixe</button>
        </form>
    </section>

    <section class="panel-card">
        <div class="section-head">
            <div>
                <h3>Prefixes enregistres</h3>
                <p>Filtre rapide et gestion directe des valeurs existantes.</p>
            </div>
        </div>

        <div class="search-row">
            <input class="search-field" type="search" data-grid-search="#prefixList" placeholder="Rechercher un prefixe">
        </div>

        <div id="prefixList" class="item-list">
            <?php if (empty($prefixe)): ?>
                <div class="empty-state">
                    <strong>Aucun prefixe n'est disponible.</strong>
                    <span>Ajoutez le premier prefixe pour activer la validation des numeros autorises.</span>
                </div>
            <?php endif; ?>

            <?php foreach ($prefixe as $config): ?>
                <article class="item-card" data-search-item>
                    <div>
                        <span class="mini-pill">Prefixe autorise</span>
                        <strong><?= esc($config['prefixe']) ?></strong>
                        <span class="mini-pill">Nom de l'operateur</span>
                        <strong><?= esc($config['nomOperateur']) ?></strong>
                    </div>
                    <a class="danger-button" href="<?= base_url('autresOperateurs/supprimer/' . $config['id']) ?>" data-delete-confirm="Supprimer le prefixe <?= esc($config['prefixe']) ?> ?">Supprimer</a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</div>
<?php
$content = ob_get_clean();

echo view('operateur/_layout', [
    'title' => 'Configuration des prefixes',
    'pageHeading' => 'Configuration des prefixes',
    'pageDescription' => 'Ajoutez et retirez les prefixes autorises pour les numeros clients.',
    'activeMenu' => 'configuration',
    'content' => $content,
]);