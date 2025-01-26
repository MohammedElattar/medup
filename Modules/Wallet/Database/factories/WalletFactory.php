<?php

namespace Modules\Wallet\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Wallet\Entities\Wallet;

class WalletFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wallet::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'balance' => 0,
        ];
    }
}
