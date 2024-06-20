<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Dish - Dish' Covery</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery UI CSS -->
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
        }

        .form-group label {
            color: #000;
            text-align: left;
        }

        .ingredient-input {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4 text-center" style="color: #f8c000;">Add Dish</h2>
    <form id="addDishForm" method="post" action="process_add_dish.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image">Image (optional)</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <div class="form-group">
            <label for="dishName">Dish Name</label>
            <input type="text" class="form-control" id="dishName" name="dishName" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select class="form-control" id="type" name="type" required>
                <option value="Veg">Veg</option>
                <option value="Non Veg">Non Veg</option>
            </select>
        </div>
        <div id="ingredientInputs">
            <!-- Ingredient input fields will be added here -->
        </div>
        <div class="form-group">
            <label for="ingredients">Add Ingredients</label>
            <div class="input-group">
                <input type="text" class="form-control" id="ingredientInput" name="ingredientInput">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="addIngredientBtn">Add</button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="cookingTime">Cooking Time (in Mins)</label>
            <input type="number" class="form-control" id="cookingTime" name="cookingTime" required>
        </div>
        <div class="form-group">
            <label for="process">Process</label>
            <textarea class="form-control" id="process" name="process" required></textarea>
        </div>
        <div class="form-group">
            <label for="cuisine">Cuisine</label>
            <select class="form-control" id="cuisine" name="cuisine" required>
                <option value="Sweet">Sweet</option>
                <option value="Tamil Cuisine">Tamil Cuisine</option>
                <option value="Punjabi Cuisine">Punjabi Cuisine</option>
                <option value="Kerala Cuisine">Kerala Cuisine</option>
                <option value="North Indian Cuisine">North Indian Cuisine</option>
                <option value="South Indian Cuisine">South Indian Cuisine</option>
                <option value="Other Cuisines">Other Cuisines</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <br>
    <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
</div>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>
    // Function to display an alert
    function showAlert() {
        alert("Dish added successfully!");
    }

    $(function() {
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

        $("#ingredientInput").autocomplete({
            source: availableIngredients,
            minLength: 1,
            autoFocus: true,
            delay: 100
        });

        // Add ingredient to a separate input box
        $("#addIngredientBtn").on("click", function() {
            var ingredient = $("#ingredientInput").val().trim();
            if (ingredient) {
                var ingredientInput = '<input type="text" class="form-control ingredient-input" name="ingredients[]" value="' + ingredient + '" readonly>';
                $("#ingredientInputs").append(ingredientInput);
                $("#ingredientInput").val(""); // Clear the input field after adding ingredient
            }
        });

        // Form submission handler
        $("#addDishForm").submit(function(e) {
            e.preventDefault(); // Prevent form from submitting normally

            $.ajax({
                type: "POST",
                url: "process_add_dish.php", // URL to submit the form data
                data: new FormData(this), // Serialize form data
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    // Show alert upon successful submission
                    showAlert();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

</body>
</html>
