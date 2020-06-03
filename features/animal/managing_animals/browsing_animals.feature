@managing_animals
Feature: Browsing animals
    In order to see all animals
    As an Administrator
    I want to browse animals

    Background:
        Given animals are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Kitty"
        And this pet belongs to "Cats"
        And there is also a pet with name "Winnie"
        And this pet belongs to "Cats"
        And there is also a pet with name "Gizmo"
        And this pet belongs to "Dogs"
        And I am logged in as an administrator

    @ui
    Scenario: Browsing animals
        When I want to see all animals
        Then I should see 3 animals in the list
        And I should see the animal "Kitty" in the list
