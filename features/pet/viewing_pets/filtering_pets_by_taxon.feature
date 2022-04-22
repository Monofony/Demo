@viewing_pets
Feature: Filtering pets from a specific taxon
    In order to browse pets that interest me most
    As a Visitor
    I want to be able to filter pets from a specific taxon

    Background:
        Given there is a default locale
        And pets are classified under "Cats" and "Dogs" categories
        And the "Cats" category has children category "Persian" and "Siamese"
        And there is also a pet with name "Winnie"
        And this pet belongs to "Persian"
        And there is also a pet with name "Gizmo"
        And this pet belongs to "Dogs"

    @ui @javascript
    Scenario: Filtering pets from a specific taxon
        Given I browse pets from taxon "Cats"
        Then I filter from taxon "Persian"
        And I should see the pet "Winnie"
        But I should not see the pet "Gizmo"
