# iBanFirst
**1.Installation** <br>
Open an umulator console (git bach or cmder ....)
in the directory where you will install the project

After making the project clone <br>
git clone https://github.com/mhaahm/iBanFirst.git <br>
•	If composer is installed: <br>
      compose install <br>
•	If not: <br>
      php composer.phar install

**2.Configuration**

To start the application in tests mod:
 - You must create a copy of the .env.test file in the root of the project which must be named .env.test.local
 - It is then necessary to inform the parameters by changing the ***** by the good values<br>
    API_USERNAME : The api login user<br>
    API_PASSWORD : The api password<br>
    BASE_API_URL : The api base url (this is the url of the api without until api/ Exemple : https://sandbox2.ibanfirst.com/api/)<br>

To start the application in prod mod:
 - You must create a copy of the .env file in the root of the project which must be named .env.local
 - It is then necessary to inform the parameters by changing the ***** by the good values<br>
    API_USERNAME : The api login user<br>
    API_PASSWORD : The api password<br>
    BASE_API_URL : The api base url (this is the url of the api without until api/ Exemple : https://sandbox2.ibanfirst.com/api/)<br>


**2.Execution**

To run the tests:
 - Open an umulator console (git bach or cmder ....)
   in the application directory.
 - Run the **bin/phpunit** command
 
To run application
 - Open an umulator console (git bach or cmder ....)
    in the application directory.
 - Run php -S localhost:8000 -t public/
 
 open the application in a browser
 
