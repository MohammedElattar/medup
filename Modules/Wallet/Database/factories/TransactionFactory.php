<?php

namespace Modules\Wallet\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Wallet\Entities\Transaction;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
