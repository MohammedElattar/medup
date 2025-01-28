<?php

namespace Modules\Auth\Actions\Register;

use Modules\Auth\Strategies\Verifiable;
use Modules\Student\Models\Student;

class StudentRegisterAction
{
    public function __construct(private readonly BaseRegisterAction $baseRegisterAction){

    }

    public function handle(array $data, Verifiable $verifiable)
    {
        $this->baseRegisterAction->handle($data, $verifiable, function($user) use ($data){
            Student::query()->create($data + ['user_id' => $user->id]);
        });
    }}
