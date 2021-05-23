<?php $pager->setSurroundCount(2)

/**
 * For styling our pagination we used bootstrap pagination https://getbootstrap.com/docs/4.0/components/pagination/, 23.5.2021
 * more about work with pagination in codeigniter 4 please refer to article https://codeigniter.com/user_guide/libraries/pagination.html, 23.5.2021
 */

?>


<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center pagination-sm">
    <?php if ($pager->hasPrevious()) : ?>
        <li class="page-item">
            <a class="pagination_links_first page-link" href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
                <span aria-hidden="true"><?= lang('Pager.first') ?></span>
            </a>
        </li>
        <li class="page-item">
            <a class="pagination_links_previous page-link" href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
                <span class="sr-only" aria-hidden="true"><?= lang('Pager.previous') ?></span>
            </a>
        </li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
        <li class="page-item page-link" <?= $link['active'] ? 'class="active"' : '' ?>>
            <a class="pagination_links" href="<?= $link['uri'] ?>">
                <?= $link['title'] ?>
            </a>
        </li>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <li class="page-item">
            <a class="pagination_links_next page-link" href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
                <span class="sr-only" aria-hidden="true"><?= lang('Pager.next') ?></span>
            </a>
        </li>
        <li class="page-item">
            <a  class="pagination_links_last page-link" href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
                <span aria-hidden="true"><?= lang('Pager.last') ?></span>
            </a>
        </li>
    <?php endif ?>
    </ul>
</nav>