<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userDetails()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    public function subjectGrades()
    {
        return $this->hasMany(SubjectGrade::class);
    }

    public function topicGrades()
    {
        return $this->hasMany(TopicGrade::class);
    }

    public function school()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function userContracts()
    {
        return $this->hasMany(UserContract::class, 'user_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id','id');
    }

    public function teacherClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'teacher_classes', 'user_id', 'class_id');
    }

    public function teacherPersonalClasses()
    {
        return $this->hasMany(TeacherClass::class);
    }

    static public function getAttendance($user_id, $class_id, $attendance_date)
    {
        return StudentAttendance::CheckAlreadyAttendance($user_id, $class_id, $attendance_date);
    }

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'user_id', 'id');
    }

    public function issuedStudent()
    {
        return $this->hasOne(IssuedStudent::class);
    }

    public function issuedStudentArchive()
    {
        return $this->hasMany(IssuedStudentArchive::class);
    }

    public function answers()
    {
        return $this->hasMany(SurveyResponse::class, 'user_id', 'id');
    }

}
