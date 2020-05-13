@managing_animals
Feature: Family projects validation
    In order to avoid making mistakes when adding a new animal
    As an Administrator
    I want to be prevented from adding it without specifying required fields

    Background:
        Given I am logged in as an administrator

    @ui
    Scenario: Trying to add a new animal without name
        Given I want to create a new animal
        When I do not specify any name
        And I try to add it
        Then I should be notified that the name is required
        And this animal should not be added