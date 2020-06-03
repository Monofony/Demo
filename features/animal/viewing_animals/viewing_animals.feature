@viewing_animals
Feature: Viewing animals
    In order to see animals
    As a Visitor
    I want to be able to browse animals

    Background:
        Given animals are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Kitty"
        And this pet belongs to "Cats"
        And there is also a pet with name "Winnie"
        And this pet belongs to "Cats"
        And there is also a pet with name "Gizmo"
        And this pet belongs to "Dogs"

    @ui
    Scenario: Viewing animals
        Given I want to browse animals
        Then I should see the animal "Winnie"
        And I should see the animal "Kitty"
