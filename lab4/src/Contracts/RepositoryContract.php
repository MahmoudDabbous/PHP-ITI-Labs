<?php

namespace Dabbous\Store\Contracts;

interface RepositoryContract
{
    public static function get_all_records();
    public static function get_record_by_id($id);
    public static function get_record_by_name($name, $page, $offset);
    public static function paginate_records($page, $offset);
    public static function store_record($data);
}
