# Data Preservation Fix - Medical Staff Updates

## Problem Identified

The doctor's view was showing "Not recorded" for data fields (skin marks, visual acuity, Ishihara test, findings, lab reports) that were entered by nurses and other medical staff.

### Root Cause

The **PathologistController** was overwriting ALL examination fields when updating lab reports, including fields that were already filled by nurses. When pathologists submitted their lab reports, they were unintentionally clearing data entered by other medical staff.

## Solution Implemented

Modified the PathologistController to use **conditional updates** - only update fields that are actually provided in the request, preserving existing data from other medical staff.

### Files Modified

**File:** `app/Http/Controllers/PathologistController.php`

### Changes Made

#### 1. Pre-Employment Examination Update (Line 1070-1114)
**Before:**
```php
$examination->update([
    'status' => $request->status,
    'lab_report' => $request->lab_report ?? [],
    'visual' => $request->visual,
    'ishihara_test' => $request->ishihara_test,
    'ecg' => $request->ecg,
    'skin_marks' => $request->skin_marks,
    // ... etc (overwrites with null if not provided)
]);
```

**After:**
```php
// Only update lab_report and status - don't overwrite nurse's data
$updateData = [
    'status' => $request->status,
    'lab_report' => $request->lab_report ?? [],
];

// Only update other fields if they are actually provided (not null/empty)
if ($request->filled('visual')) {
    $updateData['visual'] = $request->visual;
}
if ($request->filled('ishihara_test')) {
    $updateData['ishihara_test'] = $request->ishihara_test;
}
// ... etc (only updates if field has value)

$examination->update($updateData);
```

#### 2. Annual Physical Examination Update (Line 963-995)
Applied the same conditional update logic to preserve nurse-entered data.

#### 3. OPD Examination Update (Line 1361-1406)
Applied the same conditional update logic for OPD examinations.

## How It Works

### Data Flow
1. **Nurse** creates examination → Fills: `skin_marks`, `visual`, `ishihara_test`, `findings`, `physical_exam`
2. **Pathologist** updates lab report → Only updates: `lab_report` fields
3. **Doctor** reviews → Sees ALL data from both nurse and pathologist

### Key Benefits
✅ **Preserves nurse data** - Fields entered by nurses remain intact  
✅ **Pathologist focuses on labs** - Pathologists only update their relevant fields  
✅ **Doctor sees complete picture** - All data from all medical staff is visible  
✅ **No data loss** - Prevents accidental overwrites with null values  

## Testing Recommendations

1. **Create a new examination** via nurse
2. **Fill in all required fields** (skin marks, visual, etc.)
3. **Have pathologist update lab report**
4. **Verify doctor can see** both nurse's data AND pathologist's lab results

## Other Controllers Verified

✅ **RadiologistController** - Already using proper update logic (only updates `lab_findings`)  
✅ **EcgtechController** - Already using proper update logic (only updates `ecg` and merges `heart_rate`)  
✅ **DoctorController** - No issues (doctors have full edit access)

## Additional Fix - Nurse Status Setting

### Issue
Nurses were setting examination status to `'pending'` which required manual workflow progression.

### Solution
Changed nurse's store methods to set proper status immediately:
- **Pre-Employment**: Status set to `'Approved'` (immediately visible to doctor)
- **Annual Physical**: Status set to `'completed'` (immediately visible to doctor)

### Files Modified
- `app/Http/Controllers/NurseController.php`
  - `storePreEmployment()` - Line 577: Changed status from `'pending'` to `'Approved'`
  - `storeAnnualPhysical()` - Line 678: Changed status from `'pending'` to `'completed'`
  - Added `'created_by'` field to track which nurse created the examination

## Date Fixed
2025-10-01

## Developer Notes
This fix ensures that:
1. Each medical staff role only updates their specific fields without accidentally clearing data entered by other staff members
2. The `$request->filled()` method checks if a field has a non-empty value before including it in the update
3. Examinations created by nurses are immediately visible to doctors without manual status changes
