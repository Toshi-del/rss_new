# Patient Dashboard Seeder

This seeder populates the database with comprehensive test data for the patient dashboard functionality.

## What it creates:

### 1. Patient Users (5 accounts)
- **Jane Doe** - patient@rsshealth.com / password
- **John Smith** - john.smith@rsshealth.com / password  
- **Maria Garcia** - maria.garcia@rsshealth.com / password
- **Carlos Rodriguez** - carlos.rodriguez@rsshealth.com / password
- **Ana Martinez** - ana.martinez@rsshealth.com / password

### 2. Appointments (3 appointments)
- Future appointments with different statuses (pending, approved, completed)
- Each appointment has patient records linked by email
- Various appointment types (Annual Physical, Pre-Employment, General Checkup)

### 3. Pre-Employment Records (3 records)
- Different medical exam types
- Various statuses (completed, pending)
- Different companies (AsiaPro, Pasig Catholic College, PrimeLime)

### 4. Pre-Employment Examinations (2 detailed exams)
- Complete medical history and findings
- Physical examination data
- Laboratory results
- ECG results
- Detailed physical and lab findings tables

### 5. Annual Physical Examinations (2 detailed exams)
- Complete medical history and findings
- Physical examination data
- Laboratory results
- ECG results
- Detailed physical and lab findings tables

## How to run:

### Option 1: Run the specific seeder command
```bash
php artisan seed:patient-dashboard
```

### Option 2: Run all seeders (includes this one)
```bash
php artisan db:seed
```

### Option 3: Run with fresh database
```bash
php artisan migrate:fresh --seed
```

## Testing the Dashboard:

1. **Login as a patient** using any of the test accounts above
2. **Navigate to the patient dashboard**
3. **Check the "Tests" tab** to see:
   - Appointments list
   - Pre-employment records list
4. **Check the "Results" tab** to see:
   - Pre-employment examination results
   - Annual physical examination results
5. **Test the search functionality** in the Results tab
6. **Test the "View Details" buttons** (currently shows alerts)

## Data Relationships:

- **Users** → **Patient Records** (by email)
- **Patient Records** → **Appointments** (by appointment_id)
- **Pre-Employment Records** → **Pre-Employment Examinations** (by pre_employment_record_id)
- **Patient Records** → **Annual Physical Examinations** (by patient_id)

## Features Tested:

✅ **Email-based matching** for appointments and records  
✅ **Status indicators** with color coding  
✅ **Search functionality** in results  
✅ **Responsive design** for mobile/desktop  
✅ **Realistic medical data** with proper formatting  
✅ **Multiple examination types** and statuses  

## Notes:

- The seeder uses `firstOrCreate()` to avoid duplicate data
- All passwords are set to "password" for easy testing
- Medical data is realistic but fictional
- The seeder can be run multiple times safely
