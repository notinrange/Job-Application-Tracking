
---
## (Application Overview Video Link)[https://drive.google.com/file/d/199RGFtRAycy1Ccu4cyoe2ilTJYt6rcvw/view?usp=sharing] 
## Functionality Details

### 1. Candidate Application Submission

- **Controller:**  
  The `CandidateController@store` method validates the candidate input (name, email, job designation, etc.) and handles file uploads (resume). After creating a candidate record, it sends a confirmation email using the `CandidateSubmissionMail` mailable and then redirects to a thank-you page.

- **Mailables:**  
  - `CandidateSubmissionMail` loads the `emails.candidate_submission` Blade view.
  - The corresponding view (located at `resources/views/emails/candidate_submission.blade.php`) contains the email content notifying the candidate that their application is received and will be reviewed.

### 2. HR Admin Dashboard Overview

- **Controller:**  
  `HRDashboardController@index` queries the database to retrieve live statistics:
  - **Total Job Postings:** Count of distinct job designations.
  - **Applications Last 30 Days:** Count of applications where `created_at` is within the last 30 days.
  - **Pending, Approved, and Rejected Applications:** Counted based on the candidate’s `status`.

- **View:**  
  The `resources/views/hr/dashboard.blade.php` view displays the above statistics using Tailwind CSS for a responsive layout. The data is dynamically inserted from the controller’s variables.

### 3. Application Tracking with Responsive Filters

- **Controller:**  
  `CandidateController@index` retrieves all candidate applications from the database and passes them to the view.

- **View:**  
  The `resources/views/hr/applications.blade.php` view uses Alpine.js to implement client‑side filtering:
  - The complete list of applications is passed as JSON.
  - Filters for job, city, college, and graduation year are bound using `x-model` directives.
  - A computed property (`filteredApplications`) dynamically filters the list based on the entered criteria.
  - The filtered data is rendered in a table without reloading the page.

### 4. HR Reports

- **Controller:**  
  `HRReportsController@index`:
  - Calculates the average time (in seconds, then converted to hours) between the `created_at` and `updated_at` timestamps for applications that have been actioned (approved/rejected).
  - Retrieves the number of applications per job designation for the last 30 days.
  - Prepares arrays (`jobLabels` and `jobCounts`) to be used in Chart.js.

- **View:**  
  The `resources/views/hr/reports.blade.php` view:
  - Displays the calculated average time as text.
  - Uses Chart.js (included via CDN) to render a bar chart that shows the job designation trend. The chart data is dynamically populated using JSON-encoded variables from the controller.

### 5. HR Admin Authentication (Login & Registration)

- **Controller:**  
  The `HRAuthController` manages:
  - **Login:**  
    - The `showLoginForm` method renders the login view.
    - The `login` method validates credentials using Laravel’s `Auth::attempt` and redirects to the dashboard upon success.
  - **Registration:**  
    - The `showRegisterForm` method displays the registration form.
    - The `register` method validates input, creates a new user (HR admin), hashes the password, logs the user in automatically, and redirects to the dashboard.
  - **Logout:**  
    - The `logout` method logs the user out and invalidates the session.

- **Routes:**  
  Routes for HR login (`/hr/login`), registration (`/hr/register`), and logout (`/hr/logout`) are defined in `routes/web.php` under the `/hr` prefix. Protected routes (dashboard, application tracking, reports) use Laravel’s `auth` middleware.

- **Views:**  
  - `resources/views/hr/login.blade.php`: Contains the login form.
  - `resources/views/hr/register.blade.php`: Contains the registration form.
  - Both views are styled with Tailwind CSS.

### 6. File Storage & Email

- **File Uploads:**  
  Candidate resumes are stored in the `storage/app/public/resumes` directory. A symbolic link is created using `php artisan storage:link` so that files are accessible via `public/storage/resumes`.

- **Email Views:**  
  - `resources/views/emails/candidate_submission.blade.php` for candidate application confirmation.
  - `resources/views/emails/application_action.blade.php` for notifying candidates when their application status is updated (approved or rejected).

---

## How to Run & Test the Application

1. **Clone the Repository and Install Dependencies:**
   ```bash
   git clone <repository-url>
   cd <project-directory>
   composer install
   npm install
   npm run dev  # if using Laravel Mix for asset compilation

2. **Configure Environment Variables:**
  - Copy `.env.example` to `.env`.
  - Set your database credentials, mail server details, and other configuration variables.
  - Generate an application key:
    ```bash
    php artisan key:generate
    ```

3. **Run Database Migrations:**
  ```bash
  php artisan migrate
  ```

4. **Create the Storage Symlink:**
  ```bash
  php artisan storage:link
  ```

5. **Start the Application:**
  ```bash
  php artisan serve
  ```


6. **Test Functionality:**  

- **Candidate Application**:
    Visit the home page, fill out the form, and submit an application.
- **HR Admin Registration & Login:** Navigate to `/hr/register` to create an account, then log in at `/hr/login`.
- **Dashboard, Tracking & Reports:** Once logged in, view the dynamic dashboard, apply filters on the application tracking page, and view reports.
