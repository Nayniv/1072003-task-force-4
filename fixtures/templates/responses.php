<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'comment' => $faker->realText(100),
    'budget' => $faker->numberBetween(100, 10000),
    'status' => $faker->numberBetween(0, 1),
    'task_id' => $faker->numberBetween(1, 20),
    'executor_id' => $faker->numberBetween(1, 40)
];