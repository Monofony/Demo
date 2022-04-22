@viewing_pets
Feature: Viewing pets
    In order to see pets
    As a Visitor
    I want to be able to browse pets

    Background:
        Given there is a default locale
        And there is a pet with name "Kitty"
        And there is also a pet with name "Winnie"
        And there is also a pet with name "Gizmo"

    @ui
    Scenario: Viewing pets in the list
        Given I want to browse pets
        Then I should see the pet "Winnie"
        And I should see the pet "Kitty"
