<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportAttachment extends Model
{
    public function supportMessage()
    {
        return $this->belongsTo('App\Models\SupportMessage','support_message_id');
    }
}
