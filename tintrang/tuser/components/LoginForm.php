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
 * This component to show the Login/Signup Form on Page, and handle submited data
 * After Signup, user will receive a notification email. 
 * After login successfuly, user is redirected to Account page.
 */
class LoginForm extends ComponentBase{

    /**
     * Contact form validation rules.
     * @var array
     */
    public $formSignupValidationRules = [
        'name' => 'required|min:2',
        'surname' => 'required|min:2',
        'email' => 'required|email|unique:tintrang_tuser_,email',
        'phone' => 'required|numeric|digits_between:9,10',
        'password' => 'required|confirmed'
    ];

    public $formLoginValidationRules = [
         'email' => 'required|email',
         'password' => ['required']
    ];

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => 'Login Form',
            'description' => 'Show Login & Signup Form'
        ];
    }

    /**
     * AJAX handler called after the Login form has been submitted.
     *
     * @author Tin Trang
     * @return array
     */
    public function onLogin()
    {
  
        // Build the validator
        $validator = Validator::make(post(), $this->formLoginValidationRules, []);

        // Validate
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        
        $email = post('email');
        $password = post('password');
        //validate login credential
        if (!$this->validateLogin($email,$password)) {
            throw new ValidationException(['email/password' =>'Invalid login credentials ']);
        }

        Session::put('user',$email);
        return User::toAccountPage();
    }

    private function validateLogin($email,$password)
    {
        // Check if the email & password is valid.
        $user_count = User::where('email',$email)->where('password',User::pwEncode($password))->count();
        // only correct if we found only 1 record with the given username & password (encoded)
        return ($user_count==1);
    }

    /**
     * AJAX handler called after the Signup form has been submitted.
     *
     * @author Tin Trang
     * @return array
     */
    public function onSignup()
    {
        // Build the validator
        $validator = Validator::make(post(), $this->formSignupValidationRules, []);

        // Validate
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $params = post();
        // Create new user in DB
        try{
            $user = new User;
            $user->name = $params['name'];
            $user->surname = $params['surname'];
            $user->email = $params['email'];
            $user->phone = $params['phone'];
            $user->password = User::pwEncode($params['password']);
            $user->status = 'new';
            $user->save();
            // If everything is fine - send an email
            Mail::sendTo([$user->email => ($user->name .' '. $user->surname)], 'tintrang.tuser::emails.message', $params);
        }   catch(\Exception $e){
            throw new ValidationException(['DB Exception' =>'Cannot create account: '.$e->getMessage()]);
        }

        // -- Use this if we want to redirect user to account page without relogin
        // Session::put('user',$email);
        // return User::toAccountPage();

        return ['error' => false];
    }
    
    public function onRun()
    {
        // Redirect to Account page if user already logged in
        if (Session::has('user')) {
            return User::toAccountPage();
        }

        // Display Message for Registering success
        if (Input::has('Registered')) {
               $this->page["message"] = 'Thank you for Signing up. Your Account is created, please login to continue';
        }

      
    }

}
