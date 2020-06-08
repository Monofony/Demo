@viewing_pets
Feature: Viewing pets from a specific taxon
    In order to browse pets that interest me most
    As a Visitor
    I want to be able to view pets from a specific taxon

    Background:
        Given pets are classified under "Cats" and "Dogs" categories
        And there is also a pet with name "Winnie"
        And this pet belongs to "Cats"
        And there is also a pet with name "Gizmo"
        And this pet belongs to "Dogs"

    @ui
    Scenario: Viewing pets from a specific taxon
        When I browse pets from taxon "Cats"
        Then I should see the pet "Winnie"
        And I should not see the pet "Gizmo"
