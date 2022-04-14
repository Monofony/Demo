@managing_pets
Feature: Browsing pets
    In order to see all pets
    As an Administrator
    I want to browse pets

    Background:
        Given there is a default locale
        And there is a pet with name "Kitty"
        And there is also a pet with name "Winnie"
        And there is also a pet with name "Gizmo"
        And I am logged in as an administrator

    @ui
    Scenario: Browsing all pets in the admin panel
        When I want to browse all pets
        Then I should see 3 pets in the list
        And I should see the pet "Kitty" in the list
