<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'created_at' => $faker->dateTimeBetween('-2 week')->format('Y-m-d H:i:s'),
    'email' => $faker->unique()->email,
    'login' => $faker->firstName,
    'password' => md5($faker->word()),
    'date_of_birth' => $faker->date('Y-m-d', '1996-10-21'),
    'phone' => substr($faker->e164PhoneNumber, 1, 11),
    'telegram' => "@{$faker->unique()->word}",
    'rating' => $faker->numberBetween(1, 50),
    'city_id' => $faker->numberBetween(1, 1000),
    'avatar_file_id' => $faker->numberBetween(1, 20),
    'is_customer' => $faker->numberBetween(0, 1)
];