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

    public function show($otherUserId)
    {
        return  Contract::query()->whereMine($otherUserId)->value('id');
    }

    public function sync(array $data)
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

        if (! $contract) {
            $contract = Contract::query()->create([
                'first_member' => auth()->id(),
                'first_member_details' => $data,
                'second_member' => $otherUserId,
            ]);
        } else {
            $key = $contract->first_member == auth()->id() ? 'first_member_details' : 'second_member_details';

            if ($contract->{$key}) {
                throw new ValidationErrorsException([
                    'name' => translate_word('cannot_edit_contract'),
                ]);
            }

            $contract->update([
                $key => $data,
            ]);
        }
    }
}
