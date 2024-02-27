


# Recruitment Assignment

## Backend (Laravel) Assignment

### Purpose

The purpose of the Backend assignment is to create a simple RESTful API using Laravel that allows users to perform CRUD operations on a resource called "clients." Only authenticated users should be able to perform the CRUD.

### Implementation Details

1. **Database Setup**
   - Created a new Laravel project and connected it to a MySQL Database.
   - Installed and set up Laravel Sanctum for authentication.

2. **Database Migrations and Model**
   - Created migration files for the Database tables: Users (Modified the existing migration file) and Clients table.
   - Modified the default User model to include fields: name, email, password.
   - Created the Client model with fields: name, gender, dob, marital_status, and approval_status.

3. **Routes and Controller Methods**
   - **Protected Routes**
     - **GET /api/v1/clients**
       - **Description:** Retrieve all clients resources.
       - **Controller Method:** `index()` in `ClientController`.

     - **GET /api/v1/clients/{client}**
       - **Description:** Retrieve a specific client by ID.
       - **Controller Method:** `show(Client $client)` in `ClientController`.

     - **POST /api/v1/clients**
       - **Description:** Create a client resource.
       - **Controller Method:** `store(Request $request, ClientRepository $clientRepository)` in `ClientController`.

     - **PATCH /api/v1/clients/{client}**
       - **Description:** Update an existing client resource.
       - **Controller Method:** `update(Request $request, Client $client, ClientRepository $clientRepository)` in `ClientController`.

     - **DELETE /api/v1/clients/{client}**
       - **Description:** Delete a client resource.
       - **Controller Method:** `destroy(Client $client, ClientRepository $clientRepository)` in `ClientController`.

     - **PATCH /api/v1/clients/{client}/approve**
       - **Description:** Toggle client resource approval status.
       - **Controller Method:** `approve(Client $client)` in `ClientController`.

     - **POST /api/v1/logout**
       - **Description:** Revoke the access token.
       - **Controller Method:** `logout()` in `AuthController`.

   - **Public Routes**
     - **POST /api/v1/register**
       - **Description:** Create a new user.
       - **Controller Method:** `register(Request $request)` in `AuthController`.

     - **POST /api/v1/login**
       - **Description:** User authentication to generate a token to access protected routes.
       - **Controller Method:** `login(Request $request)` in `AuthController`.

**NB:**
- **Routes Best Practices:**
    - API routes versioning.
    - Each resource with its own route file. The Route files are recursively loaded in api.php file.
    - The Routes are protected using auth::sanctum middleware.

- **Controller Best Practices:**
    - Noticed in the ClientController the use of ClientRepository.
    - The ClientRepository which extends the BaseRepository handles Create, Update, and Delete operations of the controller.
    - This keeps the Controller precise (cleaner) and maintainable.
    - There is also validation of input data for both Client and User Controller.
    - Utilized a resource class for the Client controller to make it return consistent JSON responses to the client.

## Frontend (Angular) Assignment

### Purpose

Build a Frontend Application using Angular to consume the created Laravel API.

### Implementation Details

### Implementation Details

1. Components
   - Register and Login components: Register and Authenticate a user for them to be able to interact with the CRUD for client resource.
   - Clients: After a user is successfully authenticated, they are navigated to the Clients component which fetches a list of resources from the server and displays them in a table. Client approval status can be toggled (Approve/Withdraw approval) based on client approval status.
   - Utilized interceptors to intercept the requests being sent to the server after successful authentication. The interceptor adds the authorization header using the auth token received after authentication to requests.

## Other 
- HTML: For markup.
- CSS: For styling.







