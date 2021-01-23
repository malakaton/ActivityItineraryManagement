# Requirements

To use this docker-compose.yml, you will need:

- Docker engine > 19.03
- docker-compose > 1.26

Both are available in the [Docker official site](https://docs.docker.com/install/)_

## Project set up

Install and run the application. Execute this command on ActivityItineraryManagement folder
```
docker/up
```

You are done, you can now work with all app features developed

If you want close docker compose, run this:

```bash
$ docker-compose down
```

# How it works?

Here are the `docker-compose` built images:

* `activityitinerarymanagement_mysql_1`: This is the MySQL database container,
* `activityitinerarymanagement_mysql_test_1`: This is the MySQL database container for testing environment,
* `activityitinerarymanagement_php_1`: This is the PHP-FPM container including the application volume mounted on,
* `activityitinerarymanagement_nginx_1`: This is the Nginx webserver container in which php volumes are mounted too,

This results in the following running containers:

```bash
> $ docker-compose ps
             Name                                   Command                   State                 Ports
----------------------------------------------------------------------------------------------------------------------
activityitinerarymanagement_php_1             docker-php-entrypoint php-fpm     Up              9000/tcp            
activityitinerarymanagement_mysql_1           docker-entrypoint.sh mysqld       Up              3306/tcp, 33060/tcp
activityitinerarymanagement_nginx_1           nginx -g daemon off;              Up              0.0.0.0:80->80/tcp 
```

# Run the app and how to see code coverage

When you executed the command docker/up, a database seeder was executed and create all the schema and tables to work with the app

This is the MySQL tables involved:
```bash
    Name                                   Info                 
----------------------------------------------------------------------------------------------------------
itineraries                       Itineraries created -- only one created by default when seeder is executed 
activities                        Activities created -- A1 to A15 created
students                          Students created - only one by default when seeder is executed 
activities_itineraries            Activities involved in a determinate itinerary - You need to add the activities to itinerary with the specific endpoint to do this function
evaluations                       Evaluation of activites that student fhas been finished in a determinate itinerary
```


Use Postman or other IDE to run the endpoints:

List of all endpoins

```bash
http://symfony.localhost:80/api/itineraries/99f951bf-7d49-4a1a-9152-7bdee1f5ce2e/activity -- List the activities of the specified itinerary.
http://symfony.localhost:80/api/itineraries/99f951bf-7d49-4a1a-9152-7bdee1f5ce2e/activity?name=A1 -- Add an activity to specified itinerary.
http://symfony.localhost:80/api/students/70f066f6-1cb7-4c45-97e2-287f0258ba02/itinerary/99f951bf-7d49-4a1a-9152-7bdee1f5ce2e/activity/evaluate?activity_name=A3 -- Evaluate the answer of activity from itinerary done by student.
http://symfony.localhost:80/api/students/70f066f6-1cb7-4c45-97e2-287f0258ba02/itinerary/99f951bf-7d49-4a1a-9152-7bdee1f5ce2e/activity/next -- Calculate the next activity that student need to do on the activity itinerary
http://symfony.localhost:80/api/students/70f066f6-1cb7-4c45-97e2-287f0258ba02/itinerary/99f951bf-7d49-4a1a-9152-7bdee1f5ce2e/evaluation -- Get all activities with his score and time done by student from determinate activity itinerary.
```

> ####*Note: you can see all endpoint documentation on http://symfony.localhost/api/doc 

Endpoints only accept request and resource in JSON format

Put correct content-type header: application/json

> Example request in json format:

```json
{
  "answer": "1_0_2",
  "inverted_time": 90
}
```

Also, you can see a report of the code coverage done by php unit.

To run test and reports for see code coverage.

Run tests
```
docker/test --coverage-html app/public/reports/
```

You can see reports on, symfony/app/public/reports folder


![Alt Text](https://64.media.tumblr.com/723987e60ebfffeb744f84fa92e52245/tumblr_neglojBBbo1sx56xso1_400.gif)
<br>
"We are amidst strange beings, in a strange land."
<br><br>
Solaire De Astora
