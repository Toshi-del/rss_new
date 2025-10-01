# Visual Acuity Field Not Linking - Debugging Guide

## Issue Description
The visual acuity field entered by nurses in the pre-employment and annual physical examination forms is not appearing in the doctor's view. Instead, it shows "Visual acuity not tested".

## Current Implementation Status

### ✅ Database Schema
- Column exists: `visual` (VARCHAR, nullable) in both:
  - `pre_employment_examinations` table
  - `annual_physical_examinations` table

### ✅ Model Configuration
Both models have `visual` in their `$fillable` arrays:
- `PreEmploymentExamination` (line 24)
- `AnnualPhysicalExamination` (line 24)

### ✅ Form Fields
Both nurse create forms have the visual acuity input field:
- **Pre-Employment**: `resources/views/nurse/pre-employment-create.blade.php` (line 274)
  - Field name: `name="visual"`
  - Required field with validation
  - Textarea for detailed input

- **Annual Physical**: `resources/views/nurse/annual-physical-create.blade.php` (line 238)
  - Field name: `name="visual"`
  - Required field with validation
  - Text input field

### ✅ Controller Validation
Both store methods validate the `visual` field:
- **NurseController::storePreEmployment()** (line 537)
  - Validation: `'visual' => $isAudiometryIshiharaOnly ? 'nullable|string' : 'required|string'`
  - Required unless it's "Audiometry and Ishihara Only" test

- **NurseController::storeAnnualPhysical()** (line 645)
  - Validation: `'visual' => 'required|string'`
  - Always required

### ✅ Doctor's View Display
The doctor's pre-employment edit view displays the visual field:
- File: `resources/views/doctor/pre-employment-edit.blade.php` (line 267)
- Code: `{{ $preEmployment->visual ?: 'Visual acuity not tested' }}`

## Debugging Steps Added

### 1. Logging in NurseController
Added comprehensive logging to track the visual field data flow:

**Pre-Employment Store Method (line 570-594):**
```php
// Log visual field for debugging
\Log::info('Pre-Employment Examination - Visual field data:', [
    'visual' => $validated['visual'] ?? 'NOT SET',
    'request_visual' => $request->input('visual'),
    'all_validated' => array_keys($validated)
]);

// After creation
\Log::info('Pre-Employment Examination created:', [
    'id' => $examination->id,
    'visual' => $examination->visual,
    'visual_from_db' => $examination->fresh()->visual
]);
```

**Annual Physical Store Method (line 686-709):**
```php
// Log visual field for debugging
\Log::info('Annual Physical Examination - Visual field data:', [
    'visual' => $validated['visual'] ?? 'NOT SET',
    'request_visual' => $request->input('visual'),
    'all_validated' => array_keys($validated)
]);

// After creation
\Log::info('Annual Physical Examination created:', [
    'id' => $examination->id,
    'visual' => $examination->visual,
    'visual_from_db' => $examination->fresh()->visual
]);
```

## How to Debug

### Step 1: Check Logs
1. Create a new examination through the nurse interface
2. Fill in the visual acuity field
3. Submit the form
4. Check the Laravel log file: `storage/logs/laravel.log`
5. Look for entries with:
   - "Pre-Employment Examination - Visual field data"
   - "Annual Physical Examination - Visual field data"

### Step 2: Analyze Log Output
The logs will show:
- **visual**: The validated value from the form
- **request_visual**: The raw request input
- **all_validated**: All fields that passed validation
- **visual_from_db**: The value actually saved to the database

### Step 3: Identify the Problem
Based on the log output:

**If `request_visual` is empty:**
- Problem: Form is not submitting the visual field
- Solution: Check form HTML, ensure field name is correct

**If `visual` in validated data is empty:**
- Problem: Validation is stripping the field
- Solution: Check validation rules

**If `visual_from_db` is empty but `visual` has a value:**
- Problem: Model is not saving the field
- Solution: Check model's `$fillable` array and database column

**If all values are present but doctor's view shows "not tested":**
- Problem: Doctor is viewing a different examination record
- Solution: Check examination ID and relationships

## Testing Checklist

- [ ] Create a new pre-employment examination with visual acuity data
- [ ] Check logs to verify data is captured
- [ ] Verify data is saved to database (check via phpMyAdmin or Tinker)
- [ ] View the examination in doctor's interface
- [ ] Confirm visual acuity displays correctly

## Database Query for Manual Verification

```sql
-- Check recent pre-employment examinations
SELECT id, name, visual, created_at 
FROM pre_employment_examinations 
ORDER BY created_at DESC 
LIMIT 10;

-- Check recent annual physical examinations
SELECT id, name, visual, created_at 
FROM annual_physical_examinations 
ORDER BY created_at DESC 
LIMIT 10;
```

## Laravel Tinker Commands

```php
// Check latest pre-employment examination
$exam = \App\Models\PreEmploymentExamination::latest()->first();
echo "Visual: " . $exam->visual;

// Check latest annual physical examination
$exam = \App\Models\AnnualPhysicalExamination::latest()->first();
echo "Visual: " . $exam->visual;
```

## Possible Root Causes

1. **Form Submission Issue**: JavaScript or browser preventing field submission
2. **Validation Stripping**: Validation rules removing the field
3. **Model Mass Assignment**: Field not in `$fillable` array (already verified ✅)
4. **Database Column Missing**: Column doesn't exist (already verified ✅)
5. **Relationship Issue**: Doctor viewing wrong examination record
6. **Caching Issue**: Old data being cached

## Next Steps

1. **Run the test**: Create a new examination and check the logs
2. **Verify database**: Manually check if data is in the database
3. **Clear cache**: Run `php artisan cache:clear` and `php artisan config:clear`
4. **Check browser console**: Look for JavaScript errors preventing form submission
5. **Test with different browsers**: Rule out browser-specific issues

## Contact Information
If the issue persists after following these steps, provide:
- Log output from `storage/logs/laravel.log`
- Database query results
- Screenshots of the form and doctor's view
- Browser console errors (if any)
