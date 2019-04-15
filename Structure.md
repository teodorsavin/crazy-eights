## Rules
- Take a deck of 52 cards (Ace to King, four suits, no jokers) and shuffle
- Give five cards to each player (up to six players). The remaining cards become the *drawing stack*
- To determine the player order, count each players cards and sort from highest to lowest. For example, if a player holds Ace, Two, Five, Seven, Nine, their total is 24. If there are conflicts, then randomly select who goes first in the conflicting group
- Reveal one card from the drawing stack. This is the *played stack*
- Each player can play a card if one of their cards matches the topmost card in the played stack either by suit or by value - for example, if the top-most card is a 7 of hearts, the player can play any suit with a value of 7, or any card with a suit of hearts.
- If the player does not have any cards that can be played, they must take a card from the drawing stack
- The game loops until a player has zero cards (the game immediately ends and becomes the winner), or the drawable stack is empty and no cards can be played by any player (an impossible game)

## Structure

### Card

- properties
    - suite
    - rank

### Deck

- properties
    - suits
    - ranks
    - cards[]
    - init()
    - shuffle()
    - drawFromDeck()

### Player

- properties
    - name
    - cards[]
- methods
    - playCard()
    - drawCard()

### Game

- properties
    - cardsPerPlayer
    - maxPlayers
    - players[]<Player>
    - deck
    - discardedPile[]<Card>
- methods
    - findStartingPlayer
    - initiateGame
    

### Plan
1. Create the interfaces for the structure:
    - deck, card, player
2. Create interface for game
3. Create gameFactory to make it scalable to support more games
3. Implement the Card class and Deck class first
    - use shuffle function from php since I don't care about the keys
4. Play game:
    - while no player is without cards:
        - check if player has card in hand to play based on lastCardPlayed
            - yes 
                - play card
                    - set new lastCardPlayed
                - check if player still has cards in his hand
                    - no cards 
                        - set player without cards flag
                        - set player as winner
                    - yes -> do nothing
                - continue (go to next player)
            - no 
                - check if there are cards in deck
                    - no -> do nothing
                    - yes
                        - draw card
                - continue (go to next player)

### Questions
1. What happens if there are no more cards in the deck and the game is not over yet ?
2. What happens if there are no more cards in the deck and the game is not over yet and the player does not have any card to put down ?
3. What happens when the game is over ? New Deck or reset the deck ?
4. 
