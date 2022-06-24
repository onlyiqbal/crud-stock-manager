<?php

function getDatabaseConfig(): array
{
     return [
          "database" => [
               "test" => [
                    "url" => "mysql:localhost=3306;dbname=db_stock_test",
                    "username" => "root",
                    "password" => ""
               ],
               "prod" => [
                    "url" => "mysql:localhost=3306;dbname=db_stock",
                    "username" => "root",
                    "password" => ""
               ]
          ]
     ];
}
