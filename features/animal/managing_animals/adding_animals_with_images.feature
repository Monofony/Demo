@managing_animals
Feature: Adding a new animal with images
    In order to create new animal
    As an Administrator
    I want to add a animal to the list

    Background:
        Given I am logged in as an administrator

    @ui @javascript
    Scenario: Adding a new animal with images
        Given I want to create a new animal
        When I specify its name as "Axolotl"
        And I attach the "Axolotl.jpg" image
        And I add it
        Then I should be notified that it has been successfully created
        And the animal "Axolotl" should have one image