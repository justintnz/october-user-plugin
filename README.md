# october-user-plugin
October User Plugin - build as requested by Dream Config

Installation
-----------------------------
Upload folder to [October root]/plugins 
At [October root], run cmd: php artisan plugin:refresh TinTrang.TUser
Login October Backend, and create 2 pages:
  a. Account page ( /account ) 
  b. Login/Signup page (/login ) 
You can change this setting in tuser/models/User.php, static functions : toLoginPage() & toAccountPage()

Limitation
-----------------------------
Because the limit in time & requirement, this plugin missing following feature:
- Missing Account Activation/ Email Verification
- Missing Forgot Password/Reset Password feature
- Missing remember me.
...
  
