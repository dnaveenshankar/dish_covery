<?php

function generateAutoFillIngredientsScript($enteredIngredients = array()) {
    $availableIngredients = array(
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
        "Paprika", "Mustard oil", "Rock salt", "Black salt", "Fenugreek powder", "Mustard oil",
       
    );

    // Merge entered ingredients with available ingredients
    $allIngredients = array_merge($availableIngredients, $enteredIngredients);

    $script = '<script>';
    $script .= '$(function() {';
    $script .= 'var availableIngredients = ' . json_encode($allIngredients) . ';';
    $script .= '$("#ingredients").autocomplete({';
    $script .= 'source: availableIngredients,';
    $script .= 'minLength: 1,';
    $script .= 'autoFocus: true,';
    $script .= 'delay: 100';
    $script .= '});';
    $script .= '});';
    $script .= '</script>';

    return $script;
}

?>
