<?php

namespace Modules\FcmNotification\Enums;

enum NotificationTypeEnum
{
    // ADMIN Types
    const OFFER_REQUEST_CREATED = 'offer_request_created';

    // Vendor Types
    const OFFER_REQUEST_ACCEPTED = 'offer_request_accepted';

    const OFFER_REQUEST_REJECTED = 'offer_request_rejected';

    const REDEEM_REQUEST_CREATED = 'redeem_request_created';
    const REDEEM_REQUEST_CANCELED = 'redeem_request_canceled';

    // Client Types
    const CHAT = 'chat';

    const BUDDY_REQUEST_SENT = 'buddy_request_sent';

    const BUDDY_REQUEST_ACCEPTED = 'buddy_request_accepted';

    const CLIENT_POKE = 'client_poke';

    const REDEEM_REQUEST_APPROVED = 'redeem_request_approved';

    const REDEEM_REQUEST_REJECTED = 'redeem_request_rejected';

    const INVITATION_APPLIED = 'invitation_applied';

    const SYSTEM_NOTIFICATION = 'system_notification';
}
