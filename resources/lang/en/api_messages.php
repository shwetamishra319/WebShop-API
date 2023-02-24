<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Response Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during add update delete etc for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    /**** Api Messages Start From Here ******/
    'no_record' => ['success' => false, 'error_message' => 'No record found.', 'statusCode' => 400],
    'failure' => ['success' => false, 'error_message' => 'Something Went Wrong!', 'statusCode' => 400],
    'order' => [
        'already_paid' => ['success' => false, 'error_message' => 'Order has already been paid', 'statusCode' => 400],
        'product_added' => ['success' => true, 'success_message' => 'Product added to order', 'statusCode' => 200],
        'delete' => ['success' => true, 'success_message' => 'Deleted successfully.']
    ]
    /**************** End Here **************/
];