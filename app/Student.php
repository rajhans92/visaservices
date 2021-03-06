<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

*/
class Student extends Model
{
    use Notifiable;
    protected $fillable = ['user_id', 'dob', 'education', 'about'];

}
