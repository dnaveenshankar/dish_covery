<?php
// Start session to retrieve username
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dishcovery</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        body {
            background-color: #ffbd59;
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            width: 100%;
            overflow: auto; /* Add overflow property for scrolling */
            max-height: 100vh;
            margin-top: 50px;
        }

        #suggestedDishes {
            margin-top: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        .mb-2 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Dishcovery</h2>
        <form id="ingredientForm">
            <div class="form-group" id="ingredientInputs">
                <label for="ingredients">Enter Ingredients:</label>
                <input type="text" class="form-control mb-2 ingredient" name="ingredient[]" placeholder="Ingredient" required>
            </div>
            <button type="button" class="btn btn-secondary btn-sm" id="addIngredientBtn">Add Ingredient</button>
            <button type="submit" class="btn btn-primary">Smart Search</button>
        </form>
        <div id="suggestedDishes"></div>
        <button onclick="goBack()" class="btn btn-secondary mt-3">Back</button>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function(){
            // Define available ingredients for auto-fill
            var availableIngredients = [
                "Rice", "Dal - Pulses", "Coconut", "Tamarind", "Mustard seeds", "Cumin seeds", "Fenugreek seeds",
                "Coriander seeds", "Dried red chilies", "Black pepper", "Turmeric powder", "Curry leaves", "Eggplant",
                "Okra", "Drumstick", "Tomato", "Potato", "Coriander leaves", "Mint leaves", "Spinach", "Fenugreek leaves",
                "Ghee - Clarified butter", "Coconut oil", "Sesame oil", "Peanut oil", "Jaggery", "Sugar", "Rice flour",
                "Gram flour - Besan", "Green chilies", "Onions", "Garlic", "Ginger", "Green beans", "Carrots", "Beetroot",
                "Cabbage", "Cauliflower", "Bottle gourd - Lauki", "Ridge gourd", "Turmeric leaves", "Asafoetida - Hing",
                "Cardamom", "Cinnamon", "Cloves", "Nutmeg", "Star anise", "Bay leaves", "Poppy seeds", "Cashew nuts",
                "Peanuts", "Almonds", "Pistachios", "Raisins", "Saffron", "Basmati rice", "Idli rice", "Raw rice",
                "Sona masuri rice", "Parboiled rice", "Puffed rice - Pori", "Wheat flour", "Millets - Foxtail, Pearl, Finger",
                "Lentils - Toor dal, Urad dal, Chana dal, Moong dal", "Rice flakes - Aval", "Vermicelli - Semiya",
                "Tapioca pearls - Sago", "Semolina - Rava", "Wheat noodles", "Sourdough starter", "Yogurt", "Buttermilk",
                "Paneer", "Coconut milk", "Milk", "Garam masala", "Sambar powder", "Rasam powder", "Curry powder",
                "Chutneys - Coconut, Tomato, Mint, Coriander", "Pickles - Mango, Lime, Garlic", "Vinegar", "Soy sauce",
                "Green gram - Moong", "Bengal gram - Chickpeas", "Sesame seeds", "Curry paste", "Ajwain - Carom seeds",
                "Pomegranate seeds", "Fresh turmeric", "Palm sugar", "Palm jaggery", "Cumin powder", "Red chili powder",
                "Paprika", "Mustard oil", "Rock salt", "Black salt", "Fenugreek powder", "Mustard oil", "Pickles - Mango, Lime, Garlic", "Vinegar", "Soy sauce",
                "Green gram - Moong", "Bengal gram - Chickpeas", "Sesame seeds", "Curry paste", "Ajwain - Carom seeds",
                "Pomegranate seeds", "Fresh turmeric", "Palm sugar", "Palm jaggery", "Cumin powder", "Red chili powder",
                "Paprika", "Mustard oil", "Rock salt", "Black salt", "Fenugreek powder", "Mustard oil"
            ];

            // Initialize autocomplete for each ingredient input field
            $('.ingredient').each(function(){
                $(this).autocomplete({
                    source: availableIngredients,
                    minLength: 1
                });
            });

            // Add ingredient button functionality
            $('#addIngredientBtn').click(function(){
                $('#ingredientInputs').append('<input type="text" class="form-control mb-2 ingredient" name="ingredient[]" placeholder="Ingredient" required>');
                $('.ingredient').autocomplete({
                    source: availableIngredients,
                    minLength: 1
                });
            });

            // Form submission handling
            $('#ingredientForm').submit(function(e){
                e.preventDefault();
                var ingredients = $('input[name="ingredient[]"]').map(function(){return $(this).val();}).get().join(',');

                $.ajax({
                    type: 'POST',
                    url: 'process_dishcovery.php',
                    data: { ingredients: ingredients },
                    success: function(response){
                        $('#suggestedDishes').html(response);
                    }
                });
            });
        });
        // Function to go back one step in the browsing history
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
