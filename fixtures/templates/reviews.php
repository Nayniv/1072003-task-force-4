<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'comment' => $faker->Realtext(100),
    'rate' => $faker->numberBetween(1, 5),
    'task_id' => $faker->numberBetween(1, 20),
];