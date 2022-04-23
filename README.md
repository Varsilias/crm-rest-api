### Project SetUp

1. Run `git clone git@github.com:danielokoronkwo-coder/crm-rest-api.git`.
2. Move into your project directory by running `cd crm-rest-api`
3. Run `composer install` to install all the project dependencies
4. Run `composer copy:env` to create a `.env` file in the project root
5. If **4** above does not work(which usually occurs if your terminal is not one of the unix-based terminals like bash, zsh etc), Manually Create a `.env` file at the root of the project directory
6. Run `php artisan jwt:secret` to generate a **JWT Secret** that will be used o sign and verify tokens across the application

7. Copy the content of the `.env.example` file and paste in your newly created `.env` file
8. Updated the `.env` file with the necessary variables.

### Database Setup

1. Update the `.env` file with the **Database credentials**
2. Run `php artisan migrate --seed` to **migrate** the database tables and also **seed** the tables with some dummy data

### Start Application
- Run `php artisan serve` to start the application development server
- Run `php artisan route:list` to list all the available route that exists in the application
- Sip some coffee while going through the code, you will enjoy it :sweat_smile:

### Extra

I acknowledge that there are ways to make this code way better that what it currently looks like, being that this is a task for a job, I implemented the most important feature required of me at the shortest possible time(3 days)

#### API Documentation
I have included the PostMan Collection in the project root folder for easily testing out the API endpoints available