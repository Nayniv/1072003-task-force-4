<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'created_at' => $faker->dateTimeBetween('-1 week')->format('Y-m-d H:i:s'),
    'customer_id' => $faker->numberBetween(1, 40),
    'executor_id' => $faker->numberBetween(1, 40),
    'category_id' => $faker->numberBetween(1, 8),
    'title' => $faker->realText(50),
    'description' => $faker->realText(200),
    'budget' => $faker->numberBetween(1000, 10000),
    'completed_at' => $faker->dateTimeBetween('-1 week', '+10 week')->format('Y-m-d H:i:s'),
    'city_id' => $faker->numberBetween(1, 1000),
    'file_id' => $faker->numberBetween(1, 10)
];