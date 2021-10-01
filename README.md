## I named this app as "The Great Comics"


## Problem Statement
Creating a simple PHP application that allows users to subscribe on this application and send email that contain random comics at every 5 minutes.

  
### Constraints

 - Application should include email verification to avoid people using others’ email addresses.
 - It must be done in core PHP including API calls, recurring emails, including attachments should happen in core PHP.
 - Do not use any libraries.

### How to use this application

 - First user needs to subscribe with valid email and otp will be sent to that email.
 - ##### OTP might take some time please wait a minute and refresh your email(slow server response)
 - After entering correct otp, user account will be activated
 - And user will get XKCD comics at every 5 minutes via subscribed email.
 - Now if user wants to unsubscribe, click on the unsubscribe link that has been sent to the mail which contains comics image, and verify your email, and you will be unsubscribed from the mailing list.


### How it is implemented

 - This application is simply built with basic concepts of HTML,CSS and PHP.
 - I've used mail function to send the mails.
 - Email verification step is also included so no one can use other's email address without authentication.
 - I've tried to make it safe from vulnerabilities like SQL injection.


 ### Resources that I've used
 - VSCode as editor.
 - GoDaddy hosting to host the website.
 - PHP mail function to send mails.
 - cPanel cronjob service to send comics mail at every 5 minutes.

 ## Live demo link:
 - #### You can see live demo of the applicaton by [cliking this link](http://thegreatcomics.hopto.org)

 ### Note:
 - Sending OTP might take some time may be 1 minute;
 - Because there is a problem from server side (server might be slow) 
 - BECAUSE it works completely fine in localhost without any delay
 - So I request you to please cooperate with application
 - Please wait a minute, don't close the verification page, and refresh your email after 1 minute