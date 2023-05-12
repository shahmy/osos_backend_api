<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'authors' => [
        'name' => 'Authors',
        'index_title' => 'Authors List',
        'new_title' => 'New Author',
        'create_title' => 'Create Author',
        'edit_title' => 'Edit Author',
        'show_title' => 'Show Author',
        'inputs' => [
            'user_id' => 'User',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'contact_no' => 'Contact No',
            'address' => 'Address',
            'status' => 'Status',
        ],
    ],

    'books' => [
        'name' => 'Books',
        'index_title' => 'Books List',
        'new_title' => 'New Book',
        'create_title' => 'Create Book',
        'edit_title' => 'Edit Book',
        'show_title' => 'Show Book',
        'inputs' => [
            'author_id' => 'Author',
            'isbn' => 'Isbn',
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
            'cover_image' => 'Cover Image',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'user_type' => 'User Type',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],
];
