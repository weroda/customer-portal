<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\Presenters\DatePresenter;

class Comment extends Model
{
    // use DatePresenter;
 
    // fields can be filled
    protected $fillable = ['body', 'user_id', 'ticket_id', 'ticket_stripes_removed'];
   
    public function post()
    {
      return $this->belongsTo('App\Ticket');
    }
   
    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
