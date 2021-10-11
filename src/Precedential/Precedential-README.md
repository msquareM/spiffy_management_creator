#  PRECEDENTIAL MODULE #####

## Create Table:

-- Import the migration file (2021_07_28_160119_create_precedentials_table) in database/migrations

-- Run # php artisan migrate # in terminal. or below command
-- php artisan migrate --path=/database/migrations/2021_07_28_160119_create_precedentials_table.php

#(or)######

-- run the following sql queries in your database
	
	
	DROP TABLE IF EXISTS `precedentials`;
	CREATE TABLE `precedentials` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `name` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
	  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
	  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `precedentials_name_unique` (`name`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

	INSERT INTO `permissions` (`name`, `display_name`, `description`, `created_at`, `updated_at`)
	VALUES ('manage-precedentials', 'Manage Precedentials', 'Manage Precedentials', now(), now());
	

### Create Controller:

-- Import the controller file (PrecedentialController.php) in app/Http/Controllers/Admin

### Create Datatable:

-- Import the datatable file (PrecedentialDataTable.php) in app/DataTables

### Create Model:

-- Import the model file (Precedential.php) in your project app/Models

### Create View:

-- Import the precedentials folder in resources/views/admin

### Writing Route:

-- # Import the following code in routes/admin.php
-- # Add Below Code Inside of Middleware Auth function (!Important) 

	/** Precedentials */ 

		// Manage Precedentials Routes
		Route::group(['middleware' => 'permission:manage-precedentials'], function () {
			Route::get('precedential', 'PrecedentialController@index');
			Route::match(array('GET', 'POST'), 'add_precedential', 'PrecedentialController@add');
			Route::match(array('GET', 'POST'), 'edit_precedential/{id}', 'PrecedentialController@update')->where('id', '[0-9]+');
			Route::get('delete_precedential/{id}', 'PrecedentialController@delete')->where('id', '[0-9]+');
			Route::match(array('GET', 'POST'), 'update_precedential_status/{id}/{status}', 'PrecedentialController@update_status')->where('id', '[0-9]+');
		});

## Writing in Navigation:

-- # Import the following code in resources/views/admin/common/navigation.blade.php
-- # Paste Below Code Which Order you want show in Side Bar

	<!-- /** Precedential Management */ -->

    @if(Auth::guard('admin')->user()->can('manage-precedentials'))
    	<li class="{{ (Route::current()->uri() == 'admin/precedential') ? 'active' : ''  }}"><a href="{{ url('admin/precedential') }}"><i class="fa fa-globe"></i><span>Manage Precedential</span></a></li>
    @endif

## Writing in Footer For DataTable:

-- # Import the following code in resources/views/admin/common/foot.blade.php

    	Route::current()->uri() == 'admin/precedential'	

## Final Step:

-- # Go to Roles and Permission model

-- # Edit Admin Permission 

-- # Manage Precedentials

-- # Submit