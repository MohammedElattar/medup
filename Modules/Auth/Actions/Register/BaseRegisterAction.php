<?php

namespace Modules\Auth\Actions\Register;

use App\Exceptions\ValidationErrorsException;
use App\Models\User;
use App\Services\ImageService;
use Closure;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Enums\AuthEnum;
use Modules\Auth\Services\UserService;
use Modules\Auth\Strategies\Verifiable;
use Modules\City\Services\CityService;
use Modules\Speciality\Services\AdminSpecialityService;

class BaseRegisterAction
{
    public function __construct(private CityService $cityService, private AdminSpecialityService $adminSpecialityService)
    {

    }
    /**
     * @throws ValidationErrorsException
     */
    public function handle(array $data, Verifiable $verifiable, ?Closure $closure = null, bool $byAdmin = false)
    {
        $this->cityService->exists($data['city_id']);
        $this->adminSpecialityService->exists($data['speciality_id']);

        try {
            return DB::transaction(function () use ($data, $closure, $verifiable, $byAdmin) {

                if (isset($data['phone'])) {
                    UserService::columnExists($data['phone']);
                }

                if (isset($data['email'])) {
                    UserService::columnExists($data['email'], columnName: 'email', errorKey: 'email');
                }

                $user = User::create($data + [
                        'status' => false,
                        ...$this->mergeByAdminFields($byAdmin),
                    ]);

                $imageService = new ImageService($user, $data);
                $imageService->storeOneMediaFromRequest('avatar', 'avatar');;

                if ($closure) {
                    $closure($user, $data);
                }

                $verifiable->sendCode($user);

                return $user;
            });
        } catch (ValidationErrorsException $e) {
            throw $e;
        } catch (Exception $e) {
            $message = $e->getMessage();

            if (str_contains(strtolower($message), strtolower("[HTTP 400] Unable to create record: Invalid 'To' Phone Number"))) {
                $message = translate_word('invalid_phone_number');
            }

            if(str_contains(strtolower($message), strtolower("[HTTP 401] Unable to create record: Authenticate"))) {
                $message = translate_word('failed_to_authenticate');
            }

            $errors['operation_failed'] = $message;

            throw new ValidationErrorsException($errors);
        }
    }

    private function mergeByAdminFields(bool $byAdmin = false)
    {
        return $byAdmin ? [
            AuthEnum::VERIFIED_AT => now(),
            'status' => true,
        ] : [];
    }
}
