# Vending Machine PHP Application

## Project Description

This PHP-based vending machine application simulates the functionality of a real-world vending machine. Users can insert coins, select drinks, and receive change if necessary. The system keeps track of the available stock of drinks and the availability of change in the machine. The project also includes an admin panel where authorized users can manage the stock of drinks and refill the coin storage.

### Features

- **Insert Coins**: Users can insert coins and see the total amount they have entered.
- **Select Drinks**: Users can select from a list of available drinks.
- **Wisselgeld (Change)**: The system calculates and returns the correct change after purchasing a drink.
- **Admin Panel**: Authorized administrators can manage drink inventory and refill the coin tray.
- **Error Handling**: Displays appropriate messages if the drink is out of stock, insufficient coins are inserted, or there is insufficient change.
  
## Project Structure

### Controllers

- **index.php**: This is the main entry point for users to interact with the vending machine. It handles inserting coins, selecting drinks, and returning change.
- **admin.php**: This is the admin panel where authorized users can manage drink stock and the coin tray.

### Services (Business Logic)

- **FrisdrankService**: Manages the drinks, including retrieving prices, stock levels, and modifying inventory (increase/decrease stock).
- **MuntService**: Handles all coin-related logic, such as accepting inserted coins, calculating change, and managing the coin tray inventory.

### Data Layer

- **MuntDAO**: Data Access Object (DAO) for handling coin-related database operations, such as retrieving coin denominations and their availability in the tray.

### Exceptions

- **FrisdrankNotFoundException**: Thrown when a user tries to select a drink that doesn't exist.
- **FrisdrankUitverkochtException**: Thrown when a drink is out of stock.
- **FrisdrankMaxCapaciteitBereiktException**: Thrown when trying to add more drinks than the maximum allowed capacity.
  
## Features Overview

### User Side

- **Insert Coins**: Users can choose from predefined coin values and insert them into the machine.
- **Select a Drink**: Users can select from available drinks, and the machine checks if the user has inserted enough money. If successful, the machine dispenses the drink and returns the appropriate change.
- **Error Handling**: If insufficient coins are inserted or the selected drink is out of stock, users are shown appropriate error messages.

### Admin Side

- **Manage Drink Stock**: Admins can increase or decrease the stock of drinks.
- **Refill Coin Tray**: Admins can refill or empty the coin tray.
- **Error Handling**: If admins try to add too many drinks or decrease stock below zero, appropriate error messages are displayed.

## Usage Instructions

### User Side

1. **Inserting Coins**: Users can insert coins of predefined values.
2. **Select a Drink**: Once sufficient money is inserted, users can select their desired drink.
3. **Receive Change**: After selecting the drink, if any change is required, it will be returned.

### Admin Side

1. **Log in**: Admins must log in to access the admin panel.
2. **Manage Stock**: Increase or decrease the stock of available drinks.
3. **Manage Coin Tray**: Refill or empty the coin tray as needed.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Future Enhancements

- **User Authentication**: Implement authentication for regular users to track purchases or offer loyalty rewards.
- **Multiple Currency Support**: Add support for multiple currencies and denominations.
- **Enhanced Admin Features**: Implement more granular control over stock and coin management, with reporting tools.

--- 

This README provides an overview of the system, how to install it, and instructions for using both the user-facing and admin-side functionalities. You can modify the sections as per your project requirements!
