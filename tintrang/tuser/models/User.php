<?php namespace TinTrang\Tuser\Models;

use Model;


/**
 * Model
 */
class User extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];
    protected $hidden = ['password'];


    /**
     * @var array Validation rules
     */
    public $rules = [
    
    ];

    /**
     * @var string The database table used by the model.
     */
    protected $table = 'tintrang_tuser_';

    /**
     * Encode password 
     * @return encoded string
     */
    static function pwEncode($password) {
        return md5($password);
    }

    static function toLoginPage() {
        return \Redirect::to('/login'); 
    }

    static function toAccountPage() {
        return \Redirect::to('/account'); 
    }

}
