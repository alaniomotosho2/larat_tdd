# larat_tdd REST API (how to run and test it)
  ## cd into lara tdd directory
  ## run < php artisan migrate > (we use sqlite)
  ## check migration file to see the schema of the table
  ## run < php artisan route:list > to see all the available endpoint for CRUDE operations
  #### localhost:8000/api/country (for viewing all <GET>) 
  #### localhost:8000/api/country  (for creation <POST>)
  #### localhost:8000/api/country/{$id} (for update <PUT OR PATCH>) 
  #### localhost:api/country/{$id} (for showing single record <GET>)
  #### localhost:api/country/{$id}  (for deletion <DELETE>)
 ## ensure you have postman installed or maybe Httpie or use curl (preferably postman <GUI>)
  ### every endpoint is aunthenticated therefore ensure that you put authentication tokens {key:value} pair of {'APP_KEY':'MUSTAPHA'} on the header of each request (use postman,it is just below the address bar)
    

## for testcase
### each test case is aunthenticated as well but no need to do anything manually during testing
# cd into test directory
### you can run Unit and Feature test respectively in each directory
### for Unit testing :
#### ./vendor/bin/phpunit tests/Unit/<testFile>
### for Feature testing
#### ./vendor/bin/phpunit tests/Feature/<testFile>

# N.B we use Country table for REST API and Product table for Testing 
