<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use App\Department;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    $department = Department::inRandomOrder()->first(); // Obter um departamento aleatório

    return [
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'department_id' => $department->id, // Atribuir o id do departamento aleatório
    ];
});
