@viewing_pets
Feature: Filtering pets from a specific size
    In order to browse pets that interest me most
    As a Visitor
    I want to be able to filter pets from a specific size

    Background:
        Given there is a default locale
        And there is a taxon with name "Cats"
        And this taxon contains small pets
        And there is also a taxon with name "Dogs"
        And this taxon contains medium pets
        And there is also a pet with name "Winnie"
        And this pet belongs to "Cats"
        And there is also a pet with name "Gizmo"
        And this pet belongs to "Dogs"
        And there is also a pet with name "Miguel"
        And this pet belongs to "Dogs"

    @ui @javascript
    Scenario: Filtering pets from a specific size
        Given I want to browse pets
        Then I only want to see the small pets
        And I should see the pet "Winnie"
        But I should not see the pet "Gizmo"
        But I should not see the pet "Miguel"
