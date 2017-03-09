FbLikedPagesFetcher
===================

Service is responsible for fetching of liked pages by a given FB user using graph API.

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

- __\<fb-access-token\>__ is user's access token (read more [here](https://developers.facebook.com/docs/facebook-login/access-tokens/#usertokens))
- __\<APP_ID\>__ is ID of your FB's application
- __\<APP_SECRET\>__ is a secret key for your FB's application

Execution of above command will print list of user's liked pages on Facebook as an array in JSON format:
 
```json
[
   {
      "name":"LikedPage1",
      "id":"1254526551355146",
      "created_time":"2017-03-07T07:22:32+0000"
   },
   {
      "name":"LikedPage2",
      "id":"128412943493106",
      "created_time":"2017-03-07T07:14:31+0000"
   },
   {
      "name":"LikedPageN",
      "id":"110605342308112",
      "created_time":"2017-02-28T18:05:12+0000"
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