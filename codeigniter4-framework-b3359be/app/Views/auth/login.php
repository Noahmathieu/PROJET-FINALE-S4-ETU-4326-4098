<?php
$error = session()->getFlashdata('error');
$success = session()->getFlashdata('success');
$logoPath = base_url(rawurlencode('Design sans titre.png'));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="<?= base_url('assets/operator/theme.css') ?>">
</head>
<body class="auth-page">
    <div class="auth-backdrop auth-backdrop-1"></div>
    <div class="auth-backdrop auth-backdrop-2"></div>

    <main class="auth-shell">
        <section class="auth-brand-panel">
            <div class="auth-brand-card">
                <img src="<?= $logoPath ?>" alt="Logo NM" class="auth-logo">
                <p class="auth-eyebrow">Mobile money platform</p>
                <h1>Connexion operateur et client</h1>

                <div class="auth-points">
                    <div>
                        <strong>Validation numerique</strong>
                        <span>Les numéros sont connecte meme s'il n'est pas encore enregistré.</span>
                    </div>
                    <div>
                        <strong>Acces instantane</strong>
                        <span>Operateur et client rejoignent leur espace apres authentification.</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="auth-form-panel">
            <div class="auth-card">
                <div class="auth-card-head">
                    <span class="auth-kicker">Bienvenue</span>
                    <h2>Se connecter</h2>
                    <p>Entrez votre numero pour acceder a votre espace.</p>
                </div>

                <?php if ($error): ?>
                    <div class="flash-message error" role="alert"><?= esc($error) ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="flash-message success" role="status"><?= esc($success) ?></div>
                <?php endif; ?>

                <form class="auth-form" action="<?= base_url('/checkLogin'); ?>" method="post">
                    <div class="form-group">
                        <label for="numero">Numero de telephone</label>
                        <input type="tel" name="numero" id="numero" inputmode="tel" autocomplete="tel" placeholder="Ex: 0221234567" required>
                    </div>

                    <button class="primary-button auth-submit" type="submit">Se connecter</button>
                </form>

                <div class="auth-hint">
                    <span>Operateur principal</span>
                    <strong>1234567890</strong>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const logo = document.querySelector('.auth-logo');
            const formCard = document.querySelector('.auth-card');

            requestAnimationFrame(() => {
                logo?.classList.add('is-visible');
                formCard?.classList.add('is-visible');
            });

            const input = document.getElementById('numero');
            input?.addEventListener('focus', () => {
                formCard?.classList.add('is-focused');
            });

            input?.addEventListener('blur', () => {
                formCard?.classList.remove('is-focused');
            });
        });
    </script>
</body>
</html>