

<ul>

    <li><a href="<?= BASE_URL ?>">ÚVOD</a></li>
    <li ><a  href="<?= BASE_URL . "?page=kampelicka" ?>">KAMPELIČKA</a></li>
    <li ><a  href="<?= BASE_URL . "?page=Kontakt" ?>">KONTAKT</a></li>
    <li ><a  href="<?= BASE_URL . "?page=Akce" ?>">AKCE</a></li>
    <?php if (Authentication::getInstance()->hasIdentity()) : ?>
        <!-- <a href="<?= BASE_URL . "?page=user&action=read-all" ?>">Read all user</a> -->
        <!-- <a href="<?= BASE_URL . "?page=user&action=by-email" ?>">By email</a> -->


        <?php if(Authentication::getInstance()->getRole()=='admin'): ?>
            <li><a href="<?= BASE_URL . "?page=uzivatel" ?>">ZP-Uzivatelů</a></li>
            <li><a href="<?= BASE_URL . "?page=udalost&action=nic" ?>">Událost</a></li>
            <li><a href="<?= BASE_URL . "?page=listky&action=nic" ?>">Lístky</a></li>
            <li><a href="<?= BASE_URL . "?page=mistnosti&action=nic" ?>">Místnost</a></li>
            <li><a href="<?= BASE_URL . "?page=mistnosti" ?>">Vybavení</a></li>
        <?php elseif (Authentication::getInstance()->getRole()=='registrovany') : ?>
            <li><a href="<?= BASE_URL . "?page=listky&action=nic" ?>">Lístky</a></li>
            <li><a href="<?= BASE_URL . "?page=mistnosti" ?>">Vybavení</a></li>
        <?php endif; ?>
    <?php else : ?>

    <?php endif; ?>
</ul>