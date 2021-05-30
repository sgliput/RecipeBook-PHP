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
('Sam', 'samlip5870@students.ecpi.edu', 'password'),
('Joshua', '@students.ecpi.edu', 'password'),
('Fenil', 'fenshe2336@students.ecpi.edu', 'password');

-- Table structure for table 'recipes'
DROP TABLE IF EXISTS recipes;
CREATE TABLE recipes (
  RecipeNo int(11) AUTO_INCREMENT PRIMARY KEY,
  RecipeName varchar(50) NOT NULL,
  RecipeDescription varchar(100) NOT NULL,
  RecipeSteps varchar(300) NOT NULL,
  RecipeCookTime varchar(30) NOT NULL,
  Ingredient1 varchar(30) NOT NULL,
  Ingredient2 varchar(30),
  Ingredient3 varchar(30),
  Ingredient4 varchar(30),
  Ingredient5 varchar(30),
  Ingredient6 varchar(30),
  Ingredient7 varchar(30),
  Ingredient8 varchar(30),
  Ingredient9 varchar(30),
  Ingredient10 varchar(30),
  IsPublic int(1) NOT NULL,
  ImgFile varchar(50),
  UserNo int(11) NOT NULL,
  FOREIGN KEY (UserNo) REFERENCES users(UserNo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data for table 'recipes'
INSERT INTO recipes (RecipeName, RecipeDescription, RecipeSteps, RecipeCookTime, Ingredient1, Ingredient2, Ingredient3, Ingredient4, Ingredient5, Ingredient6, Ingredient7, Ingredient8, Ingredient9, Ingredient10, IsPublic, ImgFile, UserNo) VALUES
('Peanut Butter and Jelly', 'Yummy sandwich', 'Put ingredients on bread and enjoy.', '5 minutes', 'Crunchy Peanut Butter', 'Grape Jelly', 'Bread', '', '', '', '', '', '', '', 1, 'rock_climbing_summit.jpg', 1),
('Grilled Cheese', 'Another yummy sandwich', 'Put cheese on bread, heat it, and eat it.', '10 minutes', 'American Cheese', 'Bread', '', '', '', '', '', '', '', '', 1, 'rock_climbing_summit.jpg', 1),
('Chili', 'Delicious meaty stew', 'Brown meat and add all ingredients. Cook for one hour and enjoy.', '1 hour and 15 minutes', '1 1/2 lb. ground beef', '1 can kidney beans', '1 can pinto beans', '4 T. chili powder', '1 T. cumin', '2 tsp. garlic powder', '1 can diced tomatoes', '1 can yellow corn', '1 can of beer', '1 T. Tabasco', 1, 'chili.jpg', 1);

-- Table structure for table 'user_recipes'
DROP TABLE IF EXISTS user_recipes;
CREATE TABLE user_recipes (
  SavedRecipeNo int(15) AUTO_INCREMENT PRIMARY KEY,
  UserNo int(11) NOT NULL,
  RecipeNo int(11) NOT NULL,
  FOREIGN KEY (UserNo) REFERENCES users(UserNo),
  FOREIGN KEY (RecipeNo) REFERENCES recipes(RecipeNo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data for table 'user_recipes'
INSERT INTO user_recipes (UserNo, RecipeNo)
VALUES (1, 1), (1, 2), (1, 3);

-- Add user account: User ID: RB_user Password: password
DROP USER IF EXISTS RB_user;
CREATE USER RB_user@'%' IDENTIFIED VIA mysql_native_password USING '*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19';
GRANT ALL PRIVILEGES ON recipeBook.* TO RB_user@'%' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
