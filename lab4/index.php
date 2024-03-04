<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dabbous\Store\Models\Items;


$item = $_GET['item'] ?? false;
$page = $_GET['page'] ?? 0;


$search_query = $_GET['search'] ?? '';
$search_query = trim($search_query);
$search_query = stripslashes($search_query);
$search_query = htmlspecialchars($search_query);

if (!empty($search_query)) {
    $search_results = Items::where('product_name', 'like', '%' . $search_query . '%')
        ->skip($page * 5)
        ->take(5)
        ->get();
    require_once __DIR__ . '/views/search.php';
} elseif (!$item) {
    $items = Items::select()
        ->skip($page * 5)
        ->take(5)
        ->get();
    require_once __DIR__ . '/views/table.php';
} else {
    $item_data = Items::where('id', $item)->get()->first();
    require_once __DIR__ . '/views/item.php';
}
