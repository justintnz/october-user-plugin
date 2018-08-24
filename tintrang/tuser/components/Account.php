<?php

namespace TinTrang\TUser\components;


use Cms\Classes\ComponentBase;
use Illuminate\Support\MessageBag;
use Mail;
use Validator;
use ValidationException;
use Request;
use Input;
use Session;
use TinTrang\TUser\Models\Settings;
use TinTrang\TUser\Models\User as User;
/**
 * This compnonent to show user profile with feature for update and logout
 * After User click logout, he/she will be redirected to login page
 * After User click update He/she will get the confirmation if the request is success or not
 * If user want to update the password, he/she will need to provide current password.
 */
class Account extends ComponentBase{
   
    public $formUpdateValidationRules = [
        'name' => 'required|min:2',
        'surname' => 'required|min:2',
        'phone' => 'required|numeric|digits_between:9,10',
        'current_password'=>'required_with:password',
        'password' => 'required_with:password_confirmation|confirmed',
        'password_confirmation'=>'required_with:password'
    ];

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => 'Account',
            'description' => 'Show Account'
        ];
    }

    public function onRun()
    {
        // Redirect to login page if user not logged in
        if (!Session::has('user')) {
            return User::toLoginPage();
        }

        $user = User::where('email',Session::get('user'))->first();
        // Logout if User data is not found
        if (!$user) {
            return $this->onLogout();
        }
       $this->page["user"] = $user->toArray();

    }
    public function onUpdate()
    {
        $validator = Validator::make(post(), $this->formUpdateValidationRules, []);

        // Validate
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $params = post();
        if (!empty($params['password'])){
            // Update account with new password 
            $user = User::where('email',Session::get('user'))
                            ->where('password',User::pwEncode($params['current_password']))->first();
        } else {
            $user = User::where('email',Session::get('user'))->first();
        }
        if (!$user) { 
            // For some reason, we cannot found the valid account for update
            throw new ValidationException(['Data Exception' =>'Cannot update profile. Recheck your password']);
        } 

        try {
            $user->name = $params['name'];
            $user->surname = $params['surname'];
            $user->phone = $params['phone'];
            if (!empty($params['password'])) {
                $user->password = User::pwEncode($params['password']);
            }
            $user->save();
        }   catch(\Exception $e){
            throw new ValidationException(['DB Exception' =>'Cannot update profile: '.$e->getMessage()]);
        }

        return ['error' => false];
    }

    public function onLogout()
    {
        // destroy session
        Session::forget('user');
        Session::flush();
        return User::toLoginPage();
    }
    
}
