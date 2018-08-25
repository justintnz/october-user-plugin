# october-user-plugin
October User Plugin - build as requested by Dream Config

Installation
-----------------------------
1/ Upload folder to [October root]/plugins 
2/ At [October root], run cmd: php artisan plugin:refresh TinTrang.TUser
3/ Login October Backend, and create 2 pages:
  3a. Account page ( /account ) 
  3b. Login/Signup page (/login ) 
4/You can change this setting in tuser/models/User.php, static functions : toLoginPage() & toAccountPage()

Limitation
-----------------------------
Because the limit in time & requirement, this plugin missing following feature:
- Missing Account Activation/ Email Verification
- Missing Forgot Password/Reset Password feature
- Missing remember me.
- Remember the URL before login, to redirect user back to that page after login success.
...
  
