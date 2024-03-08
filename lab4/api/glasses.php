<?php

use Dabbous\Store\Repositories\ItemsRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$urlParts = explode('/', $_SERVER['REQUEST_URI']);

$res = $urlParts[2];
$resourceId = (isset($urlParts[3]) && is_numeric($urlParts[3])) ? (int) $urlParts[3] : 0;

if ('glasses' === $res) {

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            try {
                $data = handle_get($resourceId);
                $statusCode = is_null($data) ? 404 : 200;
            } catch (\Exception $ex) {
                $statusCode = 500;
                echo 'Internal Server Error.';
            }

            break;
        case 'POST':
            try {
                $data = handle_post();
                if ($data) {
                    $statusCode =  200;
                } else {
                    $statusCode = 400;
                }
            } catch (\Exception $ex) {
                $statusCode = 500;
                echo 'Internal Server Error.';
            }
            break;
        default:
            $statusCode = 405;
            echo 'method not supported';
            break;
    }

    http_response_code($statusCode);
    header('Content-Type: application/json');

    if (!empty($data) && is_array($data)) {
        echo json_encode($data);
    }
} else {
    http_response_code(404);
    header('Content-Type: application/json');
}


function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function handle_get($item_id)
{
    $item_id = $item_id ?? false;
    $page = $_GET['page'] ?? 0;
    $search_query = $_GET['search'] ?? false;

    if ($search_query) {
        $search_query = trim($search_query);
        $search_query = stripslashes($search_query);
        $search_query = htmlspecialchars($search_query);
        $data[] = ItemsRepository::get_record_by_name($search_query, $page);
        $data[] = ['page' => $page];
    } elseif (!$item_id) {
        if (isset($_GET['page'])) {
            $data[] = ItemsRepository::paginate_records($page);
            $data[] = ['page' => $page];
        } else {
            $data[] = ItemsRepository::get_all_records();
        }
    } else {
        $data[] = ItemsRepository::get_record_by_id($item_id);
    }
    return $data;
}


function handle_post()
{
    $req_body = json_decode(file_get_contents('php://input'), true);

    $product_code = sanitize_input($req_body["product_code"]);
    $product_name = sanitize_input($req_body["product_name"]);
    $list_price = sanitize_input($req_body["list_price"]);
    $reorder_level = sanitize_input($req_body["reorder_level"]);
    $units_in_stock = sanitize_input($req_body["units_in_stock"]);
    $category = sanitize_input($req_body["category"]);
    $country = sanitize_input($req_body["country"]);
    $rating = sanitize_input($req_body["rating"]);
    $discontinued = isset($req_body["discontinued"]) ? 1 : 0;
    $date = date("Y-m-d");

    if (empty($product_code)) {
        return ['errors' => ["Product code is required."]];
    }

    if (empty($product_name)) {
        return ['errors' => ["Product name is required."]];
    }

    if (empty($list_price) || !is_numeric($list_price)) {
        return ['errors' => ["List price must be a numeric value."]];
    }

    if (empty($reorder_level) || !ctype_digit($reorder_level)) {
        return ['errors' => ["Reorder level must be a positive integer."]];
    }

    if (empty($units_in_stock) || !ctype_digit($units_in_stock)) {
        return ['errors' => ["Units in stock must be a positive integer."]];
    }

    if (empty($category)) {
        return ['errors' => ["Category is required."]];
    }

    if (empty($country)) {
        return ['errors' => ["Country is required."]];
    }

    if (empty($rating) || !is_numeric($rating) || $rating <= 0 || $rating >= 5) {
        return ['errors' => ["Rating must be a numeric value between 0 and 5."]];
    }

    if ($discontinued !== 0 && $discontinued !== 1) {
        return ['errors' => ["Invalid value for discontinued."]];
    }

    // If no errors, prepare item and store record
    $item = [
        'product_code' => $product_code,
        'product_name' => $product_name,
        'list_price' => $list_price,
        'reorder_level' => $reorder_level,
        'units_in_stock' => $units_in_stock,
        'category' => $category,
        'rating' => $rating,
        'date' => $date,
        'discontinued' => $discontinued,
    ];

    ItemsRepository::store_record($item);
    return true;
}
