# 🏗️ Construction Connect – Web Platform for Home Improvement 🏠

Welcome to **Construction Connect**, a modern and user-friendly web platform designed to bridge the gap between people needing home modifications and construction companies ready to offer their services.

---

## 🌟 Project Overview

This website is built using a combination of **HTML**, **CSS**, **PHP**, and **JavaScript** to deliver a seamless experience for users and construction firms alike.

### How it works:

- 🏡 **Users** who want to make changes or improvements to their homes can **post an announcement** describing the work they need done.  
- 🛠️ **Construction companies** browse these announcements and can submit **counter-offers** with their proposals and prices.  
- 🤝 If the user likes an offer, they can **accept** it, enabling the construction work to begin.

---

## 🎨 Design & User Interface

- The website features a **friendly and intuitive interface** to make navigation easy for everyone.  
- On pages like **Home**, **Login**, **Signup**, and **About Us**, a representative background image related to construction is displayed for a professional look.  
- On pages focused on **negotiations** and **matching clients with companies**, an elegant **animated 45-degree gradient background** adds a dynamic and modern touch, with carefully chosen pleasing colors.  

---

## 🔐 Authentication & Security

- Users must **register an account** by providing their **email** and **password**, which are securely stored in a database.  
- The platform supports **login/logout** functionality with **session variables** to maintain user state across pages.  
- Database connections are handled through a **Singleton Design Pattern** in PHP to ensure only one database connection instance exists throughout the application, improving efficiency and security.

---

## ⚙️ Technical Details

- **Database queries** are performed using **SQL**, with a mix of **POST** and **GET** methods used depending on the data submission context in the forms.  
- The use of **POST** ensures sensitive data such as passwords are securely transmitted, while **GET** is utilized when fetching or filtering data without security risks.  
- The project demonstrates good coding practices and separation of concerns, ensuring maintainability and scalability.

---

## 🎥 Video Presentation

Check out the [video presentation here](https://www.youtube.com/watch?v=gywogtObqe8&t=8s) to see the platform in action! 📹✨

---

## 💻 Technologies Used

| Technology | Purpose                     |
|------------|-----------------------------|
| HTML       | Structure and content layout |
| CSS        | Styling and animations       |
| JavaScript | Interactive elements         |
| PHP        | Server-side logic and DB interaction |
| MySQL      | Database management          |

---

## 🚀 Getting Started

To run the project locally:

1. Clone the repository.  
2. Import the database schema into your MySQL server.  
3. Update the database connection details in the PHP singleton class.  
4. Run the website on a local server like **XAMPP** or **MAMP**.  

---

## 📬 Contact & Contributions

Feel free to explore the code, suggest improvements, or contribute new features!

---

Thank you for checking out **Construction Connect**! 🛠️🏡✨  
Building better homes, one connection at a time.

