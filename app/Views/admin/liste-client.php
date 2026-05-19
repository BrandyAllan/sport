<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="app-wrapper">

    <aside class="sidebar">
        <div class="sidebar-logo">
            Fit<span>Space</span>
            <span style="font-size:0.6rem; background:var(--accent); color:#fff; padding:2px 6px; border-radius:4px; vertical-align:middle;">
                Admin
            </span>
        </div>
        <div class="sidebar-section">
            Gestion
        </div>
        <ul class="sidebar-nav">
            <li>
                <a href="/dashboard">
                    <i class="bi bi-speedometer2"></i>
                    Vue d'ensemble
                </a>
            </li>
            <li>
                <a href="/reservation">
                    <i class="bi bi-bookmark-star-fill"></i>
                    Réservations
                </a>
            </li>
            <li>
                <a href="/creneau">
                    <i class="bi bi-calendar-week-fill"></i>
                    Créneaux
                </a>
            </li>
            <li>
                <a href="/liste-client" class="active">
                    <i class="bi bi-people-fill"></i>
                    Clients
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <?php
                    $mots = explode(' ', trim($name));
                    $initiales = mb_substr($mots[0], 0, 1);
                    if (count($mots) > 1) {
                        $initiales .= mb_substr($mots[1], 0, 1);
                    }
                    $initiales = mb_strtoupper($initiales);
                ?>
                <div class="avatar" style="background:#0f3460;">
                    <?= $initiales ?>
                </div>
                <div class="user-info">
                    <div class="name">
                        <?= $name ?>
                    </div>
                    <div class="role">
                        <?= $role ?>
                    </div>
                </div>
                <a href="/logout"
                   style="margin-left:auto; color:rgba(255,255,255,0.3); font-size:1.1rem;">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </aside>
    <div class="main-content">
        <div class="topbar">
            <span class="topbar-title">
                Liste des clients
            </span>
        </div>
        <div class="page-content">
            <?php if(session()->getFlashdata('success')): ?>
                <div class="flash-message flash-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?>
                <div class="flash-message flash-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <div class="data-card">
                <div class="data-card-header">
                    <h3>
                        Clients inscrits
                    </h3>
                    <span style="font-size:0.8rem; color:var(--muted);">
                        <?= count($clients) ?> client(s)
                    </span>
                </div>
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Email</th>
                            <th>Date inscription</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($clients as $client): ?>
                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center;gap:10px;">
                                        <?php
                                            $mots = explode(' ', trim($client['nom']));
                                            $initiales = mb_substr($mots[0], 0, 1);

                                            if(count($mots) > 1) {
                                                $initiales .= mb_substr($mots[1], 0, 1);
                                            }

                                            $initiales = mb_strtoupper($initiales);
                                        ?>
                                        <div class="avatar">
                                            <?= $initiales ?>
                                        </div>
                                        <div class="td-name">
                                            <?= esc($client['nom']) ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="td-muted">
                                    <?= esc($client['email']) ?>
                                </td>
                                <td class="td-muted">
                                    <?= date(
                                        'd/m/Y H:i',
                                        strtotime($client['created_at'])
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>