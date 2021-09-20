<?php 

namespace App\Data;

use App\Entity\Product;

class Products
{

    public static function getProducts () {
        $products = [];

        $id = 1;
        $product = new Product();
        $product->setId($id);
        $product->setName("Test 1");
        $product->setDescription("Test descrizione 1");
        $product->setImageSrc("path test prodotto 1");

        $products[$id] = $product;

        $id = 2;
        $product = new Product();
        $product->setId($id);
        $product->setName("Test 2");
        $product->setDescription("Test descrizione 2");
        $product->setImageSrc("path test prodotto 2");

        $products[$id] = $product;

        return $products;
    }

}