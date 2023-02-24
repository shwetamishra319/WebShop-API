## WebShop

### Create a new laravel project 
composer create-project laravel/laravel WebShop

### Create database tables and models
Create the necessary database tables and models. Here are the migration files that we'll need to create:

- php artisan make:model Customer -m
- php artisan make:model Product -m
- php artisan make:model Order -m
- php artisan make:model OrderProduct -m

Run the artisan command to migrate all tables.
- php artisan migrate

'Note that the Order model defines a customer() method that returns a relationship with the order's customer, and a products() method that returns a relationship with the products associated with the order. The Product model is associated with the Order model using a many-to-many relationship, and the intermediate table is specified by the OrderProduct model.'

### Create an Artisan command to import master data from CSV files

we can create the command using the make:command Artisan command:
- php artisan make:command ImportMasterData

In the ImportMasterData.php file, we define the CSV file URLs for customers and products, and use the importCustomers and importProducts methods to import the data from the CSV files. For now, I have added the CSV file in Storage/app/public path.

To run the command, we can use the following artisan command:
- php artisan import:masterdata

### Expose Order Data as REST Service

we can perform CRUD operations on orders using the following API endpoints:
- GET /api/orders - Get a list of all orders
- POST /api/orders - Create a new order
- GET /api/orders/{id} - Get a single order by its ID
- PUT /api/orders/{id} - Update an existing order by its ID
- DELETE /api/orders/{id} - Delete an order by its ID

We can create the OrderController and define the methods-

- php artisan make:controller OrderController

### Create Add-Product-to-Order Endpoint

Create an endpoint to attach a product to an existing order, we can define a new method on the OrderController that handles the POST request to the **/api/orders/{id}/add** endpoint.

To validate the request , need to create a Request class using below artisan command - 
- php artisan make:request AddProductRequest

In this file, we can set the validation rule.
In OrderController file , create a new method **addNewProductInOrder** and implement the logic to add new product in existing order.
In this method, we can retrieve the order with the given ID, and then use the attach() method on the order's relationship with the Product model to attach the product with the given ID to the order.

### Create Pay-Order Endpoint

Define a new method **makePayment** in the OrderController that handles the POST request to the **/api/orders/{id}/pay** endpoint.
To validate the request , need to create a Request class using below artisan command - 
- php artisan make:request OrderPaymentRequest

The implementation first checks whether the order is already paid and returns an error response if it is. If the payment is successful, the implementation updates the order's payed flag and returns a success response "Payment Successful". If the payment fails, the implementation returns an error response "Insufficient Funds"