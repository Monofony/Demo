@viewing_pets
Feature: Filtering pets from a specific taxon
    In order to browse pets that interest me most
    As a Visitor
    I want to be able to filter pets from a specific taxon

    Background:
        Given pets are classified under "Cats" and "Dogs" categories
        And there is also a pet with name "Winnie"
        And this pet belongs to "Cats"
        And there is also a pet with name "Gizmo"
        And this pet belongs to "Dogs"

    @ui
    Scenario: Filtering pets from a specific taxon
        Given I want to browse pets
        Then I filter from taxon "Cats"
        And I should see the pet "Winnie"
        But I should not see the pet "Gizmo"
