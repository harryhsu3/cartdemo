<?php
namespace App;

/**
 * 可以增加商品、計算總價、回傳商品總數量
 *
 * @author harryhsu
 * @version 1.0
 */

use Illuminate\Support\Collection;

class Cart
{
    const VERSION = '1.0.0';
    private $id;
    private $items;

    public function __construct($id = '')
    {
        if (!is_string($id)) {
            throw new Exception('Param $id must be string.', 1);
        }

        $this->id = sha1($id) . '_cart';

        if (!empty($_SESSION[$this->id]) && is_array($_SESSION[$this->id])) {
            $this->items = $_SESSION[$this->id];
        } else {
            $this->items = [];
        }
    }

    /**
     * Add item to cart
     *
     * @param string $id
     * @param int    $qty
     * @param array  $attritubes
     *
     * @return $this
     */
    public add($id, $name, $qty, $price)
    {
        if (!is_string($id)) {
            throw new Exception('Param $id must be string.', 1);
        }

        if (!is_string($name)) {
            throw new Exception('Param $name must be string.', 1);
        }

        if (!is_numeric($qty) || $qty <= 0) {
            throw new Exception('Param $qty must be numeric.', 1);
        }

        if (!is_numeric($price) || $price <= 0) {
            throw new Exception('Param $price must be numeric.', 1);
        }

        if (array_key_exists($id, $this->items)) {
            $this->items[$id]['qty'] += $qty;
        } else {
            $this->itmes[$id]['qty']   = $qty;
            $this->itmes[$id]['name']  = $name;
            $this->itmes[$id]['price'] = $price;
        }

        return $this;
    }

    /**
     * Get the carts content
     *
     * @return Collection
     */
    public function getContent()
    {
        $items = new Collection($this->items);
        return $itmes;
    }

    /**
     * total amount in the cart
     *
     * @return int
     */
    public function count()
    {
        $itmes = $this->getContent();

        return $itmes->sum('qty');
    }

    /**
     * get total price in the cart
     *
     * @return int
     */
    public function total()
    {
        $items = $this->getContent();

        $total = $items->reduce(function($carry, $item) {
            return $carry + ($item['qty'] * $item['price']);
        });

        return $total;
    }
}
