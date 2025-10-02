Event Booking API
This is a Laravel-based RESTful API for managing events, tickets, bookings, and payments.
Prerequisites

PHP >= 8.1
Composer
MySQL or SQLite
Postman (for testing)
Laravel Sanctum (for authentication)

Installation

Clone the Repository
git clone <repository-url>
cd event-booking-api


Install Dependencies
composer install


Configure Environment

Copy .env.example to .env:cp .env.example .env


Update .env with your database settings (e.g., MySQL or SQLite):DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite

orDB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_booking
DB_USERNAME=root
DB_PASSWORD=




Generate Application Key
php artisan key:generate


Run Migrations and Seeders
php artisan migrate
php artisan db:seed


Start the Server
php artisan serve



Testing

Run Tests

Configure .env.testing (e.g., use SQLite in memory):DB_CONNECTION=sqlite
DB_DATABASE=:memory:


Run migrations for testing:php artisan migrate --env=testing


Execute tests:php artisan test




Test with Postman

Import the EventBookingAPI.postman_collection.json file into Postman.
Set the baseUrl variable to http://localhost:8000/api (or your server URL).
Run Register or Login to obtain a token, then set the token variable.
Test endpoints (e.g., Create Event, Create Booking).



Seeded Data

2 Admins
3 Organizers
10 Customers
5 Events
15 Tickets (3 per event)
20 Bookings (distributed across customers and tickets)

Endpoints

Auth:
POST /api/register: Register a user (returns token).
POST /api/login: Login (returns token).
POST /api/logout: Logout (requires token).
GET /api/me: Get authenticated user (requires token).


Events:
GET /api/events: List events (supports ?search, ?date, ?location).
GET /api/events/{id}: Show event with tickets.
POST /api/events: Create event (admin/organizer only).
PUT /api/events/{id}: Update event (admin/organizer only).
DELETE /api/events/{id}: Delete event (admin/organizer only).


Tickets:
POST /api/events/{event_id}/tickets: Create ticket (admin/organizer only).
PUT /api/tickets/{id}: Update ticket (admin/organizer only).
DELETE /api/tickets/{id}: Delete ticket (admin/organizer only).


Bookings:
POST /api/tickets/{id}/bookings: Create booking (customer only).
GET /api/bookings: List user bookings (customer only).
PUT /api/bookings/{id}/cancel: Cancel booking (customer only).


Payments:
POST /api/bookings/{id}/payment: Process payment (customer only).
GET /api/payments/{id}: Show payment (customer only).


