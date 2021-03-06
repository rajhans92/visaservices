<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

*/
class Organization extends Model
{
    use Notifiable;
    protected $fillable = ['user_id', 'established_date', 'specialties', 'overview', 'teacher_strength', 'student_strength'];

}
