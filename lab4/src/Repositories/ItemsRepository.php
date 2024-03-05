<?php

namespace Dabbous\Store\Repositories;

use Dabbous\Store\Contracts\RepositoryContract;
use Dabbous\Store\Models\Items;

class ItemsRepository implements RepositoryContract
{
    public static function get_all_records()
    {
        return Items::all();
    }

    public static function get_record_by_id($id)
    {
        return Items::where('id', $id)->get()->first();
    }

    public static function get_record_by_name($name, $page = 0, $offset = 5)
    {
        return Items::select(['id', 'product_name', 'product_code', 'list_price', 'rating'])
            ->where('product_name', 'like', '%' . $name . '%')
            ->skip($page * 5)
            ->take($offset)
            ->get();
    }

    public static function paginate_records($page, $offset = 5)
    {
        return Items::select(['id', 'product_name'])
            ->skip($page * 5)
            ->take($offset)
            ->get();
    }

    public static function store_record($data)
    {
        $item = new Items;

        $item->product_code = $data['product_code'];
        $item->product_name = $data['product_name'];
        $item->photo = $data['photo'];
        $item->list_price = $data['list_price'];
        $item->reorder_level = $data['reorder_level'];
        $item->units_in_stock = $data['units_in_stock'];
        $item->category = $data['category'];
        $item->rating = $data['rating'];
        $item->date = $data['date'];
        $item->discontinued = $data['discontinued'];

        try {
            $item->save();
        } catch (\Exception $ex) {
            echo "<h1>Error saving item: </h1>";
            echo "<pre>";
            print_r($ex->getMessage());
            echo "</pre>";
        }
    }
}
