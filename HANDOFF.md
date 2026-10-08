# TastyFood Laravel - Handoff Document
**Date:** 2026-10-08  
**Project:** TastyFood Authentication & Payment System  
**Status:** 95% Complete - Bug Investigation Required  

---

## Critical Bug

**Payment proof images NOT displaying in admin verification page despite:**
- File exists: `storage/app/public/payment-proofs/*.jpg` (verified via `file` command)
- Database record correct: `payments.proof_image` = `payment-proofs/CH9bI9DrfTJJSaOJTir4QDZWssVUXi0UAmP8s1BQ.jpg`
- URL accessible: `curl http://127.0.0.1:8000/storage/payment-proofs/CH9bI9DrfTJJSaOJTir4QDZWssVUXi0UAmP8s1BQ.jpg` returns HTTP 200
- Blade template correct: `<img src="{{ asset('storage/' . $payment->proof_image) }}">`

**Next debug steps:**
1. Check browser DevTools Network tab for actual image request URL
2. Check browser Console for JS errors blocking image load
3. Verify `@if($payment->proof_image)` condition evaluates true (add `@dump($payment->proof_image)`)
4. Test direct URL access in browser address bar
5. Clear Laravel view cache: `php artisan view:clear`

---

## System Overview

**Stack:**
- Laravel 13.34.0
- PHP 8.3
- SQLite (`database/database.sqlite`)
- Tailwind CSS

**Auth:**
- Customer: `User` model with `role='customer'`
- Admin: `User` model with `role='admin'` + `Auth::guard('admin')`
- Passwords: bcrypt via `Hash::make()`
- Sessions: Laravel default

**Storage:**
- Payment proofs: `storage/app/public/payment-proofs/` (5MB max)
- QR codes: `storage/app/public/qr-codes/` (2MB max)
- Symlink exists: `public/storage` → `storage/app/public`

---

## Completed Features

### Phase 1-4: User Authentication
✅ Customer registration (`/register`) with phone + role  
✅ Customer login (`/login`)  
✅ Customer profile view/edit (`/profile`, `/profile/edit`)  
✅ Navbar shows LOGIN/REGISTER for guests, PROFIL/LOGOUT for auth users  

**Controllers:**
- `app/Http/Controllers/Auth/RegisterController.php`
- `app/Http/Controllers/Auth/LoginController.php`
- `app/Http/Controllers/ProfileController.php`

**Views:**
- `resources/views/auth/login.blade.php`
- `resources/views/auth/register.blade.php`
- `resources/views/profile/show.blade.php`
- `resources/views/profile/edit.blade.php`

### Phase 5: Admin Payment Method CRUD
✅ Admin login (`/admin/login`)  
✅ Payment method list (`/admin/payment-methods`)  
✅ Create/edit/delete payment methods with QR code upload  

**Controller:**
- `app/Http/Controllers/Admin/PaymentMethodController.php`

**Views:**
- `resources/views/admin/payment-methods/index.blade.php`
- `resources/views/admin/payment-methods/create.blade.php`
- `resources/views/admin/payment-methods/edit.blade.php`

### Phase 6: Customer Payment Flow
✅ Payment method selection page (`/orders/{order}/payment`)  
✅ Payment record creation with selected method  
✅ Proof upload form (`/payments/{payment}/upload`)  
✅ Proof file storage  
⚠️ Payment status page (`/payments/{payment}/status`) - proof image shows here  

**Controller:**
- `app/Http/Controllers/PaymentController.php`
  - `show()`: display payment method options
  - `store()`: create payment record
  - `uploadForm()`: show upload form
  - `uploadProof()`: handle file upload

**Views:**
- `resources/views/payments/show.blade.php` (JS visual feedback for radio selection)
- `resources/views/payments/upload.blade.php`
- `resources/views/payments/status.blade.php`

### Phase 7: Admin Payment Verification
✅ Payment list with filters (`/admin/payments`)  
✅ Payment detail view (`/admin/payments/{payment}`)  
❌ **BUG:** Proof image not rendering in detail view  
✅ Approve/reject actions  

**Controller:**
- `app/Http/Controllers/Admin/PaymentController.php`
  - `index()`: list with status/date filters
  - `show()`: detail + proof image (NOT WORKING)
  - `approve()`: set status=`paid`, update order
  - `reject()`: set status=`rejected`

**Views:**
- `resources/views/admin/payments/index.blade.php`
- `resources/views/admin/payments/show.blade.php` (BUG HERE)

### Phase 8: Order Integration
✅ Order detail shows payment status  
✅ "Bayar Sekarang" button for unpaid orders  
✅ "Upload Bukti" button for waiting_payment  

**View:**
- `resources/views/orders/show.blade.php`

### Phase 9: Database Seeding
✅ 5 payment methods (3 bank, 1 e-wallet, 1 QRIS)  
✅ Test customer: `rashqaandrean@gmail.com` / (password set by user)  
✅ Test admin: `admin@padangrice.com` / `password`  

**Seeder:**
- `database/seeders/DatabaseSeeder.php`

---

## Database Schema

### New Migrations
1. `2026_10_07_100001_add_phone_and_role_to_users_table.php`
   - `users.phone` (string, unique, nullable)
   - `users.role` (enum: customer/admin, default: customer)

2. `2026_10_07_100002_add_user_id_to_orders_table.php`
   - `orders.user_id` (foreign key → users.id, nullable)

3. `2026_10_07_100003_create_payment_methods_table.php`
   - Columns: `id`, `name`, `type` (bank/e-wallet/qris), `account_number`, `account_name`, `qr_code`, `is_active`, `timestamps`

4. `2026_10_07_100004_create_payments_table.php`
   - Columns: `id`, `order_id`, `payment_method_id`, `amount`, `status` (unpaid/waiting_payment/waiting_verification/paid/rejected), `proof_image`, `admin_notes`, `timestamps`

### Models
- `app/Models/User.php`: added `phone`, `role`; relationships: `orders()`, `payments()`
- `app/Models/Order.php`: added `user()`; relationships: `payment()`
- `app/Models/PaymentMethod.php`: relationships: `payments()`
- `app/Models/Payment.php`: relationships: `order()`, `paymentMethod()`, `user()`

---

## Routes

### Customer Auth
```php
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
```

### Customer Profile (auth required)
```php
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
```

### Customer Payment (auth required)
```php
Route::middleware(['auth'])->group(function () {
    Route::get('/orders/{order}/payment', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/orders/{order}/payment', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}/upload', [PaymentController::class, 'uploadForm'])->name('payments.upload');
    Route::post('/payments/{payment}/upload', [PaymentController::class, 'uploadProof'])->name('payments.upload.store');
    Route::get('/payments/{payment}/status', [PaymentController::class, 'status'])->name('payments.status');
});
```

### Admin Auth
```php
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [Admin\AuthController::class, 'login']);
    Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');
});
```

### Admin Payment Methods (admin auth required)
```php
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::resource('payment-methods', Admin\PaymentMethodController::class);
});
```

### Admin Payment Verification (admin auth required)
```php
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('/payments', [Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [Admin\PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/approve', [Admin\PaymentController::class, 'approve'])->name('payments.approve');
    Route::post('/payments/{payment}/reject', [Admin\PaymentController::class, 'reject'])->name('payments.reject');
});
```

---

## Test Accounts

**Customer:**
- Email: `rashqaandrean@gmail.com`
- Password: (set by user during registration)
- Role: `customer`

**Admin:**
- Email: `admin@padangrice.com`
- Password: `password`
- Role: `admin`

---

## Test Workflow

### Customer Flow
1. Visit `http://127.0.0.1:8000/register` → register as customer
2. Visit `http://127.0.0.1:8000/login` → login
3. Visit `http://127.0.0.1:8000/orders/1` → view order
4. Click "Bayar Sekarang" → redirects to `/orders/1/payment`
5. Select payment method (JS adds yellow border on click)
6. Click "Lanjutkan" → creates payment record
7. Click "Upload Bukti Pembayaran" → upload form
8. Upload image (max 5MB JPEG/PNG) → redirects to status page
9. Status page shows "Menunggu Verifikasi" with proof image

### Admin Flow
1. Visit `http://127.0.0.1:8000/admin/login` → login as admin
2. Visit `http://127.0.0.1:8000/admin/payments` → payment list
3. Filter by status/date if needed
4. Click "Detail" on a payment → **BUG: proof image not showing**
5. Click "Setujui" or "Tolak" → updates payment + order status

---

## Known Issues

### 🔴 Critical: Proof Image Not Rendering (Admin View)
**File:** `resources/views/admin/payments/show.blade.php` line 89-97

**Current code:**
```blade
@if($payment->proof_image)
    <div class="bg-gray-50 rounded-lg p-2 mb-2">
        <img src="{{ asset('storage/' . $payment->proof_image) }}" 
             alt="Bukti Pembayaran" 
             class="w-full rounded-lg border border-gray-300 shadow-sm">
    </div>
    <p class="text-xs text-gray-500 mb-4">
        <span class="font-semibold">File:</span> {{ basename($payment->proof_image) }}
    </p>
@endif
```

**Verified facts:**
- Database: `payments.proof_image = 'payment-proofs/CH9bI9DrfTJJSaOJTir4QDZWssVUXi0UAmP8s1BQ.jpg'`
- File exists: `storage/app/public/payment-proofs/CH9bI9DrfTJJSaOJTir4QDZWssVUXi0UAmP8s1BQ.jpg` (145KB JPEG)
- URL works: `curl http://127.0.0.1:8000/storage/payment-proofs/CH9bI9DrfTJJSaOJTir4QDZWssVUXi0UAmP8s1BQ.jpg` → HTTP 200
- Blade condition: `@if($payment->proof_image)` should be true

**Debug commands:**
```bash
# Check file
cd /home/rasshqa/projects/TastyFood
file storage/app/public/payment-proofs/*.jpg

# Check DB
sqlite3 database/database.sqlite "SELECT id, proof_image FROM payments WHERE id=1;"

# Test URL
curl -I http://127.0.0.1:8000/storage/payment-proofs/CH9bI9DrfTJJSaOJTir4QDZWssVUXi0UAmP8s1BQ.jpg

# Clear cache
php artisan view:clear
php artisan cache:clear
```

**Next steps:**
1. Add `@dump($payment->proof_image)` above the `@if` to verify blade receives value
2. Check browser DevTools → Network tab for actual image request
3. Check browser Console for JS/CORS errors
4. Test direct URL in browser: `http://127.0.0.1:8000/storage/payment-proofs/CH9bI9DrfTJJSaOJTir4QDZWssVUXi0UAmP8s1BQ.jpg`
5. Compare with customer status page (`payments/status.blade.php`) where image DOES show

### 🟡 Minor: CSS `:peer-checked` Not Working
**File:** `resources/views/payments/show.blade.php`

**Status:** Fixed with JavaScript fallback  
Radio button selection now adds `border-yellow-500 bg-yellow-50` classes via JS `change` event listener.

---

## File Structure

```
app/
├── Http/Controllers/
│   ├── Auth/
│   │   ├── LoginController.php
│   │   └── RegisterController.php
│   ├── Admin/
│   │   ├── AuthController.php
│   │   ├── PaymentController.php          # ← BUG HERE (show method)
│   │   └── PaymentMethodController.php
│   ├── PaymentController.php
│   └── ProfileController.php
├── Models/
│   ├── Payment.php
│   ├── PaymentMethod.php
│   ├── Order.php
│   └── User.php
database/
├── migrations/
│   ├── 2026_10_07_100001_add_phone_and_role_to_users_table.php
│   ├── 2026_10_07_100002_add_user_id_to_orders_table.php
│   ├── 2026_10_07_100003_create_payment_methods_table.php
│   └── 2026_10_07_100004_create_payments_table.php
└── seeders/
    └── DatabaseSeeder.php
resources/views/
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── profile/
│   ├── show.blade.php
│   └── edit.blade.php
├── payments/
│   ├── show.blade.php              # Payment method selection (customer)
│   ├── upload.blade.php            # Proof upload form (customer)
│   └── status.blade.php            # Payment status (customer) - image works here
├── admin/
│   ├── payment-methods/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   └── payments/
│       ├── index.blade.php
│       └── show.blade.php          # ← BUG: image not rendering
└── components/
    └── navbar.blade.php            # Auth state handling
storage/
└── app/public/
    ├── payment-proofs/             # Customer proof uploads (3 files exist)
    └── qr-codes/                   # Admin QR uploads (5 files exist)
```

---

## Configuration Notes

### Storage
Symlink created: `php artisan storage:link`  
```
public/storage → storage/app/public
```

### File Upload Limits
- Payment proofs: 5MB max, JPEG/PNG only
- QR codes: 2MB max, JPEG/PNG only
- Validation: `required|image|mimes:jpeg,png,jpg|max:5120` (proofs) / `max:2048` (QR)

### Security
- CSRF: Laravel default (`@csrf` in forms)
- Password: bcrypt via `Hash::make()`
- File validation: mime type + size checks
- Auth middleware: `auth` for customers, `auth:admin` for admin routes
- Authorization: role-based via `User.role` field

### Bug Fix History
1. **Constructor middleware deprecated:** Removed `$this->middleware('auth')` from `PaymentController` (Laravel 11+ doesn't support); moved to route group
2. **Remember token missing:** Added `$table->rememberToken()` to admins migration
3. **CSS peer-checked not working:** Added JS event listener to toggle border/background classes on radio selection

---

## Commands to Run on Pickup

```bash
# Navigate to project
cd /home/rasshqa/projects/TastyFood

# Start server
php artisan serve

# Clear all caches
php artisan view:clear
php artisan cache:clear
php artisan config:clear

# Re-migrate if needed (WARNING: drops all data)
php artisan migrate:fresh --seed

# Check storage symlink
ls -la public/storage

# Verify test accounts
sqlite3 database/database.sqlite "SELECT id, email, role FROM users;"

# Check payment records
sqlite3 database/database.sqlite "SELECT p.id, p.order_id, p.status, p.proof_image, o.order_number FROM payments p JOIN orders o ON p.order_id = o.id;"

# List uploaded files
ls -lh storage/app/public/payment-proofs/
ls -lh storage/app/public/qr-codes/
```

---

## Documentation Files

- `IMPLEMENTATION_SUMMARY.md`: Technical implementation details
- `IMPLEMENTATION_PROGRESS.md`: Step-by-step feature checklist
- `TESTING_GUIDE.md`: Manual testing instructions
- `DOKUMENTASI.md`: Indonesian language docs
- `HANDOFF.md`: This file

---

## Next Agent Actions

1. **Debug proof image rendering:**
   - Add `@dump($payment)` in `admin/payments/show.blade.php` before image section
   - Check browser DevTools Network tab for 404/403 on image request
   - Compare blade code with working customer status page
   - Test if `@if($payment->proof_image)` evaluates true

2. **If image issue persists:**
   - Check `Admin\PaymentController::show()` - verify `$payment->load('paymentMethod')` includes proof_image
   - Check if `Payment` model has any accessors/mutators on `proof_image` attribute
   - Try hardcoded path: `<img src="/storage/payment-proofs/CH9bI9DrfTJJSaOJTir4QDZWssVUXi0UAmP8s1BQ.jpg">`

3. **Once fixed, commit:**
   ```bash
   git add .
   git commit -m "fix: payment proof image display in admin verification"
   git push
   ```

---

**End of handoff. Good luck! 🚀**
