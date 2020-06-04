@managing_pets
Feature: Family projects validation
    In order to avoid making mistakes when adding a new pet
    As an Administrator
    I want to be prevented from adding it without specifying required fields

    Background:
        Given I am logged in as an administrator

    @ui
    Scenario: Trying to add a new pet without name
        Given I want to create a new pet
        When I do not specify any name
        And I try to add it
        Then I should be notified that the name is required
        And this pet should not be added

    @ui
    Scenario: Trying to add a new pet with size but without size unit
        Given I want to create a new pet
        When I specify its name as "Axolotl"
        And I specify its size as "12"
        But I do not specify any size unit
        And I try to add it
        Then I should be notified that the "size unit" is required
        And this pet should not be added
