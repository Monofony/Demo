@managing_pets
Feature: Adding a new pet
    In order to create new pet
    As an Administrator
    I want to add a pet to the list

    Background:
        Given there is a default locale
        And I am logged in as an administrator
        And there is a taxon with name "Amphibie"

    @ui
    Scenario: Adding a new pet
        Given I want to create a new pet
        When I specify its name as "Axolotl"
        And I choose "Amphibie" as its taxon
        And I add it
        Then I should be notified that it has been successfully created
        And the pet "Axolotl" should appear in the list
