<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dabbous\Store\Repositories\ItemsRepository;

$item_id = $_GET['item'] ?? false;
$page = $_GET['page'] ?? 0;


$search_query = $_GET['search'] ?? false;

if ($search_query) {
    $search_query = trim($search_query);
    $search_query = stripslashes($search_query);
    $search_query = htmlspecialchars($search_query);
    $search_results = ItemsRepository::get_record_by_name($search_query, $page);
    require_once __DIR__ . '/views/search.php';
} elseif (!$item_id) {
    $items = ItemsRepository::paginate_records($page);
    require_once __DIR__ . '/views/table.php';
} else {
    $item = ItemsRepository::get_record_by_id($item_id);
    require_once __DIR__ . '/views/item.php';
}

