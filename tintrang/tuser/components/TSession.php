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

class TSession extends ComponentBase{


    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => 'Session',
            'description' => 'Embed to Page head'
        ];
    }

    
    
    public function onRun()
    {
        if (!Session::has('user')) {
            return \Redirect::to('/login/'); 
        }
    }

    
}
