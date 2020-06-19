@viewing_pets
Feature: Filtering pets from a specific sex
    In order to browse pets that interest me most
    As a Visitor
    I want to be able to filter pets from a specific sex

    Background:
        Given pets are classified under "Cats" and "Dogs" categories
        And there is also a pet with name "Winnie"
        And this pet belongs to "Cats"
        And this pet is a male
        And there is also a pet with name "Gizmo"
        And this pet belongs to "Dogs"
        And this pet is a female

    @ui
    Scenario: Filtering pets from a specific sex
        Given I want to browse pets
        Then I only want to see the males
        And I should see the pet "Winnie"
        But I should not see the pet "Gizmo"
