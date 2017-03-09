FbLikedPagesFetcher
===================

Service is responsible for fetching of liked pages by a given FB user using graph API.

[![Build Status](https://travis-ci.org/kaz231/events-FbLikedPagesFetcher.svg?branch=master)](https://travis-ci.org/kaz231/events-FbLikedPagesFetcher)

### Usage

Service shares a single cli command that could be used in the following way:

```bash
docker run \
    -e 'FACEBOOK_APP_ID=<APP_ID>' \
    -e 'FACEBOOK_APP_SECRET=<APP_SECRET>' \
    <image> \
    php ./console.php fb:likes:fetch '<fb-access-token>'
```

where:

- __\<fb-access-token\>__ is user's access token (read more [here](https://developers.facebook.com/docs/facebook-login/access-tokens/#usertokens)) with __user_likes__ permission
- __\<APP_ID\>__ is ID of your FB's application
- __\<APP_SECRET\>__ is a secret key for your FB's application

Execution of above command will print list of user's liked pages on Facebook as an array in JSON format:
 
```json
[
   {
      "name":"LikedPage1",
      "id":"1254526551355146",
      "created_time": {
        "date":"2017-03-07 07:22:32.000000",
        "timezone_type":1,
        "timezone":"+00:00"
      }
   },
   {
      "name":"LikedPage2",
      "id":"128412943493106",
      "created_time": {
        "date":"2017-03-07 07:22:32.000000",
        "timezone_type":1,
        "timezone":"+00:00"
      }
   },
   {
      "name":"LikedPageN",
      "id":"110605342308112",
      "created_time": {
        "date":"2017-03-07 07:22:32.000000",
        "timezone_type":1,
        "timezone":"+00:00"
      }
   }
]
```

### Installation

All you have to do to start used it locally is to install project's dependencies using composer tool as follows:

`composer install`

### Tests

Execute simply:

`./vendor/bin/phpunit -c config/phpunit.xml --testsuite unit`

for unit tests and

`./vendor/bin/phpunit -c config/phpunit.xml --testsuite integration`

for integration suite.