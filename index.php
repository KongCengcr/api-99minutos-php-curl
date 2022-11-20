<?php
include_once './DeliveryMinutos.php';

use Delivery\Delivery_minutos;

$delivery = new Delivery_minutos();

$data = [
    "shipments" => [
        [
            "internalKey" => "",
            "deliveryType" => "NXD",
            "sender" => [
                "firstName" => "Esteban",
                "lastName" => "Ramirez",
                "phone" => "+52999999999",
                "email" => "esteban@gmail.com"
            ],
            "recipient" => [
                "firstName" => "Carlos",
                "lastName" => "Gonzalez",
                "phone" => "+52999999999",
                "email" => "esteban@gmail.com"
            ],
            "origin" => [
                "lat" => 19.413574,
                "lng" => -99.11359,
                "address" => "Av. del Taller 451, Jardín Balbuena, Álvaro Obregón, 15900 Ciudad de México, CDMX, México",
                "country" => "MEX",
                "reference" => "Primer Piso",
                "zipcode" => "15900"
            ],
            "destination" => [
                "lat" => 19.041694,
                "lng" => -98.2035678,
                "address" => "Av 9 Pte 308, Centro histórico de Puebla, Puebla, Pue., México",
                "reference" => "Torre 3 Apartamente 905",
                "country" => "MEX",
                "zipcode" => "72000"
            ],
            "payments" => [
                "paymentMethod" => "cash",
                "cashOnDelivery" => [
                    "amount" => 100,
                    "currency" => "MXN"
                ]
            ],
            "options" => [
                "pickUpAfter" => "2022-02-01T08:00:00.000Z",
                "twoFactorAuth" => false,
                "notes" => "**Information to be printed on the label**"
            ],
            "items" => [
                [
                    "size" => "s",
                    "description" => "lorem ipsum",
                    "weight" => 1000,
                    "length" => 50,
                    "width" => 30,
                    "height" => 20
                ]
            ]
        ]
    ],
    "draft" => true
];

$createOrder = $delivery->request('orders', 'POST', $data);

$orders = $delivery->request('orders?page=1', 'GET', '');

echo '<pre>';
print_r($createOrder);
print_r($orders);
echo '</pre>';
