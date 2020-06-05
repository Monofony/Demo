@managing_pets
Feature: Browsing pets
    In order to see all pets
    As an Administrator
    I want to browse pets

    Background:
        Given pets are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Kitty"
        And this pet belongs to "Cats"
        And there is also a pet with name "Winnie"
        And this pet belongs to "Cats"
        And there is also a pet with name "Gizmo"
        And this pet belongs to "Dogs"
        And I am logged in as an administrator

    @ui
    Scenario: Browsing pets
        When I want to see all pets
        Then I should see 3 pets in the list
        And I should see the pet "Kitty" in the list
