# Crazy Eights

#### Structure

I have structured project in 2 folders app - dependency injection and src - source code of the project

#### Classes & Interfaces
It may seem an overkill to have so many interfaces and classes for such a small project, but I tried to decouple as much as possible.
In the future it could be added a Factory for the Game Class to be able to add more games, not only Crazy Eights.

#### Dependency injection
I used composer package php-di, to bind interfaces to concrete classes. That way I can inject Interfaces into constructors of the objects. Interfaces provide a contract between classes and implementation.

#### Possible improvements
- Make the number of players dynamic from the console.
- Make the names of the players dynamic from the console.
- Split the play method into multiple smaller methods.
- Add tests

#### How to run?
1. ```composer install```
2. Run the script ```php play.php```
