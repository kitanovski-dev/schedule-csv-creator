## About Schedule CSV Creator

This is a simple example of creating a CSV file from created code patterns. Please keep in mind that this code is used for test and can be improved.
This app creates a specific schedule for those parameters:  
    - Vacuuming 21 minutes
    - Window cleaning 35 minutes
    - Refrigerator cleaning 50 minutes
    
The application generates a CSV file containing the planning for the next three months. The CSV file contains a column with the date, a column with the activities to be performed, and a column with the total time (in HH:MM format).

This app can be used in two ways:
    - From the command line (php artisan export:schedule)
            - for this purpose, I have created a custom command "export:schedule"
    - From the web URL: http://127.0.0.1:8000/import-export - please use Apache, Nginx, etc. as your servers, or start your server locally from your project (php artisan serve).

For the purpose to create CSV file in this app I have used this package installed with composer (please check composer.json): 
   - maatwebsite/excel

I tried to use the SOLID principle to create this code.  
This code can be expanded, upgraded, and recreated with more dynamic structures by using DB. 
