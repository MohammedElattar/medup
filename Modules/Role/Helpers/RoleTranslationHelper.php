<?php

namespace Modules\Role\Helpers;

class RoleTranslationHelper
{
    public static function en(): array
    {
        return [
            'permission' => 'Permission',
            'role' => 'Role',
            'permissions' => 'Permissions',
            'roles' => 'Roles',
            'user_does_not_have_permission' => 'You do not have permission to perform this action.',
            'subscription_type' => 'Subscription Type',
            'have_no_permission' => 'You do not have permission to access this resource',
        ];
    }

    public static function ar(): array
    {
        return [
            'permission' => 'الأذن',
            'role' => 'الدور',
            'permissions' => 'الأذونات',
            'roles' => 'الأدوار',
            'user_does_not_have_permission' => 'ليس لديك إذن لتنفيذ هذا الإجراء.',
            'subscription_type' => 'نوع الاشتراك',
            'have_no_permission' => 'ليس لديك الصلاحيه للوصول لهذا العنوان',
        ];
    }

    public static function ku(): array
    {
        return [
            'permission' => 'مەرجەکان',
            'role' => 'ڕۆڵ',
            'permissions' => 'مەرجەکان',
            'roles' => 'ڕۆڵەکان',
            'user_does_not_have_permission' => 'تۆ دەسەڵاتی ئەنجامدانی ئەم کردارە نییە.',
            'subscription_type' => 'جۆری بەشداری',
            'have_no_permission' => 'تۆ دەسەڵاتی دەسترسی بۆ ئەم بنکە نییە',
        ];
    }
}
