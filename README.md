# coolblue-addresses
Test task for CoolBlue

#Usage:

/address/{id}.{format} - GET method
- Find record by id (integer) and represent output in specified format (html|json|xml)

/address/ - POST method
- Add a new record into data source. POST must contain "name", "phone" and "address"

/address/{id}/ - DELETE method
- Delete a record by its id (integer)

/address/{id}/ - PUT method
- Updates the existing record with new values

Note: all requests should be directed to front controller (index.php). To achieve this a rewrite rule must be added to your web-server configuration.

Example in nginx:

    try_files $uri $uri/ @rewrite;
    location @rewrite {
        rewrite ^/(.*)$ /web/index.php/$1;
    }
