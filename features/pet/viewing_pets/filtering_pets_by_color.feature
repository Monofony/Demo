@viewing_pets
Feature: Filtering pets from a specific color
    In order to browse pets that interest me most
    As a Visitor
    I want to be able to filter pets from a specific color

    Background:
        Given there is a default locale
        And pets are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Winnie"
        And this pet belongs to "Cats"
        And this pet is black
        And there is also a pet with name "Albert"
        And this pet belongs to "Dogs"
        And this pet is black
        And there is also a pet with name "Gizmo"
        And this pet belongs to "Cats"
        And this pet is white

    @ui @javascript
    Scenario: Filtering pets from a specific color
        Given I want to browse pets
        Then I only want to see the black pets
        And I should see the pet "Winnie"
        But I should not see the pet "Gizmo"

    @ui @javascript
    Scenario: Filtering pets from a specific color with a specific taxon
        Given I browse pets from taxon "Cats"
        Then I only want to see the black pets
        And I should see the pet "Winnie"
        But I should not see the pet "Gizmo"
        But I should not see the pet "Albert"
