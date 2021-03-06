<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

*/
class Teacher extends Model
{
    use Notifiable;
    protected $fillable = ['user_id', 'dob', 'specialties', 'overview', 'education', 'experience', 'organization_id'];

}
