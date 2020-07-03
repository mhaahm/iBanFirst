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

To start the tests:
 - You must create a copy of the .env.test file in the root of the project which must be named .env.test.local
 - It is then necessary to inform the parameters by changing the ***** by the good values
    API_USERNAME : The api login user
    API_PASSWORD : The api password
    BASE_API_URL : The api base url (this is the url of the api without until api/ Exemple : https://sandbox2.ibanfirst.com/api/)

