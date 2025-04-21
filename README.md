## About Project

This project is **Weather Forecast** built with **Laravel**, **Vue.js** and **Tailwind CSS**. It provides **display weather forecast**, **download forecast in Excel file** using Laravel as backend and Vue.js for frontend.

## Features

- Displaying all states according to updates via Command Schedule.
- Showing cities for given states, and for which it is possible to display weather
- Show the weather forecast for the whole week at different times within a 3-hour horizon
- Download weather forecast in Excel
- Search for countries and cities
- Routing and page management handled by Inertia.js

## Technologies Used

- **Laravel**: Backend framework for handling requests, routing, and database management.
- **Vue.js**: Frontend framework used to build the user interface and handle dynamic interactions.
- **Inertia.js**: Handles routing between pages, providing a single-page application (SPA) experience without the need for an API. It enables direct communication between Vue.js and Laravel.
- **Tailwind CSS**: A utility-first CSS framework for building custom designs without writing custom CSS.

## Requirements

- PHP >= 8.x
- Composer
- Node.js (which includes NPM)
- Laravel 11.x (or higher)
- Vue.js
- Tailwind

## Project Setup

To get started, follow these steps:

**1. Create the environment file:**
   - Copy the contents of `.env.example` to a new file named `.env`.

**2. Add API key:**
   - Add the key in the `.env` file to `WEATHER_KEY`.

**3. Install dependencies:**
   - Run the following commands in your terminal:
     - `composer update`
     - `php artisan key:generate`
     - `npm install`
       
**4. Run the project:**
   - Start the Laravel server by running:
     - `php artisan serve`
   - Start the development server for Vue.js by running:
     - `npm run dev`

**5. Import current countries** 
    - Enter the command
     - `php artisan countries:load`

**6. The project is now ready to use.**

## License

This project is licensed under the **Samuel Šteiner License**.

- **Free for personal and educational use.**
- **Not allowed for commercial use or redistribution as a part of any product.**
- **May not be used as a base for proprietary projects.**

If you'd like to contribute or use it for commercial purposes, please contact the author.

---

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
