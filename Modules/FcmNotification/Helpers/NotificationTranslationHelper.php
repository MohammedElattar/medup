<?php

namespace Modules\FcmNotification\Helpers;

class NotificationTranslationHelper
{
    public static function en(): array
    {
        return [
            'you_have_new_message' => 'New Message',
            'notification' => 'Notification',
            'notifications' => 'Notifications',
            'offer_request_created_title' => 'New Offer Request',
            'offer_request_created_body' => 'You have new offer request from :vendorName',
            'buddy_request_sent_title' => 'New Buddy Request',
            'buddy_request_sent_body' => 'sent you a buddy request',
            'buddy_request_accepted_title' => 'Buddy Request Accepted',
            'buddy_request_accepted_body' => 'accepted your buddy request, you are now friends !',
            'offer_request_accepted_title' => 'Offer Request Accepted',
            'offer_request_accepted_body' => 'Your offer request #:id has been accepted',
            'offer_request_rejected_title' => 'Offer Request Rejected',
            'offer_request_rejected_body' => 'Your offer request #:id has been rejected',
            'client_poke_title' => 'Poke',
            'client_poke_body' => 'poked you',
            'redeem_request_title' => 'New Redeem Request',
            'redeem_request_body' => ':clientName sent a redeem request, check it out !',
            'redeem_request_canceled_title' => 'Redeem Request Canceled',
            'redeem_request_canceled_body' => ':clientName canceled the redeem request',
            'redeem_request_approved_title' => 'Redeem Request Approved',
            'redeem_request_approved_body' => ':vendorName approved your redeem request',
            'redeem_request_rejected_title' => 'Redeem Request Rejected',
            'redeem_request_rejected_body' => ':vendorName rejected your redeem request',
            'invitation_applied_title' => 'Invitation Token Applied',
            'invitation_applied_body' => 'Your invitation token has been applied, check your loot now !',
        ];
    }

    public static function ar(): array
    {
        return [
            'you_have_new_message' => 'رسالة جديدة',
            'notification' => 'الإشعار',
            'notifications' => 'الأشعارات',
        ];
    }

    public static function fr(): array
    {
        return [
            'you_have_new_message' => 'Nouveau message',
            'notification' => 'Notification',
            'notifications' => 'Notifications',
        ];
    }
}
