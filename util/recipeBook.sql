--If a user wants to save a recipe the RecipeNum

-- Database: 'recipeBook'
DROP DATABASE IF EXISTS recipeBook;
CREATE DATABASE recipeBook DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE recipeBook;

-- Table structure for table 'users'
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  UserNo int(11) AUTO_INCREMENT PRIMARY KEY,
  Username varchar(20) NOT NULL,
  UserEmail varchar(50) NOT NULL,
  UserPassword varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data for table 'users'
INSERT INTO users (Username, UserEmail, UserPassword) VALUES
('Wayland', 'waycar1174@students.ecpi.edu', 'password'),
('Sam', 'samlip5870@students.ecpi.edu', 'password'), -- need to put group members emails password is "password"
('Joshua', '@students.ecpi.edu', 'password'),
('Fenil', 'fenshe2336@students.ecpi.edu', 'password');

-- Table structure for table 'recipes'
DROP TABLE IF EXISTS recipes;
CREATE TABLE recipes (
  RecipeNo int(11) AUTO_INCREMENT PRIMARY KEY,
  RecipeName varchar(20) NOT NULL,
  RecipeDescription varchar(50),
  RecipeSteps varchar(300),
  RecipeCookTime varchar(10),
  Ingredient1 varchar(30),
  Ingredient2 varchar(30),
  Ingredient3 varchar(30),
  Ingredient4 varchar(30),
  Ingredient5 varchar(30),
  Ingredient6 varchar(30),
  Ingredient7 varchar(30),
  Ingredient8 varchar(30),
  Ingredient9 varchar(30),
  Ingredient10 varchar(30),
  FOREIGN KEY (UserNo) int(11) REFERENCES users(UserNo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data for table 'recipes'
INSERT INTO recipes (RecipeName, Ingredient1, Ingredient2, Ingredient3) VALUES
('Peanut Butter and Jelly', 'Crunchy Peanut Butter', 'Grape Jelly', 'Bread'),
('Grilled Cheese', 'American Cheese', 'Bread', '');

-- Table structure for table 'recipes'
DROP TABLE IF EXISTS user_recipe;
CREATE TABLE user_recipe (
  FOREIGN KEY (UserNo) int(11) REFERENCES users(UserNo),
  FOREIGN KEY (RecipeNo) int(11) REFERENCES recipes(RecipeNo),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add user account: User ID: RB_user Password: password
DROP USER IF EXISTS RB_user;
CREATE USER RB_user@'%' IDENTIFIED VIA mysql_native_password USING '*57E231DADC3692408A679455E2F1A399A69FD7BC';
GRANT ALL PRIVILEGES ON recipeBook.* TO RB_user@'%' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
