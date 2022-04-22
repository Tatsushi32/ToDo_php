<table border="1">
    <colgroup span="4"></colgroup>
    <tr>
        <th>タイトル</th>
        <th>内容</th>
        <th>作成日時</th>
        <th>更新日時</th>
        <th>編集</th>
        <th>削除</th>
    </tr>
    <?php foreach ($todos as $todo): ?>
        <tr>
            <td><?= Utils::h($todo->title); ?></td>
            <td><?= Utils::h($todo->content); ?></td>
            <td><?= Utils::h($todo->created_at); ?></td>
            <td><?= Utils::h($todo->updated_at); ?></td>
            <td>
                <form method="post" action="edit.php">
                    <input type="hidden" name="page" value="<?= Utils::h($page); ?>">
                    <?= isset($_GET["keyword"]) ? '<input type="hidden" name="keyword" value="' . Utils::h($keyword) . '">': null ?>
                    <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= Utils::h($todo->id); ?>">編集する</button>
                </form>
            </td>
            <td>
                <form method="post" action="delete.php">
                    <input type="hidden" name="page" value="<?= Utils::h($page); ?>">
                    <?= isset($_GET["keyword"]) ? '<input type="hidden" name="keyword" value="' . Utils::h($keyword) . '">': null ?>
                    <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= Utils::h($todo->id); ?>">削除する</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table> 