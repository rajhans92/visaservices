<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

*/
class Subadmin extends Model
{
    use Notifiable;
    protected $fillable = ['id', 'title'];

}
