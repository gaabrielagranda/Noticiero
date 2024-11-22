# Noticiero

## Overview

This project is a dynamic news website that allows users to view news articles categorized by different topics. The website uses PHP, SQL, and JavaScript to fetch and display news articles from a database. Users can select categories to filter news articles and the website remembers user preferences using cookies.

## Features

- **Category Selection**: Users can select news categories from a navigation bar.
- **AJAX Loading**: News articles are loaded dynamically without reloading the page.
- **User Preferences**: The website remembers user preferences for news categories using cookies.
- **Responsive Design**: The website is designed to be responsive and works well on different screen sizes.

## Technologies Used

- **PHP**: Server-side scripting language used to interact with the database and serve dynamic content.
- **SQL**: Database language used to store and retrieve news articles and categories.
- **JavaScript**: Client-side scripting language used for AJAX requests and dynamic content updates.
- **Bootstrap**: CSS framework used for responsive design and styling.

## Project Structure

- `index.php`: Main page that displays news articles and categories.
- `cargardatos.js`: JavaScript file that handles AJAX requests and dynamic content updates.
- `noticia.php`: Page that displays the full content of a selected news article.
- `bd.php`: Database connection file.
- `get_categoria.php`: PHP script to fetch categories from the database.
- `get_datos.php`: PHP script to fetch news articles based on selected category.
- `guardar_cookie.php`: PHP script to log user interactions with news articles.

## Setup

1. **Clone the repository**:
    ```sh
    git clone https://github.com/gaabrielagranda/Noticiero.git
    cd Noticiero
    ```

2. **Set up the database**:
    - Import the provided SQL file to create the necessary tables and insert sample data.

3. **Configure the database connection**:
    - Update the `bd.php` file with your database credentials.

4. **Run the project**:
    - Use a local server environment like XAMPP or WAMP to run the project.

## Usage

- Open the `index.php` file in your browser.
- Select a category from the navigation bar to filter news articles.
- Click on a news article to view its full content.
- The website will remember your preferred category for future visits.

## License

This project is a student proyect.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request for any improvements or bug fixes.
