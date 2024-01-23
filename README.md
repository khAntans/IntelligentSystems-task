# Simple task manager
## About the app
Simple, single-paged task manager app which allows the user to save, delete and view tasks.

`Developed on PHP version 8.3.1, but should work on any version from 8.0 and above.`<br>

### How to setup:
#### This should get it working
- Copy .env.example file, rename it to jst ".env" and set the database connection parameters.
- Install composer dependencies <code>composer install</code>
- <code>cd public</code> && <code>php -S localhost:8080</code>
#### If it doesn't or you want to modify the css ####
- Do <code>npm install</code> to install tailwind and
<code>npx tailwindcss -i ./input.css -o ./public/style.css --watch</code> to get it working.

### Additional notes / Explanations
- PHP 8.3 is just what i had selected at the time.
- PHP-DI really helped with code organisation, especially at the start when I just wanted to get something showing up on the front.
- Found the details element quite nice for this type of application, since the user doesn't need to always see the task description.

<h5>Index view</h5>
<img src="https://raw.githubusercontent.com/khAntans/images-for-personal-projects/main/Screenshot%20from%202024-01-22%2006-35-05.png?token=GHSAT0AAAAAACMPTQE2GIQQCVJYZSL2R4EIZNQBIOA" alt="index">
<h5>Successful operation</h6>
<img src="https://raw.githubusercontent.com/khAntans/images-for-personal-projects/main/Screenshot%20from%202024-01-22%2006-35-37.png?token=GHSAT0AAAAAACMPTQE3BGURFKZSGCRKNVO2ZNQBI3Q" walt="successful operation">
<h5>Failed Operation</h5>
<img src="https://raw.githubusercontent.com/khAntans/images-for-personal-projects/main/Screenshot%20from%202024-01-22%2006-35-37.png?token=GHSAT0AAAAAACMPTQE3BGURFKZSGCRKNVO2ZNQBI3Q" alt="failed operation">
