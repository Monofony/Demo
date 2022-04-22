@viewing_pets
Feature: Viewing an pet details
    In order to see pets detailed information
    As a Visitor
    I want to be able to view a single pet

    Background:
        Given there is a default locale
        And pets are classified under "Cats" and "Dogs" categories
        And there is also a pet with name "Gizmo"
        And this pet belongs to "Dogs"

    @ui
    Scenario: Viewing a detailed page with pet's name
        Given I check this pet's details
        And I should see the pet name "Gizmo"
