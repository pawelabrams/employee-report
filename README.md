# Employee report

## Requirements

1. Generate a report as a command or a controller, containing employees' salaries report for the current month.
   The report should contain first and last name, department, base salary, bonus amount, type of bonus (see below), total salary.
2. The report should be sortable by any column (one per request).
3. The report should be able to be filtered by department name, first name, last name.
4. The bonuses should be generated based on the employee's department rules: either a fixed bonus per a year of contract (capped at 10), or a percentage bonus equal for the whole department.
   For example:
   Adam Kowalski, HR department, has worked for the company for 15 years. His base salary is $1000, and his department uses a $100 bonus per year of contract. His total salary is $1000 + 10 * $100 = $2000.
   Anna Nowak, has worked in customer support department for 5 years. Her base salary is $1100, and her department uses a fixed 10% bonus. Her total salary is $1100 + 10% * $1100 = $1210.
5. Application should be written in PHP and Symfony or Laravel,
6. Code should be accompanied by a reasonable test suite.
7. Code and interfaces are well-documented.
8. *(optional)* Adding employees and departments may be left as a manual INSERT to the database.

## Design decisions

1. Shortened url should consist only of numbers and consonants to avoid meaningful and offending phrases.
2. Chosen name for the url shortening objects' class is "Shorten". This allows the creation endpoint to be most straightforward (POST /shorten) and serves as a nice and short nickname 
3. API endpoints are named after singular form of the entities they represent – this is a personal preference of the author.
4. ApiPlatform was used as a developer-friendly way of achieving the high documentation expectations and ease of adding new features.
5. Unnecessary features were removed from the basic distribution of ApiPlatform to minimise the potential attack surface of the system.
6. Sequential URLs were used.

## Usage

Use `symfony serve` to run the project. The project uses SQLite (`var/data.db`) for maximum portability – this is only for demonstration purposes.

To create an empty database schema, run `bin/console doctrine:schema:create`.
To create a database with example data, run `bin/console doctrine:migrations:migrate`.

To deploy it, either docker scripts should be written or a server should be configured for deployment via other means. Using a standalone RDBMS for production deployment is recommended.

The following addresses should be used to interact with the generator:

| verb | address                              | description                                |
|------|--------------------------------------|--------------------------------------------|
| GET  | http://localhost/                    | Generate this month's report.              |

Use `bin/test` to run the test suite. A separate SQLite databse, `var/test.db` will be used.

