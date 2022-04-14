@managing_pets
Feature: Editing an pet
    In order to change information about a pet
    As an Administrator
    I want to be able to edit the pet

    Background:
        Given there is a default locale
        And there is a pet with name "Homer"
        And I am logged in as an administrator

    @ui
    Scenario: Renaming an existing pet
        When I want to edit this pet
        And I change its name to "Pangolin"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And the pet "Pangolin" should appear in the list
