<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditOrder extends Model
{
    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function get_status()
    {
        $status = $this->status;
        switch ($status) {
            case 1:
                $statusMsg = 'Done.';
                break;

            case 2:
                $statusMsg = 'Cancel';
                break;

            default:
                $statusMsg = 'Processing';
                break;
        }
        return $statusMsg;
    }
}
