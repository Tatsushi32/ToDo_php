<?php
require_once(__DIR__ . "/app/config.php");

$pagenation = isset($keyword) ? new PagenationSearch($keyword) : new PaginationAll();
$total_results = isset($keyword) ? $pagenation->total_pages : null;
$total_pages = $pagenation->total_pages;
$page = $pagenation->page;
$offset = $pagenation->offset;
?>

<!-- search_result.php -->
<?php if (isset($keyword)): ?>
    <?php if ($page > 1): ?>
        <a href="?page=<?= Utils::h($page)-1 ?>&keyword=<?= Utils::h($keyword); ?>">前へ</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <?php if ($page == $i): ?>
            <strong><a href="?page=<?= Utils::h($i); ?>&keyword=<?= Utils::h($keyword); ?>"><?= Utils::h($i); ?></a></strong>
        <?php else: ?>
            <a href="?page=<?= Utils::h($i); ?>&keyword=<?= Utils::h($keyword); ?>"><?= Utils::h($i); ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $total_pages): ?>
        <a href="?page=<?= Utils::h($page)+1 ?>&keyword=<?= Utils::h($keyword); ?>">次へ</a>
    <?php endif; ?>
    <?= exit(); ?>
<?php endif; ?>

<!-- index.php -->
<?php if ($page > 1): ?>
    <a href="?page=<?= Utils::h($page)-1 ?>">前へ</a>
<?php endif; ?>
<?php for ($i = 1; $i <= $total_pages; $i++): ?>
    <?php if ($page == $i): ?>
        <strong><a href="?page=<?= Utils::h($i); ?>"><?= Utils::h($i); ?></a></strong>
    <?php else: ?>
        <a href="?page=<?= Utils::h($i); ?>"><?= Utils::h($i); ?></a>
    <?php endif; ?>
<?php endfor; ?>
<?php if ($page < $total_pages): ?>
    <a href="?page=<?= Utils::h($page)+1 ?>">次へ</a>
<?php endif; ?>