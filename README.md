# php_rest_api

1. Install composer from getcomposer.org
2. Go to root directorye and run composer dump-autoload -o
3. migrate database provider in root directory for the tables.
4. create the localhost server or use php's built in server to create the endpoint

#Product api's

create Product
Endpoint  => /products
type => POST
POST params =>name=prod2&description=asdfasdf&price=23&discount=5&category_id=1

update Product
Endpoint  => /products/id
type => put
PUT params =>name=prod2&description=asdfasdf&price=23&discount=5&category_id=1


Retreive Product
Endpoint  => /products
type => GET

Delete Product
Endpoint  => /products/id
type => DELETE


