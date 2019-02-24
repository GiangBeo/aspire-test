<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contract_id', 'durations', 'from_date', 'to_date', 'repayment_frequency', 'user_id', 'arrangement_fee', 'interest_rate',
        'total', 'need_to_pay', 'repayment_frequency_pay', 'status'
    ];
}
