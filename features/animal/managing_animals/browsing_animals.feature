@managing_animals
Feature: Browsing animals
    In order to see all animals
    As an Administrator
    I want to browse animals

    Background:
        Given there is an animal with name "Kitty"
        And there is also an animal with name "Winnie"
        And there is also an animal with name "Gizmo"
        And I am logged in as an administrator

    @ui
    Scenario: Browsing animals
        When I want to see all animals
        Then I should see 3 animals in the list
        And I should see the animal "Kitty" in the list
