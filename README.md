## LOOP Media WebShop API

### Clone the project
Public Repository link - https://github.com/shwetamishra319/WebShop-API.git

### Setup database
Create a database - WebShop and change the DB credentials in .env file.

Run the artisan command to migrate all tables- `php artisan migrate`

All the migration files are stored in **WebShop-API/database/migrations/** folder and the model files are stored in **WebShop-API/app/Models** folder.

### Import master data from CSV files
ImportMasterData command is stored in **WebShop-API/app/console/commands** folder,

In the ImportMasterData.php file, we define the CSV file URLs for customers and products, and use the **importCustomers** and **importProducts** methods to import the data from the CSV files. For now, I have added the CSV file in **Storage/app/public** folder.

Here I am processing the file in smaller chunks instead of loading the entire file into memory at once. This can help to avoid memory issues when importing large CSV files.
To run the command, we can use the following artisan command- `php artisan import:masterdata`

### Expose Order Data as REST Service

we can perform CRUD operations on orders using the following API endpoints:
- GET /api/orders - Get a list of all orders
- POST /api/orders - Create a new order
- GET /api/orders/{id} - Get a single order by its ID
- PUT /api/orders/{id} - Update an existing order by its ID
- DELETE /api/orders/{id} - Delete an order by its ID

To validate the requests , Request classes are saved in **WebShop-API/app/Http/Requests** folder.
All the methods are written in **WebShop-API/app/Http/Controllers/OrderController** file.

### Create Add-Product-to-Order Endpoint

Validation rules are written in **WebShop-API/app/Http/Requests/AddProductRequest** file.
In OrderController file , there is a method **addNewProductInOrder** in which, implemented the logic to add new product in existing order.
We can retrieve the order with the given ID, and then use the attach() method on the order's relationship with the Product model to attach the product with the given ID to the order.

### Create Pay-Order Endpoint

Defined a new method **makePayment** in the OrderController that handles the POST request to the **/api/orders/{id}/pay** endpoint.
To validate the request , validation rules are written in **WebShop-API/app/Http/Requests/OrderPaymentRequest** file.

The implementation first checks whether the order is already paid and returns an error response if it is. If the payment is successful, the implementation updates the order's payed flag and returns a success response "Payment Successful". If the payment fails, the implementation returns an error response "Insufficient Funds"
