# PasteBin Clone - Running the Application

This is a complete PasteBin clone application built with Laravel, Vue.js 3, and Inertia.js.

## Quick Start

### 1. Install Dependencies
```bash
composer install
npm install --legacy-peer-deps
```

### 2. Setup Environment
```bash
php artisan key:generate
```

### 3. Database Migration
```bash
php artisan migrate
```

### 4. Build Assets
```bash
npm run build
```

### 5. Run the Development Server
Open two terminals:

**Terminal 1 - Start the Laravel server:**
```bash
php artisan serve
```

**Terminal 2 - Start the Vite dev server:**
```bash
npm run dev
```

The application will be available at `http://localhost:8000`

## Features

✅ **Create Pastes** - Create new pastes with optional titles
✅ **View Pastes** - View individual pastes with syntax highlighting
✅ **List Pastes** - Browse all recent pastes with pagination
✅ **Delete Pastes** - Delete your own pastes
✅ **Copy to Clipboard** - Quickly copy paste content
✅ **Responsive Design** - Built with Tailwind CSS for beautiful UI
✅ **Authentication Ready** - User system included for future enhancements

## Project Structure

```
├── app/
│   ├── Models/
│   │   ├── Paste.php           # Paste model
│   │   └── User.php            # User model
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── PasteController.php  # All paste operations
│   │   └── Middleware/
│   ├── Policies/
│   │   └── PastePolicy.php     # Authorization policies
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── AuthServiceProvider.php
├── resources/
│   ├── js/
│   │   ├── Pages/
│   │   │   └── Pastes/
│   │   │       ├── Index.vue   # List all pastes
│   │   │       ├── Create.vue  # Create paste form
│   │   │       └── Show.vue    # View single paste
│   │   ├── app.js
│   │   └── bootstrap.js
│   ├── css/
│   │   └── app.css             # Tailwind CSS
│   └── views/
│       └── app.blade.php       # Main Inertia template
├── routes/
│   └── web.php                 # All web routes
├── database/
│   ├── migrations/
│   │   └── 2026_01_01_184854_create_pastes_table.php
│   └── factories/
└── public/                      # Build output
```

## Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/` | List all pastes |
| GET | `/pastes/create` | Show create form |
| POST | `/pastes` | Store new paste |
| GET | `/pastes/{slug}` | View single paste |
| DELETE | `/pastes/{slug}` | Delete paste |

## Technologies

- **Backend**: Laravel 11
- **Frontend**: Vue.js 3
- **Integration**: Inertia.js
- **Styling**: Tailwind CSS
- **Build Tool**: Vite
- **Database**: SQLite (default)

## Environment Variables

Key environment variables in `.env`:
- `APP_NAME` - Application name (default: PasteBin)
- `APP_URL` - Application URL (default: http://localhost)
- `DB_CONNECTION` - Database connection (default: sqlite)

## Notes

- Pastes are generated with a random 10-character slug
- Pastes can have optional titles
- Delete functionality available for paste owners
- Copy to clipboard feature with visual feedback
- Responsive dark-themed UI with Tailwind CSS
- Authentication system is ready for future user features

## Troubleshooting

**Build errors with npm?**
Use `npm install --legacy-peer-deps` to resolve peer dependency conflicts.

**Database not created?**
Run `php artisan migrate` to create the SQLite database.

**Port 8000 already in use?**
Change the port: `php artisan serve --port=8001`

**Vite dev server issues?**
Clear cache: `npm run dev` will auto-reload if needed.

## Development

For development with hot reload:

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

This will enable Vite's hot module replacement (HMR) for instant updates on file changes.

## Production Build

```bash
npm run build
php artisan config:cache
php artisan route:cache
```

Enjoy your PasteBin clone! 🚀
