<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
    ];

    public function country() {
        // in product model, it belongs to a country where it compares country_id with primary key of country table
        return $this->belongsTo(Country::class,'country_id')->select('id','country_name');
    }

    public static function getCalculatedTops($bust,$waist) {
        // Compare Bust and Waist
        // Size L
        if (($bust>=37 && $bust<=40) && ($waist>=30 && $waist<=33)) {
            if ($bust=40) {
                $note = "For Fit Size Suggest Size L, if bit loose is preferred may choose 1 size up.";
            }
            $size = "L";
        }
        // Size XL
        else if (($bust>=40 && $bust<=43) && ($waist>=33 && $waist<=36)) {
            if ($bust=43) {
                $note = "For Fit Size Suggest Size XL, if bit loose is preferred may choose 1 size up.";
            }
            $size = "XL";
        }
        // 2XL
        else if (($bust>=43 && $bust<=45) && ($waist>=36 && $waist<=38)) {
            if ($bust=45) {
                $note = "For Fit Size Suggest Size 2XL, if bit loose is preferred may choose 1 size up.";
            }
            $size = "2XL";
        }
        // 3XL
        else if (($bust>=45 && $bust<=49) && ($waist>=38 && $waist<=42)) {
            if ($bust=49) {
                $note = "For Fit Size Suggest Size 3XL, if bit loose is preferred may choose 1 size up.";
            }
            $size = "3XL";
        }
        // 4XL
        else if (($bust>=49 && $bust<=53) && ($waist>=42 && $waist<=46)) {
            if ($bust=53) {
                $note = "For Fit Size Suggest Size 4XL, if bit loose is preferred may choose 1 size up.";
            }
            $size = "4XL";
        }
        else {
            $note = "";
            $size = "Size Not Available";
        }
        return array('size'=>$size,'note'=>$note);
    }

    public static function getCalculatedBottoms($waist,$hip) {
        // Compare Waist and Hips
        // Size L
        if (($waist>=30 && $waist<=33) && ($hip>=40 && $hip<=43)) {
            if ($bust=40) {
                $note = "For Fit Size Suggest Size L, if bit loose is preferred may choose 1 size up.";
            }
            $size = "L";
        }
        // Size XL
        else if (($waist>=33 && $waist<=36) && ($hip>=43 && $hip<=46)) {
            if ($bust=43) {
                $note = "For Fit Size Suggest Size XL, if bit loose is preferred may choose 1 size up.";
            }
            $size = "XL";
        }
        // 2XL
        else if (($waist>=36 && $waist<=38) && ($hip>=46 && $hip<=48)) {
            if ($bust=45) {
                $note = "For Fit Size Suggest Size 2XL, if bit loose is preferred may choose 1 size up.";
            }
            $size = "2XL";
        }
        // 3XL
        else if (($waist>=38 && $waist<=42) && ($hip>=48 && $hip<=52)) {
            if ($bust=49) {
                $note = "For Fit Size Suggest Size 3XL, if bit loose is preferred may choose 1 size up.";
            }
            $size = "3XL";
        }
        // 4XL
        else if (($waist>=42 && $waist<=46) && ($hip>=52 && $hip<=56)) {
            if ($bust=53) {
                $note = "For Fit Size Suggest Size 4XL, if bit loose is preferred may choose 1 size up.";
            }
            $size = "4XL";
        }
        else {
            $note = "";
            $size = "Size Not Available";
        }
        return array('size'=>$size,'note'=>$note);
    }
}
