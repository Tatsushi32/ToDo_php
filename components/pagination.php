<?php
$pagination = isset($keyword) ? new PaginationSearch($keyword) : new PaginationAll();
$pagination->showPagination();
?>