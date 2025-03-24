<?php

namespace Modules\Markable\Entities\Builders;

use Illuminate\Database\Eloquent\Builder;
use Modules\Chat\Models\ConversationMessage;

class ReactionModelBuilder extends Builder
{
    public function whereIsMessage($id)
    {
        return $this
            ->where('markable_type', ConversationMessage::class)
            ->where('markable_id', $id);
    }
}
