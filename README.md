# Laravel 8 + Vue 2 + Tailwind CSS + Laravel Mix

This project is built using:

-   Laravel 8 (Blade for SSR and SEO)
-   Vue 2 (for interactive UI)
-   Tailwind CSS (for styling)
-   Laravel Mix (for compiling frontend assets)

---

## 📁 Folder Structure

```text
resources/
├── css/
│   └── app.css                  # Tailwind CSS entry
├── js/
│   ├── app.js                   # JS entrypoint (Vue + Mix)
│   └── components/
│       └── auth/
│           └── Login.vue        # Vue component for login page
├── views/
│   ├── layouts/
│   │   └── app.blade.php        # Blade layout template
│   └── login.blade.php          # Page using Vue login component
webpack.mix.js                   # Laravel Mix config
tailwind.config.js               # Tailwind config
```

---

## 🚀 Installation

### 1. Clone & Install Backend

```bash
git clone <your-repo-url>
cd <your-repo-name>
composer install
cp .env.example .env
php artisan key:generate
```

Update `.env` to match your DB settings if needed.

---

### 2. Install Node & Frontend Packages

```bash
npm install
```

---

### 3. Configure Tailwind (if needed)

If `tailwind.config.js` doesn't exist yet:

```bash
npx tailwindcss init
```

Then update it:

```js
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
```

---

## 🛠️ Compile Assets

| Command         | Description                       |
| --------------- | --------------------------------- |
| `npm run dev`   | Compile for development           |
| `npm run watch` | Watch files and auto-compile      |
| `npm run prod`  | Compile and minify for production |

---

## 🖥️ Run Laravel

```bash
php artisan serve
```

Then open: [http://localhost:8000/login](http://localhost:8000/login)

---

## 🧩 Vue Usage

Vue components go inside:

```
resources/js/components/
```

In `resources/js/app.js`, import and mount them as needed.

Example:

```js
import Login from "./components/auth/Login.vue";
new Vue({ el: "#app", components: { Login } });
```

---

## ✅ Tested With

-   Laravel 8.x
-   Node.js 16+
-   Vue 2.7
-   Laravel Mix 6.x
-   Tailwind CSS 3.x

---

## 📬 Support

Open an issue or contact the maintainer if you run into problems.

---

## 🚗 Distance Filtering

The car listing system now includes distance-based filtering using Mapbox API:

### Features

-   **10km Radius Filter**: Only shows cars from branches within 10km of pickup location
-   **Caching**: Distance calculations are cached for 24 hours to reduce API calls
-   **Fallback**: Uses branch coordinates if pickup coordinates are not provided
-   **Error Handling**: Graceful handling of API failures

### Configuration

Add your Mapbox API key to your `.env` file:

```
MAPBOX_API_KEY=your_mapbox_api_key_here
```

---

## 🐳 Docker Development Setup

This project includes a complete Docker setup for PHP 7.3 development.

### Prerequisites

- Docker Engine
- Docker Compose

### Quick Start

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd ara-v2
   ```

2. **Start the containers:**
   ```bash
   make up
   # or
   docker-compose up -d
   ```

3. **Install PHP dependencies:**
   ```bash
   make install
   # or
   docker-compose exec app composer install
   ```

4. **Set up the application:**
   ```bash
   make key
   make migrate
   make seed
   ```

5. **Access the application:**
   - Web: http://localhost:8000
   - PHP Container: `make shell`

### Available Commands

```bash
# Build containers
make build

# Start containers
make up

# Stop containers
make down

# Restart containers
make restart

# View logs
make logs

# Access PHP container shell
make shell

# Install dependencies
make install

# Generate app key
make key

# Run migrations
make migrate

# Seed database
make seed

# Run tests
make test

# Clear caches
make cache
```

### Container Architecture

- **PHP 7.3 FPM**: Application server with all required extensions
- **Nginx**: Web server and reverse proxy
- **Redis**: Caching and session storage

### Configuration

- PHP configuration: `docker/php/local.ini`
- Nginx configuration: `docker/nginx/conf.d/app.conf`
- Docker Compose: `docker-compose.yml`

The setup uses your existing database configuration - no MySQL container is included as requested.

---

### How It Works

1. When user selects a pickup location with coordinates
2. System calculates distance from pickup to each car's branch
3. Only cars within 10km radius are displayed
4. Distance is shown on each car card
5. Results are cached to minimize API calls
