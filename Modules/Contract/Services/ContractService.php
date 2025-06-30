<?php

namespace Modules\Contract\Services;

use App\Exceptions\ValidationErrorsException;
use App\Models\User;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Contract\Models\Contract;

class ContractService
{
    public function index()
    {
        return Contract::query()->whereMine()->get();
    }

    public function show($id)
    {
        return Contract::query()->whereMine()->findOrFail($id);
    }

    public function chatShow($otherUserId)
    {
        return  Contract::query()->whereMine($otherUserId)->value('id');
    }

    public function store(array $data)
    {
        $otherUserId = $data['other_user_id'];
        unset($data['other_user_id']);

        $contract = Contract::query()->whereMine($otherUserId)->first();
        $otherUser = User::query()->where('type', '<>', UserTypeEnum::ADMIN)->where('id', '<>', auth()->id())->where('id', $otherUserId)->exists();

        if (! $otherUser) {
            throw new ValidationErrorsException([
                'other_user_id' => translate_error_message('user', 'not_exists'),
            ]);
        }

        if($contract) {
            $contract->update($data);
        } else {
            $contract = Contract::query()->create($data + [
                'first_member' => auth()->id(),
                'second_member' => $otherUserId,
            ]);
        }
    }
}
