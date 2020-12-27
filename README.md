This are some instructions to follow for making posible to succeed this api call.
1 php artisan server

2 php artisan migrate

3 run the importStarship route to fill the table with the data fetched from swapi api

4 follow the same for importVehicles.

5 after you have exec the route of the importStarship or importVehicles or both, insert manualy in the table inventories some data. *Example

vehicle_id | starship_id | quantity
    1      | null        | 10
    2      | null 	 | 5
    3      | null 	 | 6
    1      | null 	 | 7
   null    | 10 	 | 10
   null    | 5 	         | 5
   null    | 8 	         | 6
   null    | 6  	 | 7
