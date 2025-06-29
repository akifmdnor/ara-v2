# Laravel 8 + Vue 2 + Tailwind CSS + Laravel Mix

This project is built using:

- Laravel 8 (Blade for SSR and SEO)
- Vue 2 (for interactive UI)
- Tailwind CSS (for styling)
- Laravel Mix (for compiling frontend assets)

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
}
```

---

## 🛠️ Compile Assets

| Command            | Description                        |
|--------------------|------------------------------------|
| `npm run dev`      | Compile for development            |
| `npm run watch`    | Watch files and auto-compile       |
| `npm run prod`     | Compile and minify for production  |

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
import Login from './components/auth/Login.vue';
new Vue({ el: '#app', components: { Login } });
```

---

## ✅ Tested With

- Laravel 8.x
- Node.js 16+
- Vue 2.7
- Laravel Mix 6.x
- Tailwind CSS 3.x

---

## 📬 Support

Open an issue or contact the maintainer if you run into problems.
