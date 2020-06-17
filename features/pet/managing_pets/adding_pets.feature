@managing_pets
Feature: Adding a new pet
    In order to create new pet
    As an Administrator
    I want to add a pet to the list

    Background:
        Given I am logged in as an administrator

    @ui
    Scenario: Adding a new pet
        Given I want to create a new pet
        When I specify its name as "Axolotl"
        And I add it
        Then I should be notified that it has been successfully created
        And the pet "Axolotl" should appear in the list

    @ui
    Scenario: Adding a new pet with sex
        Given I want to create a new pet
        When I specify its name as "Axolotl"
        And I specify its sex as "male"
        And I add it
        Then I should be notified that it has been successfully created
        And the pet "Axolotl" should appear in the list

    @ui
    Scenario: Adding a new pet with its characteristic fields
        Given I want to create a new pet
        When I specify its name as "Axolotl"
        And I specify its size as "12"
        And I specify its size unit as "centimeter"
        And I add it
        Then I should be notified that it has been successfully created
        And the pet "Axolotl" should appear in the list
