@viewing_pets
Feature: Viewing pets
    In order to see pets
    As a Visitor
    I want to be able to browse pets

    Background:
        Given pets are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Kitty"
        And this pet belongs to "Cats"
        And there is also a pet with name "Winnie"
        And this pet belongs to "Cats"
        And there is also a pet with name "Gizmo"
        And this pet belongs to "Dogs"

    @ui
    Scenario: Viewing pets
        Given I want to browse pets
        Then I should see the pet "Winnie"
        And I should see the pet "Kitty"
