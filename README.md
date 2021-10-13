# Simple-Web-App-Game-2019
# Dice Game
Game in which 3 rolls of dice are made one by one in any order, via an interface. These dice are numbered 1, 2 and 3. The number field
allows the user to indicate the number of the dice to roll, the roll of the dice is done via the __Roll button__. 

During a game, the same die must not be rolled more than once. a player rolls the same die more than once the application stops the game and the player receives
a score = -1.

If the result obtained for die number 1 is strictly lower than the result obtained for die number 2 number 2 and the result obtained for die number 2 is strictly 
lower than the result obtained for die number 3 number 3, then the player receives a score equal to the sum of the results obtained for the 3 dice. 3 dice.
Otherwise he receives a score of zero. 

The application has to stop the game once we can conclude about the score, for example if we about the score, e.g. 
if you get 6 for die number 1 there is no point in waiting for the results of the other dice, the score in this case is 0.

A game ends either after all 3 dice have been rolled or after the same die has been rolled twice or more. of the same die twice or because the condition 
"result (die 1) < result (die 2) < result (die 3)" is is surely not verified (case of having 6 for the first die for example).

At the end of a game, the application displays the score of the game that has just been played as well as the best score recorded on the application.
This application does not use a database.
