@managing_animals
Feature: Adding a new animal with taxon
    In order to create new animal with taxon
    As an Administrator
    I want to add a animal to the list

    Background:
        Given I am logged in as an administrator
        And there is a taxon with name "Amphibie"

    @ui @javascript
    Scenario: Adding a new animal with taxon
        Given I want to create a new animal
        When I specify its name as "Axolotl"
        And I specify its taxon as "Amphibie"
        And I add it
        Then I should be notified that it has been successfully created
        And the animal "Axolotl" should appear in the list
