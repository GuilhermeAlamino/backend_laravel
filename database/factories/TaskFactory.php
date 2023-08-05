<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use App\Employee;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    $employee = Employee::inRandomOrder()->first(); // Obter um funcionário aleatório

    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'assignee_id' => $employee->id, // Atribuir o id do funcionário aleatório
        'due_date' => $faker->dateTimeThisMonth, // Data aleatória deste mês para a data de vencimento
    ];
});
