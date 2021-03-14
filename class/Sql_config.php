<?php
namespace App;

class Sql_config
{
     public static $sql_category_view_post = 'SELECT c.id, c.name, c.slug
                                       FROM post_categories pc
                                       JOIN category c ON pc.category_id = c.id
                                       where pc.post_id = :id';
    public static $sql_post_view_post = 'SELECT * FROM post where id = :id';
}
