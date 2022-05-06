<form action="search_result.php" method="get">
    <input
        type="text"
        name="keyword"
        style="padding: 10px;font-size: 16px;margin-bottom: 10px"
        value=<?= isset($keyword) ? Utils::h($keyword) : null; ?>
    >
    <button type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">Search Todo</button>
</form>