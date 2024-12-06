# PHP Developer Role - Technical Test 
We have a network of companies that we would like to be able to match with users looking for services in their area. The network is still growing and right now and we only have companies covering Birmingham (B), Bristol (BS) and Cardiff (CF). 

Unfortunately the dev looking after this project ran into some trouble and committed some broken and unfinished code. Can you help us out?

## Prerequisites  
1. A LAMP environment running PHP ^7
2. Set the DocumentRoot for the project in your Apache config or virtual hosts config
3. Import companies and matching settings from *project.sql* into a database and connect to the app

## Requirements
1. Using data submitted in *resources/views/layouts/form.twig*, find a maximum of **3 random** companies that cover:
    - the postcode prefix of the postcode entered
    - the number of bedrooms specified
    - the type specified
2. Deduct a credit from all companies matched
3. Return a view with a list of companies matched

### Tips and hints
- Getting a 500 error and not sure what's going on? What environment are you in? Do you expect to see errors?
- It looks like there are some methods in the form controller that are called but not defined. Is this unfinished or has the dev forgotten something?
- Can't connect to your database? Have you set the connection settings?
- Getting errors in your views? Have you checked your blocks?

#### Bonus points
- Prevent the form from being submitted twice by disabling the submit button on first submit
- Reveal/Hide additional company information by clicking on the **more** link on the results page
- Install a logger and log to file whenever a company runs out of credits


---

## Instructions for Running Tests

Follow these steps to ensure that the application and its tests run correctly:

1. **Install Dependencies**
   Before running any tests, ensure all dependencies are installed. Use the following command:
   ```bash
   composer install
   ```

2. **Run Unit Tests**
   Execute the PHPUnit test suite to verify the correctness of individual units like repositories and services:
   ```bash
   ./vendor/bin/phpunit
   ```

3. **Run Integration Tests**
   Test the integration between components, such as the repository interacting with the database:
   ```bash
   ./vendor/bin/phpunit tests/Integration
   ```

4. **Run Feature Tests**
   Simulate user interaction and verify end-to-end behavior of the application:
   ```bash
   ./vendor/bin/phpunit tests/Feature
   ```

   You can also run specific test files or directories:
   ```bash
   ./vendor/bin/phpunit <test-file-or-directory>
   ```

---

## Additional Notes
- Ensure you have the correct database setup before running integration tests. Import **`project.sql`** to create the required tables and seed the data.
- Review your `.env` or configuration file to confirm database connection details.
- You can customize the PHPUnit configuration in **`phpunit.xml`** to fit your development environment.

