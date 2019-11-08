# GLPI User equipoment protocol generator
## Description
This is an old project of mine, which creates protocol of equipment base on user name and surname from GLPI.
The strings are currently only in polish, feel free to edit this, or provide updated solution with commit.

## How to use
1. Deploy code to PHP server.
2. Edit the dbconnect.php for database connection details.
3. i recommend to provide your own ./favicon.ico and ./img/logo.jpg
4. Provide the form with name and surname for which you want to generate the protocol
..* The second option is for generating auto-accept monit to this form. If you use the GLPI as an ticketing system in which the user accepts that he takes this equipment. You can use this button to download the acceptance from the "ticket number". This is optional. You can check the code for how it's working.

## Limited Liability
You use this code without any warranty or liability on my side. This code uses only select on the database, but still. This is an old piece of code on which i don't take responsibility for use.