<?php

/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>

<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
    <ul class="pagination justify-content-center">
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a class="page-link bg-dark text-info border-info" href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
                    <span aria-hidden="true"><i class="fas fa-angle-double-left"></i></span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link bg-dark text-info border-info" href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
                    <span aria-hidden="true"><i class="fas fa-angle-left"></i></span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link <?= $link['active'] ? 'bg-info text-dark' : 'bg-dark text-info' ?> border-info" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a class="page-link bg-dark text-info border-info" href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
                    <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link bg-dark text-info border-info" href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
                    <span aria-hidden="true"><i class="fas fa-angle-double-right"></i></span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>