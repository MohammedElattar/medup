<?php

namespace Modules\Payment\Services;

use App\Exceptions\ValidationErrorsException;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Traits\UserSetter;
use Modules\Payment\Models\BankAccount;
use Modules\Payment\Models\Builders\BankAccountBuilder;

class BankAccountService
{
    use UserSetter;

    public function index()
    {
        return BankAccount::query()
            ->when(true, fn (BankAccountBuilder $query) => $query->whereMine($this->getUser()))
            ->latest()
            ->with('image')
            ->searchable(['name', 'account_number', 'iban', 'swift_code'])
            ->get();
    }

    public function show($id)
    {
        return BankAccount::query()
            ->with('image')
            ->when(true, fn (BankAccountBuilder $b) => $b->whereMine($this->getUser()))
            ->where('id', $id)
            ->firstOrFail();
    }

    public function store(array $data)
    {
        $this->assertUnique($data['iban'], $data['account_number']);

        DB::transaction(function () use ($data) {
            $hasBankAccount = BankAccount::query()
                ->when(true, fn (BankAccountBuilder $b) => $b->whereMine($this->getUser()))
                ->exists();

            $bankAccount = BankAccount::create($data + [
                'bankable_type' => get_class($this->getUser()),
                'bankable_id' => $this->getUser()->getKey(),
                'default' => ! $hasBankAccount,
            ]);

            if (isset($data['image'])) {
                $imageService = new ImageService($bankAccount, $data);
                $imageService->storeMediaFromFile($data['image'], 'bank_account_image');
            }

            if (isset($data['default'])) {
                $this->makeDefault($bankAccount->id);
            }
        });
    }

    public function update(array $data, $id)
    {
        $bankAccount = $this->findBankAccount($id);

        $this->assertUnique(
            $data['iban'] ?? $bankAccount->iban,
            $data['account_number'] ?? $bankAccount->account_number,
            $bankAccount->id
        );

        DB::transaction(function () use ($data, $bankAccount) {
            $bankAccount->update($data);

            if (isset($data['image'])) {
                $imageService = new ImageService($bankAccount, $data);
                $imageService->updateOneMedia('bank_account_image', 'image');
            }

            if (isset($data['default'])) {
                $this->makeDefault($bankAccount);
            }
        });
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $bankAccount = BankAccount::query()->when(true, fn (BankAccountBuilder $b) => $b->whereMine($this->getUser()))->findOrFail($id);

            if ($bankAccount->default) {
                $this->assignDefaultToAlternative($bankAccount->id);
            }

            $bankAccount->delete();
        });
    }

    public function makeDefault(BankAccount|string $bankAccount): void
    {
        $bankAccount = $bankAccount instanceof BankAccount ? $bankAccount : $this->findBankAccount($bankAccount);

        if ($bankAccount->default) {
            return;
        }

        DB::transaction(function () use ($bankAccount) {
            BankAccount::query()->when(true, fn (BankAccountBuilder $b) => $b->whereMine($this->getUser()))->where('default', true)->update(['default' => false]);
            $bankAccount->forceFill(['default' => true])->save();
        });
    }

    private function assertUnique($iban, $accountNumber, $ignoreId = null)
    {
        $exists = BankAccount::query()
            ->where(fn (BankAccountBuilder $q) => $q->whereMine($this->getUser()))
            ->where(fn ($q) => $q->where('iban', $iban)->orWhere('account_number', $accountNumber))
            ->when(! is_null($ignoreId), fn ($q) => $q->where('id', '<>', $ignoreId))
            ->first();

        if ($exists) {
            if ($exists->iban == $iban) {
                throw new ValidationErrorsException([
                    'iban' => translate_error_message('iban', 'exists'),
                ]);
            }

            throw new ValidationErrorsException([
                'account_number' => translate_error_message('account_number', 'exists'),
            ]);
        }
    }

    private function findBankAccount($id)
    {
        return BankAccount::query()->when(true, fn (BankAccountBuilder $b) => $b->whereMine($this->getUser()))->findOrFail($id);
    }

    private function assignDefaultToAlternative($defaultBankAccountId)
    {
        $alternativeBankAccount = BankAccount::query()
            ->when(true, fn (BankAccountBuilder $b) => $b->whereMine($this->getUser()))
            ->where('id', '<>', $defaultBankAccountId)
            ->first();

        if ($alternativeBankAccount) {
            $alternativeBankAccount->forceFill(['default' => true])->save();
        }
    }
}
