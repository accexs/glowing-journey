<?php

/*
 * $p   -> product info array
 * $o   -> order info
 * $ext -> extended info
 */

/*
 * $items -> array holding all order items
 * $ext_p -> prices by id
 * $sp -> flag to indicate special price
 * $cd -> flag to indicate product deleted
 *
 * In general it looks like the functions processes some sort of order data tha
 * includes items  and their quantities and prices.
 *
 * First loop: iterates over elements on $ext that contains what it looks like
 * some sort of extender information, then it creates $ext_p as an associative
 * array using id as key and qty as value
 *
 * Second loop: iterates over the array $o which seems to be the order data.
 * It creates a product array using the id. Conditionally adding the qty  and sets
 * a flag for possible deleted products. Depending on a match between $ext_p and $p
 * products id's it sets a flag for $sp (possible a special price) or $cd
 *  - First if: checks for the item price on $ext_p, if found checks if the qty is
 *    less than 1 and sets it as deleted. Else it just adds the qty to the product
 *    array
 *      - Else if: checks for a match between $item and what's on $p array (id)
 *        and sets $sp flag.
 *      - Else: marls product as deleted and sets $cd flag
 *
 * If condition: if the flag $sp was set to false it adds the id on $p with a qty
 * of 1. to the $items array
 *
 * Third loop: iterates over the elements left on $ext_p and adds items to the
 * $items array
 *  - If condition makes sure no items with a qty less than 1 gets added to the
 *    $items array.
 *
 */

function test($p, $o, $ext)
{
    $items = [];
    $sp = false;
    $cd = false;

    $ext_p = [];

    foreach ($ext as $i => $e) {
        $ext_p[$e['price']['id']] = $e['qty'];
    }

    foreach ($o['items']['data'] as $i => $item) {
        $product = [
          'id' => $item['id'],
        ];

        if (isset($ext_p[$item['price']['id']])) {
            $qty = $ext_p[$item['price']['id']];
            if ($qty < 1) {
                $product['deleted'] = true;
            } else {
                $product['qty'] = $qty;
            }
            unset($ext_p[$item['price']['id']]);
        } else {
            if ($item['price']['id'] == $p['id']) {
                $sp = true;
            } else {
                $product['deleted'] = true;
                $cd = true;
            }
        }

        $items[] = $product;
    }

    if (!$sp) {
        $items[] = [
          'id' => $p['id'],
          'qty' => 1,
        ];
    }

    foreach ($ext_p as $i => $details) {
        if ($details['qty'] < 1) {
            continue;
        }

        $items[] = [
          'id' => $details['price'],
          'qty' => $details['qty'],
        ];
    }

    return $items;
}