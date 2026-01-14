# Business Form Management System

The **Business Form Management System** is a Laravel-based web application that allows users to submit business information through a **4-step guided form**. Submitted data is managed via a dedicated **Admin CMS panel**, where administrators can **review, approve, or reject** submissions.

The system also provides a **business card listing** with search and sorting features. **Admin and User panels are fully separated**, ensuring proper role-based access and clean CMS management.

---

## Features

### Multi-Step Business Form (User Panel)
- 4-step guided business submission form
- Step-by-step validation
- Submit complete business profiles
- Secure and structured data handling

---

### Business Card Listing
- Search business cards by keywords
- Sorting functionality
- Only **approved** businesses are publicly visible
- Clean and responsive UI

---

###  Admin CMS Panel
- Separate admin dashboard
- View all submitted business forms
- Approve or reject submissions
- Status-based management (Pending / Approved / Rejected)
- Full control over user-submitted data

---

### User CMS Panel
- Separate user dashboard
- View submitted business forms
- Track approval or rejection status
- Manage own submissions


---

## Technology Stack
- **Backend:** Laravel
- **Frontend:** Blade
- **Database:** MySQL
- **Authentication:** Laravel Auth
- **Version Control:** Git & GitHub

---


# How to run
#### First clone the repo. To do that open your terminal and run bellow code

``if you use SSH ``
> git clone origin git@github.com:asifmdhasan/business-form.git


``if you use HTTPS ``
> git clone origin https://github.com/asifmdhasan/business-form.git

#### Run the composer command to get all the packages with into vendor directory
> composer install

#### Install NPM
>  npm install 

#### Create `` .env `` file from `` .env.example ``. To do that go to project directory and run

>  cp .env.example .env

#### Generate app key

>  php artisan key:generate


#### Changes the database configuration in `` .env `` file

>DB_DATABASE=your_database_name

>DB_USERNAME=root

>DB_PASSWORD=


#### Run the migration command to get all the table into your database
> php artisan migrate




