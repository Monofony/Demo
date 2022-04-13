@managing_pets
Feature: Pets validation
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

