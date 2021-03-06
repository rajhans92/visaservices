<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

*/
class Subadmin extends Model
{
    use Notifiable;
    protected $fillable = ['user_id', 'dob', 'post'];

}
